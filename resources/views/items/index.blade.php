@extends('layouts.app')

@section('css')
  <link rel="stylesheet" href="{{ asset('css/items/index.css') }}">
@endsection

@section('title', '買い物リスト')

@section('content')
  <div class="to__buy__list">

    {{-- 商品登録画面ポップアップ --}}
    <livewire:item-registration-modal />

      <form method="POST" action="{{ route('items.completeMultiple') }}">
        @csrf
        @method('PATCH')

          <div class="complete__all__at__once">
            <button onclick="return confirm('まとめて購入済みにしますか？')">まとめて購入完了</button>
          </div>
      
      {{-- 登録商品リストテーブル表示欄 --}}
      <livewire:item-list />

      </form>

  </div>
@endsection