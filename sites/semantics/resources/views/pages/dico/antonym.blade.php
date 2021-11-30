
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
    <div class="grid grid-cols-12 gap-6 mt-8">
        <div class="col-span-12 lg:col-span-9">
            <livewire:search-antonyms />
        </div>

        <div class="col-span-12 lg:col-span-3 intro-y ">

            <div class="intro-y box p-4">
                <div class="d-flex flex-column flex-sm-row align-items-center p-5 border-bottom border-gray-200 dark-border-dark-5">
                    <h2 class="text-xl ">
                        Mais c'est quoi un antonyme ?
                    </h2>
                    <div class="text-gray-600 text-justify mt-4">
                    <p>
                        Un antonyme est un terme ou une liste de termes dont le sens est contraire à celui d'un autre. Il est un mot de sens opposé à celui d’un autre.
                        Notre dictionnaire antonyme vous permettra de trouver un mot qui a le sens contraire de celui que vous avez tapé dans la barre de recherche.
                    </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection


