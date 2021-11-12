<div>
    <div class="intro-y flex items-center h-10 mb-4">
        <h2 class="text-lg font-medium truncate mr-5">Etudier la data</h2>
    </div>

    <div class="mt-1">
        <a href="{{ route('analyse.page.show', $uuid) }}" class="flex items-center px-3 py-2 mt-2 rounded-md truncate {{ request()->routeIs('analyse.page.show') ? 'bg-theme-1 text-white font-medium ' : '' }}">
            Vue d'ensemble
        </a>
        <a href="{{ route('analyse.page.show.keywords.all', $uuid) }}" class="flex items-center px-3 py-2 mt-2 rounded-md truncate {{ request()->routeIs('analyse.page.show.keywords.all') ? 'bg-theme-1 text-white font-medium ' : '' }}">
            Tous les mots-clés
        </a>
        <a href="{{ route('analyse.page.show.descripteurs', $uuid) }}" class="flex items-center px-3 py-2 mt-2 rounded-md truncate {{ request()->routeIs('analyse.page.show.descripteurs') ? 'bg-theme-1 text-white font-medium ' : '' }}">
            Sujets principaux
        </a>
        <a href="{{ route('analyse.page.show.suggestions', $uuid) }}" class="flex items-center px-3 py-2 mt-2 rounded-md truncate {{ request()->routeIs('analyse.page.show.suggestions') ? 'bg-theme-1 text-white font-medium ' : '' }}">
            Suggestions de thématiques
        </a>
        <a href="" class="flex items-center px-3 py-2 mt-2 rounded-md truncate">
            Audit de la structure HTML
        </a>
        <a href="" class="flex items-center px-3 py-2 mt-2 rounded-md truncate">
            Détails des urls
        </a>
        <ul>
            <li><a href="" class="flex items-center px-4 py-1 mt-2 ml-5 rounded-md text-white bg-gray-400 font-medium">Mots-clés</a></li>
            <li><a href="" class="flex items-center px-4 py-1 mt-2 ml-5 rounded-md">Nuage</a></li>
            <li><a href="" class="flex items-center px-4 py-1 mt-2 ml-5 rounded-md">Audit de la structure HTML</a></li>
        </ul>
    </div>
</div>
