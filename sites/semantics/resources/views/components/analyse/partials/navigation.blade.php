<div>
    <div class="intro-y flex items-center h-10 mb-4">
        <h2 class="text-lg font-medium truncate mr-5">Etudier la data</h2>
    </div>

    <div class="mt-1">
        {{-- All --}}
        <a href="{{ route('analyse.show', [$job->type->slug, $job->uuid]) }}" class="flex items-center px-3 py-2 mt-2 rounded-md truncate {{ request()->routeIs('analyse.show') ? 'bg-theme-1 text-white font-medium ' : '' }}">
            Vue d'ensemble
        </a>

        {{-- All --}}
        <a href="{{ route('analyse.show.keywords.all',[$job->type->slug, $job->uuid]) }}" class="flex items-center px-3 py-2 mt-2 rounded-md truncate {{ request()->routeIs('analyse.show.keywords.all') ? 'bg-theme-1 text-white font-medium ' : '' }}">
            Tous les mots-clés
        </a>

        {{-- All --}}
        @if (isset($num))
        <ul>
            <li><span class="flex items-center px-4 py-1 mt-2 ml-5 rounded-md {{ request()->routeIs('analyse.show.keyword') ? 'text-white bg-gray-400 font-medium ' : '' }}">Mot-clé</span></li>
        </ul>
        @endif

        {{-- All --}}
        <a href="{{ route('analyse.show.descripteurs', [$job->type->slug, $job->uuid]) }}" class="flex items-center px-3 py-2 mt-2 rounded-md truncate {{ request()->routeIs('analyse.show.descripteurs') ? 'bg-theme-1 text-white font-medium ' : '' }}">
            Sujets principaux
        </a>

        {{-- All --}}
        <a href="{{ route('analyse.show.suggestions', [$job->type->slug, $job->uuid]) }}" class="flex items-center px-3 py-2 mt-2 rounded-md truncate {{ request()->routeIs('analyse.show.suggestions') ? 'bg-theme-1 text-white font-medium ' : '' }}">
            Suggestions de thématiques
        </a>

        {{-- Page --}}
        @if($job->type->slug === 'page')
            <a href="{{ route('analyse.show.url.audit', ['type' => $job->type->slug, 'uuid' => $job->uuid, 'doc_id' => 1]) }}" class="flex items-center px-3 py-2 mt-2 rounded-md truncate">
                Audit de la structure HTML
            </a>
        @endif

        {{-- Site / keyword --}}
        @if($job->type->slug === 'site' || $job->type->slug === 'keyword')
            <a href="{{ route('analyse.show.urls', [$job->type->slug, $job->uuid]) }}" class="flex items-center px-3 py-2 mt-2 rounded-md truncate {{ request()->routeIs('analyse.show.urls') ? 'bg-theme-1 text-white font-medium ' : '' }}">
                Détails des urls
            </a>

            {{-- Site / keyword --}}
            @if (isset($url))
            <ul>
                <li><a href="{{ route('analyse.show.url', ['type' => $job->type->slug, 'uuid' => $job->uuid, 'doc_id' => $url->doc_id]) }}" class="flex items-center px-4 py-1 mt-2 ml-5 rounded-md {{ request()->routeIs('analyse.show.url') ? 'text-white bg-gray-400 font-medium ' : '' }}">Url - Sujets principaux</a></li>
                <li><a href="{{ route('analyse.show.url.cloud', ['type' => $job->type->slug, 'uuid' => $job->uuid, 'doc_id' => $url->doc_id]) }}" class="flex items-center px-4 py-1 mt-2 ml-5 rounded-md {{ request()->routeIs('analyse.show.url.cloud') ? 'text-white bg-gray-400 font-medium ' : '' }}">Nuage</a></li>
                <li><a href="{{ route('analyse.show.url.audit', ['type' => $job->type->slug, 'uuid' => $job->uuid, 'doc_id' => $url->doc_id]) }}" class="flex items-center px-4 py-1 mt-2 ml-5 rounded-md {{ request()->routeIs('analyse.show.url.audit') ? 'text-white bg-gray-400 font-medium ' : '' }}">Audit de la structure HTML</a></li>
            </ul>
            @endif
        @endif
    </div>
</div>
