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

      <a class="header__bought__list" href="/items/purchase_history">
        購入履歴
      </a>
      
      <form method="POST" action="{{ route('logout') }}">
      @csrf
        <button class="header__button" type="submit">ログアウト</button>
      </form>
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