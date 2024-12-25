<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>トップページ|LaraTravel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Aldrich&family=Cinzel+Decorative:wght@400;700;900&family=Cinzel:wght@400..900&family=Montserrat+Alternates:wght@100;200;300;400&family=Orbitron:wght@400..900&family=Poiret+One&family=Zen+Kaku+Gothic+New:wght@300;400;500;700&family=Zen+Old+Mincho&display=swap" rel="stylesheet">
        <!-- Styles / Scripts -->
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif

        <link href="{{ asset('css/auth/top.css') }}" rel="stylesheet">
    </head>
    <body>
        <div>
            <div>
                <div>
                    <header>
                        <img src="" alt="" class="RECicon">
                        <h1 class="logo">LaraTravel</h1>
                        @if (Route::has('login'))
                            <nav class="-mx-3 flex flex-1 justify-end">
                                @auth
                                    <a href="{{ route('laraveltravel.index') }}">Home</a>
                                @else
                                    <a href="{{ route('login') }}">Log in</a>

                                    @if (Route::has('register'))
                                        <a href="{{ route('register') }}">Register</a>
                                    @endif
                                @endauth
                            </nav>
                        @endif
                    </header>

                    <main>
                        <div class="mainvisual">
                        </div>

                        @if (Route::has('login'))
                        <div class="form-wrapper">
                            @auth
                                <p>ログイン済みです</p>
                                <a href="{{ route('laraveltravel.index') }}"><span>Home</span></a>
                            @else
                                <a href="{{ route('login') }}"><span>ログインはこちら</span></a>

                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}"><span>新規ユーザー登録はこちら</span></a>
                                @endif
                            @endauth
                        </div>
                        @endif
                    </main>

                    <footer>
                        <div class="footer-text">
                          <h2 class="footer-logo">LaraTravel</h2>
                          <p>Copyright © 2005 ○○○○ All Rights Reserved.</p>
                        </div>

                        <div class="footer-icon">
                          <img src="img/lasvegas/Twitter.png" alt="">
                          <img src="img/lasvegas/Instagram.png" alt="">
                        </div>
                    </footer>
                </div>
            </div>
        </div>
    </body>
</html>
