@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/common.css') }}">
<link rel="stylesheet" href="{{ asset('css/items.css') }}">
@endsection

@section('content')
<div class="items">

  <div class="items-tabs">
    <div class="items-tabs__inner">
      <a class="items-tabs__item {{ ($tab ?? 'recommend') === 'recommend' ? 'is-active' : '' }}" href="{{ route('items.index' , ['tab' => 'recommend', 'keyword' => request('keyword'),]) }}">おすすめ</a>
      <a class="items-tabs__item  {{ ($tab ?? 'recommend') === 'mylist' ? 'is-active' : '' }}" href="{{ route('items.index', ['tab' => 'mylist', 'keyword' => request('keyword'),]) }}">マイリスト</a>
    </div>
  </div>
  
  <div class="items__inner">
    <div class="items__grid">
      @forelse ($items as $item)
        <article class="item-card">
          <a class="item-card__link" href="{{ route('items.show', $item->id) }}">
            <div class="item-card__image {{ $item->is_sold ? 'is-sold' : '' }}">
              <img class="item-card__img" src="{{ asset('storage/' . $item->image_path) }}" alt="{{ $item->name }}" loading="lazy">

              @if ($item->is_sold)
                <span class="item-card__sold">SOLD</span>
              @endif
            </div>

            <p class="item-card__name">{{ $item->name }}</p>
          </a>
        </article>
      @empty
        <p class="items__empty">商品がありません</p>
      @endforelse
    </div>
  </div>
</div>
@endsection
