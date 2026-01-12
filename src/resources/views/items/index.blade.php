@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/common.css') }}">
<link rel="stylesheet" href="{{ asset('css/items.css') }}">
@endsection

@section('content')
<div class="items">
  <div class="items__inner">
    <div class="items__heading">
      <h2 class="items__title">商品一覧</h2>
    </div>
  
    <div class="items__grid">
      @forelse ($items as $item)
        <article class="item-card">
          <a class="item-card__link" href="#">
            <div class="item-card__image">
              <img class="item-card__img" src="{{ asset('storage/' . $item->image_path) }}" alt="{{ $item->name }}" loading="lazy">

              @if ($item->is_sold)
                <span class="item-card__sold">Sold</span>
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
