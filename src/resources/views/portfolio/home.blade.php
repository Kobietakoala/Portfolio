@extends('layouts.portfolio')

@section('title', 'Portfolio - Strona Główna')

@section('header')
    <div>
        @include('partials.portfolio.header')
    </div>
@endsection

@section('navigation')
    <div>
        @include('partials.portfolio.navigation')
    </div>
@endsection

@section('content')
    <div>
        @include('partials.portfolio.about')
        @include('partials.portfolio.skills')
        @include('partials.portfolio.experience')

        <section id="projects" class="py-5 bg-white">
            <div class="container">
                <h2 class="text-center mb-4">Projects</h2>
                <p class="text-center text-muted mb-0">Sekcja projektów w przygotowaniu.</p>
            </div>
        </section>

        @include('partials.portfolio.contact')
    </div>
@endsection

@section('footer')
    <div>
        @include('partials.portfolio.footer')
    </div>
@endsection
