@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/common.css') }}">
<link rel="stylesheet" href="{{ asset('css/purchase.css') }}">
@endsection

@section('content')
<div class="purchase">
    <div class="purchase__inner">
        
        <div class="purchase__grid">
            <div class="purchase-left">
                <div class="purchase-item">
                    <div class="purchase-item__image">
                        <img class="purchase-item__img" src="{{ asset('storage/' . $item->image_path) }}" alt="{{ $item->name }}">
                    </div>

                    <div class="purchase-item__meta">
                        <div class="purchase-item__name">{{ $item->name }}</div>
                        <div class="purchase-item__price">¥ {{ number_format($item->price) }}</div>
                    </div>
                </div>

                <div class="purchase-sep"></div>

                <section class="purchase-section">
                    <h3 class="purchase-section__title">支払い方法</h3>

                    <div class="purchase-section__body purchase-section__body--select">
                        <select class="purchase-select" name="payment_method" id="payment-method">
                            <option value="" selected>選択してください</option>
                            <option value="convenience">コンビニ払い</option>
                            <option value="card">カード支払い</option>
                        </select>
                    </div>
                </section>

                <div class="purchase-sep"></div>

                <section class="purchase-section">
                    <div class="purchase-section__head">
                        <h3 class="purchase-section__title">配送先</h3>
                        <a class="purchase-link" href="{{ url('/mypage/profile') }}">変更する</a>
                    </div>

                    <div class="purchase-section__body">
                        @php
                            $u = Auth::user();
                        @endphp

                        <p class="purchase-address">〒 {{ $u->postcode ?? '---' }}</p>
                        <p class="purchase-address">
                            {{ $u->address ?? '住所が未設定です'}}
                            @if (!empty($u->building))
                                {{ $u->building}}
                            @endif
                        </p>
                    </div>
                </section>

                <div class="purchase-sep"></div>
            </div>

            <aside class="purchase-right">
                <div class="purchase-summary">
                    <div class="purchase-summary__row">
                        <div class="purchase-summary__label">商品代金</div>
                        <div class="purchase-summary__value">¥ {{number_format($item->price) }}</div>
                    </div>
                    <div class="purchase-summary__row">
                        <div class="purchase-summary__label">支払い方法</div>
                        <div class="purchase-summary__value js-payment-label">選択してください</div>
                    </div>
                </div>

                <button class="purchase-btn" type="button">購入する</button>
            </aside>
        </div>
    </div>    
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
  const select = document.getElementById('payment-method');
  const label = document.querySelector('.js-payment-label');

  const textMap = {
    convenience: 'コンビニ払い',
    card: 'カード支払い',
  };

  const reflect = () => {
    const v = select.value;
    label.textContent = textMap[v] ?? '選択してください';
  };

  reflect();

  select.addEventListener('change', reflect);
});
</script>

@endsection