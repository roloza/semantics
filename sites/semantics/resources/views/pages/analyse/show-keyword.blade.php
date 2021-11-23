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
            <div class="col-span-12 lg:col-span-8 xl:col-span-6">
                <div class="report-box-2 intro-y">
                    <div class="box sm:flex">
                        <div class="px-8 py-12 flex flex-col justify-center flex-1">
                            <div class="relative text-3xl font-bold mb-12">
                                {{ ucfirst($keyword->forme) }}
                            </div>
                            <div class="text-theme-12 text-5xl">
                                <i class="fas fa-hashtag"></i>
                            </div>
                            <div class="relative text-3xl font-bold mt-12 pl-4">
                                {{ $keyword->freq }}
                            </div>

                            <div class="mt-4 text-gray-600 dark:text-gray-600">Nombre d'occurences du mot-clé dans le corpus</div>
                        </div>
                        <div class="px-8 py-12 flex flex-col justify-center flex-1 border-t sm:border-t-0 sm:border-l border-gray-300 dark:border-dark-5 border-dashed">
                            <div class="text-gray-600 dark:text-gray-600 text-xs">Forme lemmatisée</div>
                            <div class="mt-1.5 flex items-center">
                                <div class="text-base">{{ ucfirst($keyword->lemme) }}</div>

                            </div>
                            <div class="text-gray-600 dark:text-gray-600 text-xs mt-5">Catégorie grammaticale</div>
                            <div class="mt-1.5 flex items-center">
                                <div class="text-base">{{ $keyword->category_name }}</div>
                            </div>
                            <div class="text-gray-600 dark:text-gray-600 text-xs mt-5">Nombre de documents</div>
                            <div class="mt-1.5 flex items-center">
                                <div class="text-base">{{ $keyword->nb_doc }}</div>
                            </div>
                            <div class="text-gray-600 dark:text-gray-600 text-xs mt-5">Nombre d'including</div>
                            <div class="mt-1.5 flex items-center">
                                <div class="text-base">{{ $keyword->nincl }}</div>
                            </div>
                            <div class="text-gray-600 dark:text-gray-600 text-xs mt-5">Longueur de l'expression</div>
                            <div class="mt-1.5 flex items-center">
                                <div class="text-base">{{ $keyword->longueur }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- END Informations générales --}}

            {{-- BEGIN Synonymes --}}
            @if(count($keywordsSuggest) > 0 || count($synonymsByKeywords) > 0 | count($antonymesByKeywords) > 0)
                <div class="col-span-12 lg:col-span-8 xl:col-span-6">
                    <div class="report-box-2 xl:min-h-0 intro-x">
                        <div class="max-h-full xl:overflow-y-auto box ">
                            <div class="bg-white dark:bg-dark-3 xl:sticky top-0 px-5 pt-5 pb-6">

                                <div class="boxed-tabs nav nav-tabs justify-center border border-gray-400 border-dashed text-gray-600 dark:border-gray-700 dark:bg-dark-3 dark:text-gray-500 rounded-md p-1 mt-5 mx-auto" role="tablist">
                                    @if(count($keywordsSuggest) > 0)
                                        <a data-toggle="tab" data-target="#suggestions" href="javascript:;" class="btn flex-1 border-0 shadow-none py-1 px-2 active" id="suggestions-tab" role="tab" aria-controls="suggestions" aria-selected="true">Sur le même thême</a>
                                    @endif
                                    <a data-toggle="tab" data-target="#synonymes" href="javascript:;" class="btn flex-1 border-0 shadow-none py-1 px-2" id="synonymes-tab" role="tab" aria-controls="synonymes" aria-selected="true">Synonymes</a>
                                    <a data-toggle="tab" data-target="#antonymes" href="javascript:;" class="btn flex-1 border-0 shadow-none py-1 px-2" id="antonymes-tab" role="tab" aria-selected="false">Antonymes</a>
                                </div>
                            </div>
                            <div class="tab-content px-5 pb-5">
                                @if(count($keywordsSuggest) > 0)
                                    <div class="tab-pane active" id="suggestions" role="tabpanel" aria-labelledby="suggestions-tab">
                                        <div class="mt-2">
                                            @foreach($keywordsSuggest as $keywordSuggest)
                                                <a href="{{ route('analyse.show.keyword', ['type' => $job->type->slug, 'uuid' => $job->uuid, 'num' => $keywordSuggest['num']]) }}" style="line-height: 2rem" class="py-1 px-2 mb-2 rounded-full text-xs bg-gray-200 dark:bg-dark-5 text-gray-600 dark:text-gray-300 ml-auto truncate">{{ ucfirst($keywordSuggest['forme']) }}</a>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                                <div class="tab-pane" id="synonymes" role="tabpanel" aria-labelledby="synonymes-tab">
                                    @foreach($synonymsByKeywords as $kw => $synonyms)
                                        <h3 class="text-lg font-medium truncate mr-3 mt-5">{{ ucfirst($kw) }}</h3>
                                        <div class="mt-2">
                                            @foreach($synonyms as $synonym)
                                                @if ($synonym instanceof \App\Models\SyntexRtListe)
                                                    <a href="{{ route('analyse.show.keyword', ['type' => $job->type->slug, 'uuid' => $job->uuid, 'num' => $synonym->num]) }}" style="line-height: 2rem" class="py-1 px-2 mb-2 rounded-full text-xs bg-gray-200 dark:bg-dark-5 text-gray-600 dark:text-gray-300 ml-auto truncate">{{ ucfirst($synonym->lemme) }}</a>
                                                @else
                                                    <span style="line-height: 2rem" class="py-1 px-2 mb-2 rounded-full text-xs bg-gray-200 dark:bg-dark-5 text-gray-600 dark:text-gray-300 ml-auto truncate">{{ ucfirst($synonym) }}</span>
                                                @endif
                                            @endforeach
                                        </div>
                                    @endforeach
                                </div>

                                <div class="tab-pane" id="antonymes" role="tabpanel" aria-labelledby="antonymes-tab">
                                    @foreach($antonymesByKeywords as $kw => $antonyms)
                                        <h3 class="text-lg font-medium truncate mr-3 mt-5">{{ ucfirst($kw) }}</h3>
                                        <div class="mt-2">
                                            @foreach($antonyms as $antonym)
                                                @if ($antonym instanceof \App\Models\SyntexRtListe)
                                                    <a href="{{ route('analyse.show.keyword', ['type' => $job->type->slug, 'uuid' => $job->uuid, 'num' => $antonym->num]) }}" style="line-height: 2rem" class="py-1 px-2 mb-2 rounded-full text-xs bg-gray-200 dark:bg-dark-5 text-gray-600 dark:text-gray-300 ml-auto truncate">{{ ucfirst($antonym->lemme) }}</a>
                                                @else
                                                    <span style="line-height: 2rem" class="py-1 px-2 mb-2 rounded-full text-xs bg-gray-200 dark:bg-dark-5 text-gray-600 dark:text-gray-300 ml-auto truncate">{{ ucfirst($antonym) }}</span>
                                                @endif
                                            @endforeach
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            {{-- END Synonymes --}}
        </div>
    </div>

    <div class="col-span-12 lg:col-span-3 xxl:col-span-2">
        <div class="intro-y box p-5 mt-6">
            <x-analyse.partials.navigation :job="$job" :num="$keyword->num"/>
        </div>
    </div>

    {{-- Expressions suggests --}}
    <div class="col-span-12 lg:col-span-8 xl:col-span-6 mt-5">
        <div class="report-box-2 xl:min-h-0 intro-x">
            <div class="max-h-full xl:overflow-y-auto box ">
                <div class="bg-white dark:bg-dark-3 xl:sticky top-0 px-5 pt-5 pb-6">
                    <div class="intro-y block sm:flex items-center h-10">
                        <h2 class="text-lg font-medium truncate mr-5">Expressions suggérées</h2>
                    </div>
                    <div class="boxed-tabs nav nav-tabs justify-center border border-gray-400 border-dashed text-gray-600 dark:border-gray-700 dark:bg-dark-3 dark:text-gray-500 rounded-md p-1 mt-5 mx-auto" role="tablist">
                        <a data-toggle="tab" data-target="#includings" href="javascript:;" class="btn flex-1 border-0 shadow-none py-1 px-2 active" id="includings-tab" role="tab" aria-controls="includings" aria-selected="true">{{ ucfirst($keyword->lemme) }}</a>
                        @foreach($keywordsIncludeds as $kw => $includeds)
                            <a data-toggle="tab" data-target="#included-{{\Illuminate\Support\Str::slug($kw)}}" href="javascript:;" class="btn flex-1 border-0 shadow-none py-1 px-2" id="included-{{\Illuminate\Support\Str::slug($kw)}}-tab" role="tab" aria-controls="included-{{\Illuminate\Support\Str::slug($kw)}}" aria-selected="true">{{ ucfirst($kw) }}</a>
                        @endforeach
                    </div>
                </div>

                <div class="tab-content px-5 pb-5">
                    <div class="tab-pane active" id="includings" role="tabpanel" aria-labelledby="includings-tab">
                        @foreach($includings as $including)
                            <a href="{{ route('analyse.show.keyword', ['type' => $job->type->slug, 'uuid' => $job->uuid, 'num' => $including->num]) }}" style="line-height: 2rem" class="py-1 px-2 mb-2 rounded-full text-xs bg-gray-200 dark:bg-dark-5 text-gray-600 dark:text-gray-300 ml-auto truncate">{{ ucfirst($including->forme) }}</a>
                        @endforeach
                    </div>
                    @foreach($keywordsIncludeds as $kw => $includeds)
                        <div class="tab-pane" id="included-{{\Illuminate\Support\Str::slug($kw)}}" role="tabpanel" aria-labelledby="included-{{\Illuminate\Support\Str::slug($kw)}}-tab">
                            @foreach($includeds as $included)

                                <a href="{{ route('analyse.show.keyword', ['type' => $job->type->slug, 'uuid' => $job->uuid, 'num' => $included->num]) }}" style="line-height: 2rem" class="py-1 px-2 mb-2 rounded-full text-xs bg-gray-200 dark:bg-dark-5 text-gray-600 dark:text-gray-300 ml-auto truncate">{{ ucfirst($included->forme) }}</a>
                            @endforeach
                        </div>
                    @endforeach
                </div>

            </div>
        </div>
    </div>
    {{-- END Expressions suggests --}}

    {{-- BEGIN keyword Documents --}}
    @if(count($keywordDocs) > 0)
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
                            {{-- <a href="{{ route('analyse.show.url', ['uuid' => $uuid, 'url_id' => $keywordDoc->doc_id]) }}" class="btn btn-sm btn-dark w-32 mr-2 mb-2">Détails</a> --}}
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
