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
        <h1 class="text-lg font-medium mr-auto">Nouveau traitement</h1>
    </div>

    <div class="pos intro-y grid grid-cols-12 gap-5 mt-5">
        <div class="col-span-12 xl:col-span-8">
            <x-analyse.launcher.tabs active="web"/>
            @livewire('analyse-web')
        </div>
        <div class="col-span-12 xl:col-span-4">
            <div class="intro-y box p-4">
                <div class="d-flex flex-column flex-sm-row align-items-center p-5 border-bottom border-gray-200 dark-border-dark-5">
                    <h2 class="text-xl ">
                        Audit le champs lexical d'une thématique
                    </h2>

                    <div class="text-gray-600 text-justify mt-4">
                        <p>Ce traitement recherche les pages web influantes d'une thématique et les analyses </p>
                        <p class="mt-4">
                            <strong>Atouts :</strong>
                        <ul class="list-disc list-inside">
                            <li>Une visiblité de toutes les expressions autour d'une thématique</li>
                            <li>Un listing des mots-clés importants (Descripteurs) de la thématique</li>
                            <li>Identifier comment les sites influants traites une thématique</li>
                        </ul>
                        </p>
                        <p class="mt-4">
                            <strong>Paramètres</strong>
                        <ul class="list-disc list-inside">
                            <li><strong>Thématique</strong> : Mot-clé représentatif de la thématique à analyser</li>
                            <li><strong>Analyser</strong>: Données qui seront analysée. L'ensemble du contenu texte ou uniquement le contenu utile.</li>
                        </ul>
                        </p>
                    </div>
                </div>

            </div>
        </div>


    </div>
@endsection
