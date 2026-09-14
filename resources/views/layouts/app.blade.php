<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="{{ asset('css/layouts/app.css') }}">
  @yield('css')
  <title>@yield('title', '買い物リスト')</title>
</head>

<body>
  <header class="header">
    <div class="header__inner">
      <a class="header__logo" href="{{ route('items.index') }}">
        買い物リスト
      </a>
      
      {{-- ハンバーガーメニュー --}}
      
      <input type="checkbox" id="drawer-checkbox" class="drawer-checkbox">
      
      <label for="drawer-checkbox" class="drawer-icon">
        <span></span>
        <span></span>
        <span></span>
      </label>
      
      <nav class="drawer-nav">
        <ul class="drawer-menu">
          <li><a href="{{ route('items.index') }}">買い物リスト</a></li>
          <li><a href="/items/purchase_history">購入履歴</a></li>
          <li>
            <form method="POST" action="{{ route('logout') }}">
              @csrf
              <input class="header__button" type="submit" value="ログアウト">
            </form>
            </li>
          </ul>
        </nav>
        
      </div>
  </header>
  
{{-- モーダルを使って登録した際にフラッシュメッセージが表示されるように必要な設定
      後々使用するmessageとshowを定義し、Laravelの通常のセッションも表示できるように設定
      セッションが無ければ、showは'false'（非表示）とする
--}}
  <main x-data="{ 
            message: '{{ session('success') }}', 
            show: {{ session()->has('success') ? 'true' : 'false' }} 
        }"

        {{-- モーダルの中に設定している$this->dispatch('item-created', message:'商品を登録しました');
              が実行されたらフラッシュメッセージを表示する、という設定
              '商品を登録しました'をmessageに格納して、表示をオン（show = true）にする
        --}}
        x-on:item-created="message = $event.detail.message; show = true;">

    {{-- showがtrueになったら、メッセージエリア（<div class="alert__succes__area">以下）
          を表示させる。x-textに"message"の中身を格納する（'商品を登録しました'）
    --}}
    <template x-if="show">
        <div class="alert__success__area">
            <div class="alert__success" x-text="message"></div>
        </div>
    </template>
      
    @if(session('error'))
      <div class="alert__danger__area">
        <div class="alert__danger">
          {{ session('error') }}
        </div>
      </div>
    @endif
      
    @yield('content')
  </main>

</body>
</html>