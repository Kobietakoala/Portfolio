<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Portfolio')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Meta tags for SEO -->
    <meta name="description" content="@yield('description', 'Portfolio - Profesjonalny programista Full Stack')">
    <meta name="keywords" content="programista, developer, PHP, Laravel, JavaScript, portfolio">
    <meta name="author" content="@yield('author', 'Twoje Imię')">

    <!-- Open Graph -->
    <meta property="og:title" content="@yield('title', 'Portfolio')">
    <meta property="og:description" content="@yield('description', 'Portfolio programisty Full Stack')">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
</head>
<body class="font-sans antialiased">
<!-- Navigation -->

<div class="mx-auto min-h-screen max-w-screen-xl px-6 py-12 md:px-12 md:py-16 lg:py-0">
    <nav class="fixed top-0 w-full backdrop-blur-md border-b border-gray-200 hidden md:block">
        @yield('navigation')
    </nav>

    <header>
        @yield('header')
    </header>

    <main class="pt-0 md:pt-16">
        @yield('content')
    </main>

    <footer class="bg-gray-800 text-white py-12">
        @yield('footer')
    </footer>
</div>


</body>
</html>
