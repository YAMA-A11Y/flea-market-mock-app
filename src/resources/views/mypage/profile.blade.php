@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/profile.css') }}">
@endsection

@section('content')
<div class="profile-form__content">
  <div class="profile-form__heading">
    <h2 class="page-title">プロフィール設定</h2>
  </div>

  <form class="form" action="/mypage/profile" method="post" enctype="multipart/form-data" novalidate>
    @csrf

    <div class="profile-form__image">
      <div class="profile-form__image-preview"></div>

      <label class="profile-form__image-button">
        <input class="profile-form__image-input" type="file" name="profile_image" accept="image/*">
        画像を選択する
      </label>

      @error('profile_image')
        <div class="form__error">{{ $message }}</div>
      @enderror
    </div>

    <div class="form__group">
      <div class="form__group-title">
        <span class="form__label--item">ユーザー名</span>
      </div>
      <div class="form__group-content">
        <div class="form__input--text">
          <input type="text" name="username" value="{{ old('username', $user->username ?? '') }}" required autocomplete="username" />
        </div>

        @error('username')
          <div class="form__error">{{ $message }}</div>
        @enderror
      </div>
    </div>

    <div class="form__group">
      <div class="form__group-title">
        <span class="form__label--item">郵便番号</span>
      </div>
      <div class="form__group-content">
        <div class="form__input--text">
          <input type="text" name="postcode" value="{{ old('postcode', $user->postcode ?? '') }}" required autocomplete="postal-code" />
        </div>

        @error('postcode')
          <div class="form__error">{{ $message }}</div>
        @enderror
      </div>
    </div>

    <div class="form__group">
      <div class="form__group-title">
        <span class="form__label--item">住所</span>
      </div>
      <div class="form__group-content">
        <div class="form__input--text">
          <input type="text" name="address" value="{{ old('address', $user->address ?? '') }}" required autocomplete="street-address" />
        </div>

        @error('address')
          <div class="form__error">{{ $message }}</div>
        @enderror
      </div>
    </div>

    <div class="form__group">
      <div class="form__group-title">
        <span class="form__label--item">建物名</span>
      </div>
      <div class="form__group-content">
        <div class="form__input--text">
          <input type="text" name="building" value="{{ old('building', $user->building ?? '') }}" />
        </div>

        @error('building')
          <div class="form__error">{{ $message }}</div>
        @enderror
      </div>
    </div>

    <div class="form__button">
      <button class="form__button-submit" type="submit">更新する</button>
    </div>
  </form>
</div>
@endsection

