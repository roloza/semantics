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

    <h2 class="intro-y text-lg font-medium mt-10">Gestionnaire d'images</h2>

    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    @livewire('admin.images')

@endsection
