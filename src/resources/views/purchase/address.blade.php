@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/common.css') }}">
<link rel="stylesheet" href="{{ asset('css/address.css') }}">
@endsection

@section('content')
<div class="address">
    <div class="address__inner">

    <h2 class="address__title">住所の変更</h2>

    <form class="address-form" action="{{ route('purchase.address.update', $item->id) }}" method="POST">
        @csrf
        @method('PATCH')

        <div class="address-form__group">
            <label class="address-form__label" for="postcode">郵便番号</label>
            <input class="address-form__input" type="text" id="postcode" name="postcode" value="{{ old('postcode', $addr['postcode'] ?? '') }}">
            @error('postcode')
                <p class="form-error">{{ $message }}</p>
            @enderror
        </div>

        <div class="address-form__group">
            <label class="address-form__label" for="address">住所</label>
            <input class="address-form__input" type="text" id="address" name="address" value="{{ old('address', $addr['address'] ?? '') }}">
            @error('address')
                <p class="form-error">{{ $message }}</p>
            @enderror
        </div>

        <div class="address-form__group">
            <label class="address-form__label" for="building">建物名</label>
            <input class="address-form__input" type="text" id="building" name="building" value="{{ old('building', $addr['building'] ?? '') }}">
            @error('building')
                <p class="form-error">{{ $message }}</p>
            @enderror
        </div>

        <div class="address-form__actions">
            <button class="address-form__submit" type="submit">更新する</button>
        </div>
    </form>

    </div>
</div>
@endsection