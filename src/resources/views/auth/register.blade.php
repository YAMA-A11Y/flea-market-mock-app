@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/register.css') }}">
@endsection

@section('content')
<div class="register-form__content">
  <div class="register-form__heading">
    <h2 class="page-title">会員登録</h2>
  </div>

  <form class="form" action="/register" method="post" novalidate>
    @csrf
    <div class="form__group">
      <div class="form__group-title">
        <span class="form__label--item">ユーザー名</span>
      </div>
      <div class="form__group-content">
        <div class="form__input--text">
          <input type="text" name="name" value="{{ old('name') }}" required autocomplete="name"/>
        </div>
        @error('name')
          <div class="form__error">{{ $message }}</div>
        @enderror        
      </div>
    </div>

    <div class="form__group">
      <div class="form__group-title">
        <span class="form__label--item">メールアドレス</span>
      </div>
      <div class="form__group-content">
        <div class="form__input--text">
          <input type="email" name="email" value="{{ old('email') }}" required autocomplete="email"/>
        </div>        
        @error('email')
          <div class="form__error">{{ $message }}</div>
        @enderror        
      </div>
    </div>

    <div class="form__group">
      <div class="form__group-title">
        <span class="form__label--item">パスワード</span>
      </div>
      <div class="form__group-content">
        <div class="form__input--text">
          <input type="password" name="password" required autocomplete="new-password"/>
        </div>        
        @error('password')
          <div class="form__error">{{ $message }}</div>
        @enderror        
      </div>
    </div>

    <div class="form__group">
      <div class="form__group-title">
        <span class="form__label--item">確認用パスワード</span>
      </div>
      <div class="form__group-content">
        <div class="form__input--text">
          <input type="password" name="password_confirmation" required autocomplete="new-password"/>
        </div>        
        @error('password_confirmation')
          <div class="form__error">{{ $message }}</div>
        @enderror        
      </div>
    </div>

    <div class="form__button">
      <button class="form__button-submit" type="submit">登録する</button>
    </div>

    <div class="auth__link">
        <a class="text-link" href="/login">ログインはこちら</a>
    </div>
  </form>
</div>
@endsection
