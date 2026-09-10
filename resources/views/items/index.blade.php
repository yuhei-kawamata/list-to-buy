@extends('layouts.app')

@section('css')
  <link rel="stylesheet" href="{{ asset('css/items/index.css') }}">
@endsection

@section('title', '買い物リスト')

@section('content')
  <div class="to__buy__list">

    {{-- 商品登録画面ポップアップ --}}
    <livewire:item-registration-modal/>
    
    {{-- 登録商品リストテーブル表示欄 --}}
    <livewire:item-list />

  </div>
@endsection