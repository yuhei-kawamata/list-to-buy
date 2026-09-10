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

        $validated =$this->validate();
        Item::create($validated);

        $this->closeModal();
        $this->dispatch('item-created');
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
                    
                    <div class="form-group">
                        <input type="text" wire:model="name" placeholder="買いたいもの">
                        @error('name') <span class="error-message">{{ $message }}</span> @enderror
                    </div>
                    
                    <div class="form-group">
                        <input type="text" wire:model="store_name" placeholder="買う場所">
                        @error('store_name') <span class="error-message">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <input type="number" wire:model="quantity" min="1" max="10">
                        @error('quantity') <span class="error-message">{{ $message }}</span> @enderror
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