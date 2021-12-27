
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
                        <p>Deux items lexicaux sont en relation d'antonymie si on peut exhiber une symétrie de leurs traits sémantiques par rapport à un axe. Les mots en relation d'antonymie sont appelés antonymes ou couramment contraires. La symétrie peut se décliner de différentes manières, selon la nature de son support.</p>
                        <p class="mt-4">On distingue plusieurs supports qui sont autant de types d'antonymie :</p>
                        <ul class="list-disc list-inside mt-4">
                            <li class="mt-2"><strong>antonymie complémentaire</strong> : <small>concerne l'application ou la non-application d'une propriété ( 'applicable' / 'non-applicable' , 'présence' / 'absence' ) : par exemple, 'informe' est antonyme de tout ce qui a une forme, de même que 'insipide' , 'incolore' , 'inodore' , etc. de tout ce qui pourrait avoir saveur, couleur, odeur, …</small></li>
                            <li  class="mt-2"><strong>antonymie scalaire</strong> : <small>concerne une propriété affectant une valeur étalonnable (valeur élevée, valeur faible) : par exemple, 'chaud' , 'froid' sont des valeurs symétriques de température</small></li>
                            <li  class="mt-2"><strong>antonymie duale</strong> : <small>l'existence d'une propriété ou d'un élément considérés comme symétriques par l'usage (par exemple 'soleil' 'lune' , ou par des propriétés naturelles ou physiques des objets considérés</small></li>
                        </ul>
                    </div>
                </div>

                <div class="mt-4 flex ">
                    <a target="_blank" class="btn btn-link ml-auto" href="https://fr.wikipedia.org/wiki/Antonymie"><i class="fab fa-wikipedia-w"></i></a>
                </div>
            </div>
        </div>
    </div>

@endsection


