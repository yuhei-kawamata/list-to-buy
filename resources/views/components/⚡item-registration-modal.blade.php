<?php

use App\Models\Item;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

new class extends Component
{
    // ポップアップはデフォルトは開かない設定
    public $isOpen = false;

    // フォームに入力する変数の定義
    public $name = '';
    public $store_name = '';
    public $quantity = 1;
    public $user_id;
    public $hurry_flag = 0;

    protected $rules = [
        'name' => 'required|string|max:255',
        'store_name' => 'nullable|string|max:255',
        'quantity' => 'required|integer|min:0|max:10',
        'user_id' => 'required|exists:users,id',
        'hurry_flag' => 'boolean',
    ];

    public function with()
    {
        return [
            // 過去の「商品名」重複なし最新10件
            'suggestNames' => Item::query()
                ->whereNotNull('name')
                ->select('name')
                ->groupBy('name')
                ->orderByRaw('MAX(created_at) DESC')
                ->take(10)
                ->pluck('name'),

            // 過去の「買う場所」重複なし最新10件
            'suggestStores' => Item::query()
                ->whereNotNull('store_name')
                ->select('store_name')
                ->groupBy('store_name')
                ->orderByRaw('MAX(created_at) DESC')
                ->take(10)
                ->pluck('store_name'),
        ];
    }

    // ポップアップを開く
    public function openModal()
    {
        $this->resetValidation();
        
        $this->reset([
            'name',
            'store_name',
            'quantity',
            'hurry_flag'
        ]);
        
        $this->isOpen = true;
    }

    // ポップアップを閉じる
    public function closeModal()
    {
        $this->isOpen = false;
    }

    // 登録処理
    public function store()
    {
        $this->user_id = Auth::id();

        $validated = $this->validate();
        Item::create($validated);
        
        $this->closeModal();
        $this->dispatch('item-created', message: '商品を登録しました');
        }
};
?>

<div>
    <!-- ①【常に表示される領域】トリガーボタン -->
    <div class="list__registration__title">
        <button type="button" wire:click="openModal">欲しいものを登録</button>
    </div>

    <!-- ②【モーダル領域】$isOpenがtrueの時だけ、既存要素の上に重なって表示する -->
    @if($isOpen)
    <div class="custom-modal-overlay" wire:click.self="closeModal">
        <div class="custom-modal-card">
            
            <div class="list__registration__title">
                何が欲しいですか？
            </div>

            <form wire:submit.prevent="store">
                <div class="list__registration__area">
                    
                    <!-- 買いたいもの（商品名） -->
                    <div class="form-group">
                        <input 
                            type="text" 
                            wire:model="name" 
                            list="suggest-item-names" 
                            autocomplete="off" 
                            placeholder="買いたいもの"
                        >
                        <datalist id="suggest-item-names">
                            @foreach($suggestNames as $suggestName)
                                <option value="{{ $suggestName }}"></option>
                            @endforeach
                        </datalist>

                        @error('name')
                            <div class="error__message">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    
                    <!-- 買う場所 -->
                    <div class="form-group">
                        <input 
                            type="text" 
                            wire:model="store_name" 
                            list="suggest-store-names" 
                            autocomplete="off" 
                            placeholder="買う場所"
                        >
                        <datalist id="suggest-store-names">
                            @foreach($suggestStores as $suggestStore)
                                <option value="{{ $suggestStore }}"></option>
                            @endforeach
                        </datalist>

                        @error('store_name') 
                            <div class="error__message">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <input type="number" wire:model="quantity" min="1" max="10">
                        @error('quantity')
                            <div class="error__message">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
            
                    <div class="list__registration__area__hurry">
                        <label for="hurry_flag">すぐ欲しい？</label>
                        <input type="checkbox" wire:model="hurry_flag" id="hurry_flag" value="1">
                    </div>
                    
                    <div class="modal-actions">
                        <button type="submit">登録</button>
                        <button type="button" wire:click="closeModal">キャンセル</button>
                    </div>

                </div>
            </form>

        </div>
    </div>
    @endif
</div>