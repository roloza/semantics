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
        <h1 class="text-lg font-medium mr-auto">Détails du profil</h1>
    </div>

    <div class="intro-y box px-5 pt-5 mt-5">
        <div class="flex flex-col lg:flex-row border-b border-gray-200 dark:border-dark-5 pb-5 -mx-5">
            <div class="flex flex-1 px-5 items-center justify-center lg:justify-start">
                <div class="w-20 h-20 sm:w-24 sm:h-24 flex-none lg:w-32 lg:h-32 image-fit relative">
                    <img alt="Avatar" class="rounded-full" src="{{ (new \App\Custom\Tools\Avatar($user->email))->base64() }}">
                </div>
                <div class="ml-5">
                    <div class="w-24 sm:w-40 truncate sm:whitespace-normal font-medium text-lg">{{ $user->name }}</div>
                    <div class="text-gray-600">Inscription: {{ \Carbon\Carbon::parse($user->created_at)->format('j M, Y') }}</div>
                </div>
            </div>
            <div class="mt-6 lg:mt-0 flex-1 dark:text-gray-300 px-5 border-l border-r border-gray-200 dark:border-dark-5 border-t lg:border-t-0 pt-5 lg:pt-0">
                <div class="font-medium text-center lg:text-left lg:mt-3">Détails</div>
                <div class="flex flex-col justify-center items-center lg:items-start mt-4">
                    <div class="truncate sm:whitespace-normal flex items-center">
                        <i class="far fa-envelope  w-4 h-4 mr-2"></i>{{ $user->email }}
                    </div>
                </div>
            </div>
            <div class="mt-6 lg:mt-0 flex-1 flex items-center justify-center px-5 border-t lg:border-0 border-gray-200 dark:border-dark-5 pt-5 lg:pt-0">
                <div class="text-center rounded-md w-20 py-3">
                    <div class="font-medium text-theme-1 dark:text-theme-10 text-xl">{{ $jobs->count() }}</div>
                    <div class="text-gray-600">Analyses lancées</div>
                </div>

            </div>
        </div>

    </div>

    <div class="grid grid-cols-12 gap-6 mt-8">
        @foreach($jobs as $job)
        <div class="intro-y box col-span-12 xxl:col-span-6">
            <div class="flex items-center px-5 py-5 sm:py-3 border-b border-gray-200 dark:border-dark-5">
                <h2 class="font-medium text-base mr-auto">{{ $job->type->name }}</h2>


            </div>
            <div class="p-5">
                <div class="font-medium text-lg m-b-4">{{ $job->name }}</div>
                <ul class="list-none md:list-disc ml-2 md:ml-12">
                @foreach($job->parameters as $param)
                        <li class="font-small text-small"><strong>{{ $param->name }}</strong>  : {{ $param->value }}</li>
                @endforeach
                </ul>
            </div>
            <div class="p-5 border-t border-gray-200 dark:border-dark-5 flex">
                <a href="{{ route('analyse.show', ['type' => $job->type->name, 'uuid' => $job->uuid]) }}" class="btn btn-primary py-1 px-2 ml-auto">Accéder</a>
            </div>
        </div>
        @endforeach


    </div>

@endsection
