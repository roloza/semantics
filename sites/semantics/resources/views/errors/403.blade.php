@extends('layout')

@section('title')
    Syntex Factory
@endsection

@section('description')
    Analyse la sémantique de vos contenus web
@endsection

@section('keywords')
    analyse sémantique, mots-clés, descripteurs, analyse de texte, expressions
@endsection

@section('content')
    <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
        <h1 class="text-lg font-medium mr-auto">{{ $exception->getMessage() !== ""  ? $exception->getMessage() :  "Désolé, vous n'êtes pas autorisé à accéder à ce contenu."}}</h1>
    </div>
    <h2 class="font-medium mr-auto">Statut HTTP 403</h2>

    <div class="col-span-12 lg:col-span-9 xxl:col-span-10 mt-6 box p-5">
        <h2 class="font-medium mr-auto">Essayez les actions suivantes : </h2>
            @guest
                <a href="{{ route('login') }}" class="btn btn-outline-primary mt-3">{{ __('Log in') }}</a>
                <a href="{{ route('register') }}" class="btn btn-outline-primary mt-3">{{ __('Register') }}</a>
            @else
                Cette ressource n'est pas accessible avec votre utilisateur actuel :
            @endguest
            <a href="{{ route('accueil') }}" class="btn btn-outline-secondary mt-3">Retourner à l'accueil</a>
    </div>


@endsection
