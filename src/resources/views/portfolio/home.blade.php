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
        @include('partials.portfolio.projects')
    </div>
@endsection

@section('footer')
    <div>
        @include('partials.portfolio.footer')
    </div>
@endsection
