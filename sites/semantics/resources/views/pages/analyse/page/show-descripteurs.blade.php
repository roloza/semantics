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
    <div class="col-span-12">
        <h1 class="text-lg font-medium truncate mr-5">Principaux mots-clés</h1>
    </div>

    <div class="col-span-12 lg:col-span-9 xxl:col-span-10">
        <div class="intro-y box p-5 mt-5">
            <livewire:descripteurs-table :uuid="$uuid" />
        </div>
    </div>

    <div class="col-span-12 lg:col-span-3 xxl:col-span-2">
        <div class="intro-y box p-5 mt-6">
            <x-analyse.partials.navigation :uuid="$uuid"/>
        </div>
    </div>
</div>
@endsection
