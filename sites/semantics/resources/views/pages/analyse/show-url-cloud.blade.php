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

    <div class="grid grid-cols-12 gap-6 mt-8">
        <x-analyse.partials.title :job="$job" title="Analyse détaillée de la page - Nuage de mots-clés"/>

        <div class="col-span-12 lg:col-span-9 xxl:col-span-10">
            <div class="col-span-12">
                <div class="box mt-6 p-4">
                    <h2>Page étudiée : <strong>{{ $url->url }}</strong></h2>
                </div>
            </div>
            <div class="intro-y p-5 mt-5">
                <x-analyse.partials.word-cloud :data="$dataWordCloud" name="Sujets principaux" showMore="0"/>
            </div>
        </div>

        <div class="col-span-12 lg:col-span-3 xxl:col-span-2">
            <div class="intro-y box p-5 mt-6">
                <x-analyse.partials.navigation :job="$job" :url="$url"/>
            </div>
        </div>
    </div>


@endsection
