@extends('layout')

@section('title')
    Liste des articles
@endsection

@section('description')
@endsection

@section('keywords')
    analyse sémantique, mots-clés, descripteurs, analyse de texte, expressions
@endsection

@section('content')
    <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">Tous les articles</h2>
    </div>

    {{-- Articles --}}
    <div class="intro-y grid grid-cols-12 gap-6 mt-5">

        @foreach($posts as $post)
            <x-partials.article-card :post="$post"/>
        @endforeach

        <div class="intro-y col-span-12 flex flex-wrap sm:flex-row sm:flex-nowrap items-center">
            {{ $posts->links() }}
        </div>
    </div>
@endsection
