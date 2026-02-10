@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/sell.css') }}">
@endsection

@section('content')
<div class="sell">
    <div class="sell__inner">

        <h2 class="sell__title">商品の出品</h2>

        <form class="sell-form" action="{{ route('items.sell.store') }}" method="POST" enctype="multipart/form-data" novalidate>
            @csrf

            <section class="sell-section">
                <h3 class="sell-section__title">商品画像</h3>

                <div class="sell-image">
                    <div class="sell-image__box">
                        <label class="sell-image__button">
                            <input class="sell-image__input" type="file" name="image" accept=".jpeg,.jpg,.png">
                            画像を選択する
                        </label>              
                    </div>
                    
                    @error('image')
                        <div class="form__error">{{ $message }}</div>
                    @enderror
                </div>
            </section>

            <section class="sell-section">
                <h3 class="sell-section__heading">商品の詳細</h3>

                <div class="sell-field">
                    <div class="sell-field__label">カテゴリー</div>                

                    <div class="sell-category">
                        @php
                            $categories = ['ファッション','家電','インテリア','レディース','メンズ','コスメ','本','ゲーム','スポーツ','キッチン','ハンドメイド','アクセサリー','おもちゃ','ベビー・キッズ'];
                            $oldCategories = (array) old('categories', []);
                        @endphp

                        @foreach ($categories as $cat)
                            @php($checked = in_array($cat, $oldCategories, true))
                            <label class="sell-category__chip {{ $checked ? 'is-active' : '' }}">
                                <input class="sell-category__checkbox" type="checkbox" name="categories[]" value="{{ $cat }}" {{ $checked ? 'checked' : '' }}>
                                <span class="sell-category__text">{{ $cat }}</span>
                            </label>
                        @endforeach
                    </div>

                    @error('categories')
                        <div class="form__error">{{ $message }}</div>
                    @enderror
                    @error('categories.*')
                        <div class="form__error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="sell-field">
                    <label class="sell-field__label" for="condition">商品の状態</label>

                    <div class="sell-select">
                        <select class="sell-select__control" id="condition" name="condition">
                            <option value="" hidden>選択してください</option>

                            @foreach (['良好','目立った傷や汚れなし','やや傷や汚れあり','状態が悪い'] as $c)
                                <option value="{{ $c }}" {{ old('condition') === $c ? 'selected' : '' }}>{{ $c }}</option>
                            @endforeach
                        </select>
                    </div>

                    @error('condition')
                        <div class="form__error">{{ $message }}</div>
                    @enderror
                </div>
            </section>

            <section class="sell-section">
                <h3 class="sell-section__heading">商品名と説明</h3>

                <div class="sell-field">
                    <label class="sell-field__label" for="name">商品名</label>
                    <input class="sell-input" type="text" id="name" name="name" value="{{ old('name') }}">

                    @error('name')
                        <div class="form__error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="sell-field">
                    <label class="sell-field__label" for="brand">ブランド名</label>
                    <input class="sell-input" type="text" id="brand" name="brand" value="{{ old('brand') }}">

                    @error('brand')
                        <div class="form__error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="sell-field">
                    <label class="sell-field__label" for="description">商品の説明</label>
                    <textarea class="sell-textarea" id="description" name="description">{{ old('description') }}</textarea>

                    @error('description')
                        <div class="form__error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="sell-field">
                    <label class="sell-field__label" for="price">販売価格</label>
                    <div class="sell-price">
                        <span class="sell-price__yen">¥</span>
                        <input class="sell-price__input" type="number" id="price" name="price" value="{{ old('price') }}">
                    </div>
                    
                    @error('price')
                        <div class="form__error">{{ $message }}</div>
                    @enderror
                </div>
            </section>

            <div class="sell-actions">
                <button class="sell-actions__submit" type="submit">出品する</button>
            </div>
        </form>

    </div>
</div>
@endsection