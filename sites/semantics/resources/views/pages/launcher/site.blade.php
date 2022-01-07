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
            <x-analyse.launcher.tabs active="site"/>
            @livewire('analyse-site')
        </div>
        <div class="col-span-12 xl:col-span-4">
            <div class="intro-y box p-4">
                <div class="d-flex flex-column flex-sm-row align-items-center p-5 border-bottom border-gray-200 dark-border-dark-5">
                    <h2 class="text-xl ">
                        Analyse sémantique d'un site web au complet
                    </h2>

                    <div class="text-gray-600 text-justify mt-4">
                        <p>Ce traitement télécharge les différents contenus du site, puis effectue une analyse afin d'en extraire les principaux sujets.</p>
                        <p class="mt-4">
                            <strong>Atouts :</strong>
                            <ul class="list-disc list-inside">
                                <li>Une visiblité de toutes les expressions présentes sur le site analysé.</li>
                                <li>Un listing des mots-clés importants (Descripteurs)</li>
                                <li>Une analyse aussi bien globale que page par page</li>
                            </ul>
                        </p>
                        <p class="mt-4">
                            <strong>Paramètres</strong>
                            <ul class="list-disc list-inside">
                            <li><strong>Lien</strong> : Url point d'entrée du crawler.</li>
                            <li><strong>Maximum</strong> : Nombre maximal de pages qui seront téléchargées.</li>
                            <li><strong>Type</strong>: Données qui seront analysée. L'ensemble du contenu texte ou uniquement le contenu utile.</li>
                            </ul>
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
