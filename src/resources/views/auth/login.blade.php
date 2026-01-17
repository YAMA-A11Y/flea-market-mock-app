@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endsection

@section('header-right')
@endsection

@section('content')
<div class="auth">
    <div class="auth__inner">
        <div class="auth__heading">
            <h2 class="auth__title">ログイン</h2>
        </div>

        <form class="auth__form" method="post" action="/login" novalidate>
            @csrf
            @if ($errors->has('auth'))
                <p class="form__error">{{ $errors->first('auth') }}</p>
            @endif

            <div class="form__group">
                <label class="form__label" for="email">メールアドレス</label>
                <input class="form-input" id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email"/>
        
                @error('email')
                    <p class="form__error">{{ $message }}</p>
                @enderror
            </div>

            <div class="form__group">
                <label class="form__label" for="password">パスワード</label>
                <input class="form-input" id="password" type="password" name="password" required autocomplete="current-password"/>

                @error('password')
                <p class="form__error">{{ $message }}</p>
                @enderror
            </div>
    
            <div class="form-actions">
                <button class="btn btn--primary" type="submit">ログインする</button>
            </div>
        </form>

        <div class="auth__link">
            <a class="text-link" href="/register">会員登録はこちら</a>
        </div>
    </div>
</div>
@endsection
