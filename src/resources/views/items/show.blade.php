@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/item-show.css') }}">
@endsection

@section('content')
<div class="item-detail">
    <div class="item-detail__inner">

        <div class="item-detail__grid">
            <div class="item-detail__media">
                <div class="item-detail__image">
                    <img src="{{ asset('storage/' . $item->image_path) }}" alt="{{ $item->name }}">
                </div>
            </div>

            <div class="item-detail__info">

                <h1 class="item-detail__name">{{ $item->name }}</h1>

                @if (!empty($item->brand))
                    <div class="item-detail__brand">{{ $item->brand }}</div>
                @endif

                <div class="item-detail__price">
                    <span class="item-detail__yen">¥{{ number_format($item->price) }}</span>
                    <span class="item-detail__tax">(税込)</span>
                </div>

                <div class="item-detail__meta">
                    <div class="meta-icon">
                        <button class="like-btn" type="button" aria-label="いいね">
                            <img class="like-btn__img" src="{{ asset('images/ハートロゴ_デフォルト.png') }}" data-off="{{ asset('images/ハートロゴ_デフォルト.png') }}" data-on="{{ asset('images/ハートロゴ_ピンク.png') }}" alt="いいね">
                        </button>
                        <span class="meta-icon__num js-like-count">0</span>
                    </div>
                    <div class="meta-icon">
                        <img class="meta-icon__img" src="{{ asset('images/ふきだしロゴ.png') }}" alt="コメント">
                        <span class="meta-icon__num">2</span>
                    </div>
                </div>

                <a class="item-detail__buy" href="#">購入手続きへ</a>

                <section class="item-detail__section">
                    <h2 class="item-detail__heading">商品説明</h2>
                    <div class="item-detail__desc">
                        {{ $item->description }}
                    </div>
                </section>

                <section class="item-detail__section">
                    <h2 class="item-detail__heading">商品の情報</h2>

                    <dl class="item-detail__dl">
                        <dt>カテゴリー</dt>
                        <dd>
                            <span class="chip">洋服</span>
                            <span class="chip">メンズ</span>
                        </dd>

                        <dt>商品の状態</dt>
                        <dd>{{ $item->condition }}</dd>
                    </dl>
                </section>

                <section class="item-detail__section">
                    <h2 class="item-detail__heading">コメント(1)</h2>

                    <div class="item-detail__narrow">
                        <div class="comment">
                            <div class="comment__head">
                                <div class="comment__avatar"></div>
                                <div class="comment__name">admin</div>
                            </div>

                            <div class="comment__text">こちらにコメントが入ります。</div>                     
                        </div>
                    </div>
                </section>

                <section class="item-detail__section">
                    <h2 class="item-detail__heading">商品へのコメント</h2>

                    <div class="item-detail__narrow">
                        <textarea class="item-detail__textarea" rows="5"></textarea>

                        <button class="item-detail__submit" type="button">コメントを送信する</button>
                    </div>
                </section>

            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('click', function (e) {
    const btn = e.target.closest('.like-btn');
    if (!btn) return;

    const img = btn.querySelector('.like-btn__img');
    const countEl = btn.closest('.meta-icon').querySelector('.js-like-count');

    const off = img.dataset.off;
    const on = img.dataset.on;

    const liked = img.dataset.liked === 'true';

    img.src = liked ? off : on;
    img.dataset.liked = liked ? 'false' : 'true';

    const current = Number(countEl.textContent);
    countEl.textContent = liked ? current - 1 : current + 1;
});
</script>
@endsection