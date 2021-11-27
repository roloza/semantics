
@extends('layout')

@section('title')
    Lancer une analyse
@endsection

@section('description')
    Analyser la sémantique, un page unique, un site entier ou encore le web en général
@endsection

@section('keywords')
    analyse sémantique, mots-clés, descripteurs, analyse de texte, expressions
@endsection

@section('content')
    <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
        <h1 class="text-lg font-medium mr-auto">Trouver un Antonyme</h1>
    </div>

    <p>
        Un antonyme est un terme ou une liste de termes dont le sens est contraire à celui d'un autre. Il est un mot de sens opposé à celui d’un autre.
        Notre dictionnaire antonyme vous permettra de trouver un mot qui a le sens contraire de celui que vous avez tapé dans la barre de recherche.
    </p>

    <div class="col-span-12 lg:col-span-9 xxl:col-span-10">
        <livewire:search-antonyms />
    </div>


@endsection


