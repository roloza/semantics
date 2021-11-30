
<nav x-data="{ open: false }"  class="sm:hidden">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center sm:hidden">
                    <a href="{{ route('accueil') }}">
                        <x-application-logo class="block h-10 w-auto fill-current text-white" />
                    </a>
                </div>
            </div>
            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md  focus:outline-none  transition duration-150 ease-in-out text-white">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('accueil')" :active="request()->routeIs('accueil')">{{ __('Accueil') }}</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('analyse.list')" :active="request()->routeIs('analyse.list')">{{ __('Mes analyses') }}</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('analyse.list')" :active="request()->routeIs('analyse.list')">{{ __('Démos') }}</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('analyse.launcher.page')" :active="request()->routeIs('analyse.launcher.page')">{{ __('Analyser') }}</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('analyse.suggest')" :active="request()->routeIs('analyse.suggest')">{{ __('Trouver des Suggestions') }}</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('dictionnaire.synonyms')" :active="request()->routeIs('analyse.synonyms')">{{ __('Dico Synonymes') }}</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('dictionnaire.antonyms')" :active="request()->routeIs('analyse.antonyms')">{{ __('Dico Antonymes') }}</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('dictionnaire.antonyms')" :active="request()->routeIs('analyse.list')">{{ __('Actualités') }}</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('dictionnaire.antonyms')" :active="request()->routeIs('analyse.list')">{{ __('FAQ') }}</x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-b border-gray-200 mb-4">
            @auth
            <div class="px-4">
                <div class="font-medium text-base text-white">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-white">{{ Auth::user()->email }}</div>
            </div>

            <div class="space-y-1">
                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                                           onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
            @endauth
        </div>
    </div>
</nav>
