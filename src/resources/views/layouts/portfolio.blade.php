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
<body class="font-sans antialiased bg-white">
<!-- Navigation -->
<nav class="fixed top-0 w-full bg-white/80 backdrop-blur-md border-b border-gray-200 z-50">
    <div class="max-w-6xl mx-auto px-6">
        <div class="flex justify-between items-center h-16">
            <div class="flex items-center">
                <a href="{{ route('home') }}" class="text-2xl font-bold text-gray-800">
                    Portfolio
                </a>
            </div>

            <!-- Desktop Navigation -->
            <div class="hidden md:flex items-center space-x-8">
                <a href="{{ route('home') }}" class="text-gray-700 hover:text-blue-600 transition-colors duration-200 {{ request()->routeIs('home') ? 'text-blue-600 font-semibold' : '' }}">
                    Home
                </a>
                <a href="#projects" class="text-gray-700 hover:text-blue-600 transition-colors duration-200">
                    Projekty
                </a>
                <a href="#contact" class="text-gray-700 hover:text-blue-600 transition-colors duration-200">
                    Kontakt
                </a>
                <a href="/blog" class="text-gray-700 hover:text-blue-600 transition-colors duration-200">
                    Blog
                </a>
            </div>

            <!-- Mobile menu button -->
            <div class="md:hidden">
                <button id="mobile-menu-button" class="text-gray-700 hover:text-blue-600 focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Navigation -->
    <div id="mobile-menu" class="hidden md:hidden bg-white border-t border-gray-200">
        <div class="px-6 py-4 space-y-4">
            <a href="{{ route('home') }}" class="block text-gray-700 hover:text-blue-600 transition-colors duration-200 {{ request()->routeIs('home') ? 'text-blue-600 font-semibold' : '' }}">
                Home
            </a>
            <a href="#projects" class="block text-gray-700 hover:text-blue-600 transition-colors duration-200">
                Projekty
            </a>
            <a href="#contact" class="block text-gray-700 hover:text-blue-600 transition-colors duration-200">
                Kontakt
            </a>
            <a href="/blog" class="block text-gray-700 hover:text-blue-600 transition-colors duration-200">
                Blog
            </a>
        </div>
    </div>
</nav>

<!-- Main Content -->
<main class="pt-16">
    @yield('content')
</main>

<!-- Footer -->
<footer class="bg-gray-800 text-white py-12">
    <div class="max-w-6xl mx-auto px-6">
        <div class="grid md:grid-cols-3 gap-8">
            <div>
                <h3 class="text-xl font-bold mb-4">Portfolio</h3>
                <p class="text-gray-300">
                    Programista Full Stack z pasją do tworzenia nowoczesnych aplikacji webowych.
                </p>
            </div>
            <div>
                <h3 class="text-xl font-bold mb-4">Szybkie linki</h3>
                <ul class="space-y-2">
                    <li><a href="{{ route('home') }}" class="text-gray-300 hover:text-white transition-colors duration-200">Home</a></li>
                    <li><a href="#projects" class="text-gray-300 hover:text-white transition-colors duration-200">Projekty</a></li>
                    <li><a href="#contact" class="text-gray-300 hover:text-white transition-colors duration-200">Kontakt</a></li>
                    <li><a href="/blog" class="text-gray-300 hover:text-white transition-colors duration-200">Blog</a></li>
                </ul>
            </div>
            <div>
                <h3 class="text-xl font-bold mb-4">Kontakt</h3>
                <ul class="space-y-2">
                    <li>
                        <a href="mailto:twoj-email@example.com" class="text-gray-300 hover:text-white transition-colors duration-200">
                            twoj-email@example.com
                        </a>
                    </li>
                    <li>
                        <a href="https://linkedin.com/in/twoj-profil" target="_blank" class="text-gray-300 hover:text-white transition-colors duration-200">
                            LinkedIn
                        </a>
                    </li>
                    <li>
                        <a href="https://github.com/twoj-profil" target="_blank" class="text-gray-300 hover:text-white transition-colors duration-200">
                            GitHub
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="border-t border-gray-700 mt-8 pt-8 text-center">
            <p class="text-gray-300">
                &copy; {{ date('Y') }} Portfolio. Wszystkie prawa zastrzeżone.
            </p>
        </div>
    </div>
</footer>

<!-- Mobile menu toggle script -->
<script>
    document.getElementById('mobile-menu-button').addEventListener('click', function() {
        const mobileMenu = document.getElementById('mobile-menu');
        mobileMenu.classList.toggle('hidden');
    });

    // Smooth scrolling for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
</script>
</body>
</html>
