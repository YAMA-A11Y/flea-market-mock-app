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
                        <button class="like-btn" type="button" aria-label="いいね" data-auth="{{ auth()->check() ? 'true' : 'false' }}" data-login-url="{{ route('login') }}">

                            @if ($isLiked)
                                <img class="like-btn__img" src="{{ asset('images/ハートロゴ_ピンク.png') }}" data-off="{{ asset('images/ハートロゴ_デフォルト.png') }}" data-on="{{ asset('images/ハートロゴ_ピンク.png') }}"  data-liked="true" alt="いいね">
                            @else
                                <img class="like-btn__img" src="{{ asset('images/ハートロゴ_デフォルト.png') }}" data-off="{{ asset('images/ハートロゴ_デフォルト.png') }}" data-on="{{ asset('images/ハートロゴ_ピンク.png') }}"  data-liked="false" alt="いいね">
                            @endif
                        </button>
                        <span class="meta-icon__num js-like-count">{{ $likeCount }}</span>
                    </div>
                    <div class="meta-icon">
                        <img class="meta-icon__img" src="{{ asset('images/ふきだしロゴ.png') }}" alt="コメント">
                        <span class="meta-icon__num js-comment-count">{{ $commentCount }}</span>
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
                    <h2 class="item-detail__heading">コメント({{ $commentCount }})</h2>

                    <div class="item-detail__narrow">
                        @forelse ($comments as $comment)
                            <div class="comment">
                                <div class="comment__head">
                                    <div class="comment__avatar"></div>
                                    <div class="comment__name">{{ $comment->user->name ?? 'user' }}</div>
                                </div>
                                <div class="comment__text">{{ $comment->body }}</div>
                            </div>
                        @empty
                            <p class="items__empty">コメントはまだありません</p>
                        @endforelse
                    </div>
                </section>

                <section class="item-detail__section">
                    <h2 class="item-detail__heading">商品へのコメント</h2>

                    <form class="item-detail__narrow" method="post" action="{{ route('items.comment', $item->id )}}">
                        @csrf

                        <textarea class="item-detail__textarea" name="body" rows="5">{{old('body') }}</textarea>

                        @error('body')
                            <p class="form__error">{{ $message }}</p>
                        @enderror

                        <button class="item-detail__submit" type="submit">コメントを送信する</button>
                    </form>
                </section>

            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('click', async (e) => {
  const btn = e.target.closest('.like-btn');
  if (!btn) return;

  if (btn.dataset.auth !== 'true') {
    window.location.href = btn.dataset.loginUrl;
    return;
  }

  const img = btn.querySelector('.like-btn__img');
  const countEl = btn.closest('.meta-icon').querySelector('.js-like-count');
  const token = document.querySelector('meta[name="csrf-token"]').content;

  const res = await fetch("{{ route('items.like', $item->id) }}", {
    method: "POST",
    headers: {
      "X-CSRF-TOKEN": token,
      "Accept": "application/json",
    },
  });

  if (res.status === 401) {
    alert('いいねするにはログインが必要です');
    return;
  }

  const data = await res.json();

  img.src = data.liked ? img.dataset.on : img.dataset.off;
  img.dataset.liked = data.liked ? 'true' : 'false';
  countEl.textContent = data.count;
});
</script>

@endsection