@extends('layout')

@section('title')
    Syntex Factory
@endsection

@section('description')
    Analyse la sémantique de vos contenus web
@endsection

@section('keywords')
    analyse sémantique, mots-clés, descripteurs, analyse de texte, expressions
@endsection

@section('content')
    <div class="grid grid-cols-12 gap-6 mt-5">
        <x-partials.search-analyse></x-partials.search-analyse>
    </div>

    <div class="grid grid-cols-12 gap-6 report-box-3 px-5 mt-5 pt-8 pb-14 ">
        <x-partials.tools-list></x-partials.tools-list>
    </div>

    <div class="report-box-3--content px-5 mt-5 pt-8 pb-14 ">
        <div class="intro-y flex flex-col sm:flex-row">
            <h2 class="text-lg font-medium mr-auto">Derniers articles</h2>
        </div>
        <div class="intro-y grid grid-cols-12 gap-6 mt-5">
            @foreach($posts as $post)
                <x-partials.article-card-light :post="$post"/>
            @endforeach
        </div>
    </div>

    <div class="grid grid-cols-12 gap-6 report-box-3 px-5 mt-5 pt-8 pb-14 ">
        <x-partials.tools-list-other></x-partials.tools-list-other>
    </div>
    {{--   <div class="report-box-3 report-box-3--content grid grid-cols-12 gap-6 xl:-mt-5 xxl:-mt-8 -mb-10 xxl:z-10">
        @include('pages.partials.table-latest-analyses', ['title' => 'Dernières analyses'])
    </div> --}}
@endsection
