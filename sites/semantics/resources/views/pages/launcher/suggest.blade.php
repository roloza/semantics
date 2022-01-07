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
        <h1 class="text-lg font-medium mr-auto">Trouver des suggestions d'enrichissement sémantique</h1>
    </div>

    <div class="pos intro-y grid grid-cols-12 gap-5 mt-5">
        <div class="col-span-12 xl:col-span-8">
            @livewire('analyse-suggest')
        </div>

        <div class="col-span-12 xl:col-span-4">
            <div class="intro-y box p-4">
                <div class="d-flex flex-column flex-sm-row align-items-center p-5 border-bottom border-gray-200 dark-border-dark-5">
                    <h2 class="text-xl ">
                        Enrichissement sémantique
                    </h2>

                    <div class="text-gray-600 text-justify mt-4">
                        <p>Ce traitement se base sur les suggestions des moteurs de recherche pour vous aider à trouver comment les internautes tapent leurs mot-clés sur une thématique.</p>
                        <p class="mt-4">
                            <strong>Atouts :</strong>
                        <ul class="list-disc list-inside">
                            <li>Une visiblité de toutes les expressions, recherchées par les internautes, autour d'une thématique.</li>
                            <li>Identifier quels mots-clés utilisent les internautes.</li>
                        </ul>
                        </p>
                        <p class="mt-4">
                            <strong>Paramètres</strong>
                        <ul class="list-disc list-inside">
                            <li><strong>Thématique</strong> : Mot-clé représentatif de la thématique à analyser</li>
                        </ul>
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
