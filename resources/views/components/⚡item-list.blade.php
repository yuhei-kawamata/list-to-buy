<?php

use App\Models\Item;
use Livewire\Component;
use Livewire\Attributes\On;

new class extends Component
{
    // モーダル側で $this->dispatch('item-created') が実行されたらこの画面を自動更新する
    // 商品が登録されたら、買うものリストに自動で表示させるための機能
    #[On('item-created')]
    public function refreshList()
    {
        // イベント受信時に自動的に再描画される
    }

    public function with(): array
    {
        return [
            'items' => Item::with('user')
            ->where('complete_flag', 0)
            ->orderBy('hurry_flag', 'desc')
            ->orderBy('created_at', 'asc')
            ->get(),
        ];
    }

      // チェックボックスがクリックされたときに実行されるメソッド
    public function toggleHurry($id)
    {
        $item = Item::findOrFail($id);

        // フラグを反転させて保存（1なら0に、0なら1に）
        $item->hurry_flag = !$item->hurry_flag;
        $item->save();
    }
};

?>

<div class="to__buy__list__area">
    
        <div class="to__buy__list__table">
        <table class="to__buy__list__table__area">
        <tr class="to__buy__list__table__header">
            
            <th>購入<br>チェック</th>
            <th>急ぎ</th>
            <th>商品名</th>
            <th>場所</th>
            <th>個数</th>
            <th>登録者</th>
            <th>登録日</th>
            <th></th>
            <th></th>
        </tr>

            @foreach ($items as $item)
            {{-- Livewireを反映させるため、wire:keyを設定 --}}
            <tr class="to__buy__list__table__body" wire:key="item-{{ $item->id }}">

                {{-- 購入済みチェックフラグ --}}
                <td><input type="checkbox" name="items[]" value="{{ $item->id }}"></td>

                <td>
                    <input type="checkbox" name="hurry_flag" value="1" 
                    @checked($item->hurry_flag === 1) {{-- hurry_flagが１の時チェックが入るようにする --}}
                    wire:click="toggleHurry({{ $item->id }})">
                </td>

                <td>{{ $item->name }}</td>
                <td>{{ $item->store_name }}</td>
                <td>{{ $item->quantity }}個</td>
                
                <td>{{ $item->user->name }}</td>
                <td>{{ $item->created_at->format('m月d日') }}</td>

                <td class="to__buy__list__table__complete">
                <form method="POST" action="{{ route('items.complete', $item->id) }}">
                    @csrf
                    @method('PATCH')

                    <button type="submit">完了</button>
                </form>
                </td>
                
                <td class="to__buy__list__table__delete">
                <form method="POST" action="{{ route('items.destroy', $item->id) }}">
                    @csrf
                    @method('DELETE')
                
                    <button type="submit" onclick="return confirm('本当に削除しますか？')">削除</button>
                </form>
                </td>
            </tr>
            @endforeach
        </table>
    </div>
</div>