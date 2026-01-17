<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>COACHTECH</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    @yield('css')
</head>

<body>
    <header class="header">
        <div class="header__inner">
            <a class="header__logo" href="{{ url('/') }}">
                <img src="{{ asset('images/COACHTECHヘッダーロゴ.png') }}" alt="COACHTECH">
            </a>

            @if (!request()->routeIs('login') && !request()->routeIs('register'))
                <div class="header__search">
                    <input type="text" placeholder="なにをお探しですか？" disabled>
                </div>
            @endif

            <div class="header__right">
                @if (!request()->routeIs('login') && !request()->routeIs('register')) 

                    @auth
                        <form method="post" action="{{ route('logout') }}">
                            @csrf
                            <button class="header__action" type="submit">ログアウト</button>
                        </form>                        
                    @else
                        <a class="header__action" href="{{ route('login') }}">ログイン</a>
                    @endauth

                    <a class="header__action" href="#">マイページ</a>

                    <a class="header__action header__action--primary" href="#">出品</a>

                @endif
            </div>
            
        </div>
    </header>

    <main class="main">
        @yield('content')
    </main>
</body>

</html>