@extends('layouts.portfolio')

@section('title', 'Portfolio - Strona Główna')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100">
        <!-- Hero Section -->
        <section class="relative py-20 px-6">
            <div class="max-w-6xl mx-auto text-center">
                <h1 class="text-5xl md:text-7xl font-bold text-gray-800 mb-6">
                    Cześć, jestem
                    <span class="bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                        [Twoje Imię]
                    </span>
                </h1>
                <p class="text-xl md:text-2xl text-gray-600 mb-8 max-w-3xl mx-auto">
                    Jestem programistą Full Stack, który tworzy nowoczesne aplikacje webowe
                    z pasją do czystego kodu i innowacyjnych rozwiązań.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="#projects"
                       class="inline-flex items-center px-8 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200">
                        Zobacz Projekty
                        <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                        </svg>
                    </a>
                    <a href="#contact"
                       class="inline-flex items-center px-8 py-3 border-2 border-gray-300 text-gray-700 rounded-lg hover:border-blue-600 hover:text-blue-600 transition-colors duration-200">
                        Skontaktuj się
                    </a>
                </div>
            </div>
        </section>

        <!-- Skills Section -->
        <section class="py-16 px-6 bg-white">
            <div class="max-w-6xl mx-auto">
                <h2 class="text-3xl md:text-4xl font-bold text-center text-gray-800 mb-12">
                    Technologie
                </h2>
                <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-8">
                    @php
                        $skills = [
                            ['name' => 'PHP', 'icon' => '🐘'],
                            ['name' => 'Laravel', 'icon' => '⚡'],
                            ['name' => 'JavaScript', 'icon' => '⚡'],
                            ['name' => 'Vue.js', 'icon' => '💚'],
                            ['name' => 'MySQL', 'icon' => '🗄️'],
                            ['name' => 'Docker', 'icon' => '🐳']
                        ];
                    @endphp

                    @foreach($skills as $skill)
                        <div
                            class="flex flex-col items-center p-6 rounded-lg bg-gray-50 hover:bg-gray-100 transition-colors duration-200">
                            <div class="text-4xl mb-3">{{ $skill['icon'] }}</div>
                            <h3 class="font-semibold text-gray-800">{{ $skill['name'] }}</h3>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- Featured Projects Section -->
        <section id="projects" class="py-16 px-6 bg-gray-50">
            <div class="max-w-6xl mx-auto">
                <h2 class="text-3xl md:text-4xl font-bold text-center text-gray-800 mb-12">
                    Wybrane Projekty
                </h2>
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @for($i = 1; $i <= 3; $i++)
                        <div
                            class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-200">
                            <div class="h-48 bg-gradient-to-br from-blue-400 to-purple-600"></div>
                            <div class="p-6">
                                <h3 class="text-xl font-bold text-gray-800 mb-2">Projekt {{ $i }}</h3>
                                <p class="text-gray-600 mb-4">
                                    Opis projektu lorem ipsum dolor sit amet consectetur adipisicing elit.
                                </p>
                                <div class="flex flex-wrap gap-2 mb-4">
                                    <span class="px-3 py-1 bg-blue-100 text-blue-800 text-sm rounded-full">PHP</span>
                                    <span class="px-3 py-1 bg-red-100 text-red-800 text-sm rounded-full">Laravel</span>
                                    <span
                                        class="px-3 py-1 bg-green-100 text-green-800 text-sm rounded-full">Vue.js</span>
                                </div>
                                <div class="flex gap-4">
                                    <a href="#" class="text-blue-600 hover:text-blue-800 font-medium">Demo</a>
                                    <a href="#" class="text-gray-600 hover:text-gray-800 font-medium">GitHub</a>
                                </div>
                            </div>
                        </div>
                    @endfor
                </div>
                <div class="text-center mt-12">
                    <a href="#"
                       class="inline-flex items-center px-8 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200">
                        Zobacz wszystkie projekty
                        <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                        </svg>
                    </a>
                </div>
            </div>
        </section>

        <!-- Contact Section -->
        <section id="contact" class="py-16 px-6 bg-white">
            <div class="max-w-4xl mx-auto text-center">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-8">
                    Porozmawiajmy o Twoim projekcie
                </h2>
                <p class="text-xl text-gray-600 mb-12">
                    Masz pomysł na aplikację? Skontaktuj się ze mną!
                </p>
                <div class="flex flex-col sm:flex-row gap-6 justify-center">
                    <a href="mailto:twoj-email@example.com"
                       class="inline-flex items-center px-8 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200">
                        <svg class="mr-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        Email
                    </a>
                    <a href="https://linkedin.com/in/twoj-profil" target="_blank"
                       class="inline-flex items-center px-8 py-3 border-2 border-gray-300 text-gray-700 rounded-lg hover:border-blue-600 hover:text-blue-600 transition-colors duration-200">
                        <svg class="mr-2 w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                        </svg>
                        LinkedIn
                    </a>
                    <a href="https://github.com/twoj-profil" target="_blank"
                       class="inline-flex items-center px-8 py-3 border-2 border-gray-300 text-gray-700 rounded-lg hover:border-blue-600 hover:text-blue-600 transition-colors duration-200">
                        <svg class="mr-2 w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/>
                        </svg>
                        GitHub
                    </a>
                </div>
            </div>
        </section>
    </div>
@endsection
