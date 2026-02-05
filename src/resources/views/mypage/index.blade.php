@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/common.css') }}">
<link rel="stylesheet" href="{{ asset('css/mypage.css') }}">
@endsection

@section('content')
<div class="mypage">
    <div class="mypage__inner">
        <section class="mypage-profile">
            <div class="mypage-profile__left">
                <div class="mypage-profile__avatar">
                    {{-- <img src="{{ asset('storage/' . $user->profile_image) }}" alt="avatar"> --}}
                </div>

                <div class="mypage-profile__name">
                    {{ $user->name ?? 'ユーザー名'}}
                </div>
            </div>

            <div class="mypage__right">
                <a class="mypage-profile__edit" href="{{ url('/mypage/profile') }}">プロフィールを編集</a>
            </div>
        </section>

        @php
            $tab = request('tab', 'sell'); // sell / buy
        @endphp

        <nav class="mypage-tabs">
            <a class="mypage-tabs__item {{ $tab === 'sell' ? 'is-active' : '' }}" href="{{ url('mypage') }}?tab=sell">出品した商品</a>

            <a class="mypage-tabs__item {{ $tab === 'buy' ? 'is-active' : '' }}" href="{{ url('mypage') }}?tab=buy">購入した商品</a>
        </nav>

        <div class="mypage-sep"></div>

        <section class="mypage-items">
            <div class="mypage-items__grid">

                @forelse ($items as $item)
                    <article class="mypage-card">
                        <a class="mypage-card==link" href="{{ route('items.show', $item->id) }}">
                            <div class="mypage-card__image">
                                <img class="mypage-card__img" src="{{ asset('storage/' . $item->image_path) }}" alt="{{ $item->name }}" loading="lazy">
                            </div>

                            <div class="mtpage-card__name">
                                {{ $item->name }}
                            </div>
                        </a>
                    </article>
                @empty
                    <p class="mypage-items__empty">表示する商品がありません</p>
                @endforelse

            </div>
        </section>

    </div>
</div>
@endsection