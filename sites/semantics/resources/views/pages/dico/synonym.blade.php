
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

    <p>
        Un synonyme est un terme ou une liste de termes dont la signification est semblable à celui d'un autre. Il est utilisé pour dire la même chose qu’un autre afin d’éviter une répétition. Il a la même signification qu’un autre mot ou quasi semblable.
        Vous souhaitez maintenir l’attention de votre lecteur, venir enrichir votre vocabulaire, varier vos expressions, ou encore préciser vos idées ? Venez parcourir ce dictionnaire synonyme en ligne, très clair et facile d’utilisation. Il vous proposera toute une liste de mots semblables à celui que vous recherchez et vous évitera de faire des répétitions dans une phrase sans changer votre texte !
    </p>

    <div class="col-span-12 lg:col-span-9 xxl:col-span-10">
        <livewire:search-synonyms />
    </div>


@endsection
