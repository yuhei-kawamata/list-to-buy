@extends('layouts.app')

@section('css')
  <link rel="stylesheet" href="{{ asset('css/items/purchase_history.css') }}">
@endsection

@section('title', '購入履歴')

@section('content')
  <div class="bought__list">

    <div>
      <form method="GET" action="{{ route('items.search') }}">

        <div class="search__form__title">
          検索
        </div>

        <div class="search__form__area">
          <input type="text" name="keyword_name" placeholder="商品名" value="{{ old('keyword_name') }}">

          <input type="text" name="keyword_store_name" placeholder="買った場所" value="{{ old('keyword_store_name') }}">

          <div class="search__button__area">
            <button type="submit">検索</button>
            <button><a herf={{ route('items.purchaseHistoryShow') }}>クリア</a></button>
          </div>

        </div>
      </form>

    </div>

    <div class="bought__list__area">
      購入履歴

      <div class="bought__list__table">
        <table class="bought__list__table__area">
          <tr class="bought__list__table__header">
            <th></th>
            <th>商品名</th>
            <th>場所</th>
            <th>購入日</th>
            <th></th>
          </tr>

          @foreach ($items as $item)
          <tr class="bought__list__table__body">
            <td class="bought__list__table__repurchase">
              {{-- 商品再購入ポップアップ --}} 
              <livewire:item-repurchase-modal :item="$item" :key="'repurchase-modal-'.$item->id" />

            </td>
            
            <td>{{ $item->name }}</td>
            <td>{{ $item->store_name }}</td>
            <td>{{ $item->updated_at->format('Y年m月d日') }}</td>

            <td class="bought__list__table__delete">
                <form method="POST" action="{{ route('items.purchaseHistorydestroy', $item->id) }}">
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

  </div>
@endsection