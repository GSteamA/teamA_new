<!-- 共通レイアウト -->
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'クイズアプリ')</title>
    
    @vite(['public/css/quiz/menu.css','public/js/quiz/menu.js'])
    @yield('additional_css')

    <style>
        :root {
            --navy-color: #1B435D;
            --main-color: #78BBE6;
            --light-color: #D5EEFF;
            --accent-color: #F99F48;
        }

        body {
            margin: 0;
            padding: 0;
        }

        main {
            background: transparent;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
    </style>
</head>
<body>
    <main>
        @if(session('error'))
            <div class="error-message">
                {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </main>

    @yield('additional_js')
</body>
</html>