<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Aldrich&family=Cinzel+Decorative:wght@400;700;900&family=Cinzel:wght@400..900&family=Montserrat+Alternates:wght@100;200;300;400&family=Orbitron:wght@400..900&family=Poiret+One&family=Zen+Kaku+Gothic+New:wght@300;400;500;700&family=Zen+Old+Mincho&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <link href="{{ asset('css/auth/form.css') }}" rel="stylesheet">
    </head>
    <body>
        <div class="form-wrapper">
            <div>
                <a href="/">
                <p class="logo">LaraTravel</p>
                </a>
            </div>

            <div class="form-content">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
