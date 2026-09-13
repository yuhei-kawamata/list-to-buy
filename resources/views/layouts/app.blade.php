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
  
  <main>
    
    @if(session('success'))
      <div class="alert__success__area">
      <div class="alert__success">
          {{ session('success') }}
        </div>
      </div>
    @endif
      
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