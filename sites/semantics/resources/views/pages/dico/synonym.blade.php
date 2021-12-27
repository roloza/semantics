
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
        <h1 class="text-lg font-medium mr-auto">Trouver un Synonyme</h1>
    </div>
    <div class="grid grid-cols-12 gap-6 mt-8">

        <div class="col-span-12 lg:col-span-9">
            <livewire:search-synonyms />
        </div>
        <div class="col-span-12 lg:col-span-3 intro-y ">

            <div class="intro-y box p-4">
                <div class="d-flex flex-column flex-sm-row align-items-center p-5 border-bottom border-gray-200 dark-border-dark-5">
                    <h2 class="text-xl ">
                        Mais c'est quoi un synonyme ?
                    </h2>
                    <div class="text-gray-600 text-justify mt-4">
                    <p>La synonymie est un rapport de similarité sémantique entre des mots ou des expressions d'une même langue. La similarité sémantique indique qu'ils ont des significations très semblables. Des termes liés par synonymie sont des synonymes.</p>
                    <p class="mt-4">Il existe des bases de données de synonymes, présentées comme des dictionnaires, librement téléchargeables. On en trouve aussi vendues ou consultables sous la forme de livres, de logiciels, ou de sites web, ou de jeux.</p>

                    </div>
                    <div class="mt-4 flex ">
                        <a target="_blank" class="btn btn-link ml-auto" href="https://fr.wikipedia.org/wiki/Synonymie"><i class="fab fa-wikipedia-w"></i></a>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div>
@endsection
