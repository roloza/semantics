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
    <x-analyse.partials.title :job="$job" title="Mot-clé : {{ ucfirst($keyword->forme) }}"/>

    <div class="col-span-12 lg:col-span-9 xxl:col-span-10 mt-6">
        <div class="grid grid-cols-12 gap-6">
            {{-- BEGIN Informations générales --}}
            <x-analyse.partials.keyword-informations :keyword="$keyword"/>
            {{-- END Informations générales --}}

             {{-- BEGIN Theme / Synonymes / Antonymes --}}
            <x-analyse.partials.theme-tabs :job="$job" :keywordsSuggest="$keywordsSuggest" :synonymsByKeywords="$synonymsByKeywords" :antonymesByKeywords="$antonymesByKeywords"/>
            {{-- END Theme / Synonymes / Antonymes --}}
        </div>
    </div>

    <div class="col-span-12 lg:col-span-3 xxl:col-span-2">
        <div class="intro-y box p-5 mt-6">
            <x-analyse.partials.navigation :job="$job" :num="$keyword->num"/>
        </div>
    </div>

    {{-- BEGIN Expressions suggests --}}
    <x-analyse.partials.keyword-suggest-tabs :job="$job" :keyword="$keyword" :keywordsIncludeds="$keywordsIncludeds" :includings="$includings"/>
    {{-- END Expressions suggests --}}

    {{-- BEGIN keyword Documents --}}
    @if(count($keywordDocs) > 0 && ($job->type->slug === 'site' || $job->type->slug === 'keyword'))
    <div class="col-span-12 mt-6">
        <div class="box p-5 mt-5">
            <div class="intro-y block sm:flex items-center h-10">
                <h2 class="text-lg font-medium truncate mr-5">Liste des pages dont &laquo;{{ ucfirst($keyword->forme) }}&raquo; est descripteur.</h2>
            </div>
            <div class="intro-y overflow-auto lg:overflow-visible mt-8 sm:mt-0">
                <table class="table table-report sm:mt-2">
                    <thead>
                    <tr>
                        <th class="whitespace-nowrap">Url</th>
                        <th class="whitespace-nowrap">Score</th>
                        <th class="text-center whitespace-nowrap">Score pondéré</th>
                        <th class="text-center whitespace-nowrap">Occrurences</th>
                        <th class="text-center whitespace-nowrap">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($keywordDocs as $keywordDoc)
                    <tr class="intro-x">
                        <td>
                            <a href="" class="font-medium whitespace-nowrap">{{ $keywordDoc->url->url }}</a>
                            <div class="text-gray-600 text-xs whitespace-nowrap mt-0.5">{{ $keywordDoc->url->title }}</div>
                        </td>
                        <td class="text-center">{{ $keywordDoc->score }}</td>
                        <td class="text-center">{{ $keywordDoc->score_moy }}</td>
                        <td class="text-center">{{ $keywordDoc->freq_doc }}</td>
                        <td class="text-center">
                            <a href="{{ route('analyse.show.url', ['type' => $job->type->slug, 'uuid' => $job->uuid, 'doc_id' => $keywordDoc->doc_id]) }}" class="btn btn-sm btn-dark w-32 mr-2 mb-2">Détails</a>
                        </td>

                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif
    {{-- END keyword Documents --}}
</div>

@endsection
