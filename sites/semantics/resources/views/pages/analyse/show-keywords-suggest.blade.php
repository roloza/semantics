
@extends('layout')

@section('title')
    Suggestions
@endsection

@section('description')
    Analyser la sémantique, un page unique, un site entier ou encore le web en général
@endsection

@section('keywords')
    analyse sémantique, mots-clés, descripteurs, analyse de texte, expressions
@endsection

@section('content')

<div class="grid grid-cols-12 gap-6 mt-8">

    <x-analyse.partials.title :job="$job" title="Idées d'expressions avec {{$job->name}}"/>
        <div class="col-span-12 lg:col-span-9 xxl:col-span-10">
            <livewire:keywords-suggest-search :job="$job" :keyword="$keyword"/>
        </div>

        <div class="col-span-12 lg:col-span-3 xxl:col-span-2">
            <div class="intro-y box p-5 mt-6">
                <x-analyse.partials.navigation :job="$job"/>
            </div>
        </div>
</div>


@endsection
