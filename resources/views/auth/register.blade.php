<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="{{ asset('css/auth/register.css') }}">
  <title>買い物リスト ユーザー登録</title>
</head>
<body>
  <div class="register">

    <div>
      @if($errors->any())
        @foreach ($errors->all() as $error)
        <ul>
          <li>{{ $error }}</li>
        </ul>
        @endforeach
      @endif
    </div>  

    <div class="register__area">

      <div class="register__title">ユーザー登録</div>
    
      <form method="POST" action="{{ route('register') }}">
        @csrf
        <div class="register__input__area">
          <label for="name">名前</label>
          <input class="input__area" type="text" id="name" name="name" value="{{ old('name') }}">
        </div>

        <div class="register__input__area">
          <label for="email">メールアドレス</label>
          <input class="input__area" type="email" id="email" name="email" value="{{ old('email') }}">
        </div>

        <div class="register__input__area">
          <label for="password">パスワード</label>
          <input class="input__area" type="password" id="password" name="password">
        </div>

        <div class="register__input__area">
          <label for="password_confirmaiton">パスワード（確認）</label>
          <input class="input__area" type="password" id="password_confirmation" name="password_confirmation">
        </div>

        <div class="register__input__area">
            <label for="is_admin">管理者として登録</label>
            <input type="hidden" name="is_admin" value="0">
            <input class="input__area__checkbox" type="checkbox" id="is_admin" name="is_admin" value="1">
        </div>

        <div class="register__input__area">
          <button class="register__button" type="submit">登録</button>
        </div>
      </form>

      <div class="link__login">
        <a href="/login">すでにアカウントをお持ちの方はこちら</a>
      </div>
    </div>
</body>
</html>