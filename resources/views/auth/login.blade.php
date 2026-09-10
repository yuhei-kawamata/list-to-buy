<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="{{ asset('css/auth/login.css') }}">
  <title>買い物リストアプリ ログイン</title>
</head>
<body>
  <div class="login">

  @if(session('error'))
      <div class="alert__danger__area">
        <div class="alert__danger">
          {{ session('error') }}
        </div>
      </div>
  @endif

    <div class="login__area">

      <div class="login__title">ログイン</div>

      <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="login__input__area">
          <label for="email">メールアドレス</label>
          <input class="input__area" type="text" id="email" name="email" value="{{ old('name') }}">
        </div>

        <div class="login__input__area">
          <label for="password">パスワード</label>
          <input class="input__area" type="password" id="password" name="password">
        </div>

        <div class="login__input__area">
          <button class="login__button" type="submit">ログイン</button>
        </div>

        <div class="login__input__area">
          <input class="login__checkbox" type="checkbox" id="remember" name="remember">
          <label for="remember">ログイン状態を保持する</label>
        </div>
      </form>

      <div class="link__register">
        <a href="/register">アカウントをお持ちでない方はこちら</a>
      </div>
    </div>
</body>
</html>