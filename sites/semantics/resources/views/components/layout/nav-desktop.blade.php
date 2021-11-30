<!-- BEGIN: Side Menu -->
<nav class="side-nav">
    <a href="" class="intro-x flex items-center pl-5 pt-4">

        <span class="hidden xl:block text-white text-lg ml-3">
                    Ru<span class="font-medium">bick</span>
                </span>
    </a>
    <div class="side-nav__devider my-6"></div>
    <ul>
        <li>
            <a href="{{ route('accueil') }}" class="side-menu {{ request()->routeIs('accueil') ? 'side-menu--active' : '' }}">
                <div class="side-menu__icon">
                    <i class="fas fa-home"></i>
                </div>
                <div class="side-menu__title">
                    Accueil
                </div>
            </a>
        </li>

        <li>
            <a href="{{ route('analyse.list') }}" class="side-menu {{ request()->routeIs('analyse.list') ? 'side-menu--active' : '' }}">
                <div class="side-menu__icon">
                    <i class="fas fa-list"></i>
                </div>
                <div class="side-menu__title">
                    Mes analyses
                </div>
            </a>
        </li>

        <li>
            <a href="#" class="side-menu">
                <div class="side-menu__icon">
                    <i class="far fa-lemon"></i>
                </div>
                <div class="side-menu__title">
                    Démos
                </div>
            </a>
        </li>

        <div class="side-nav__devider my-6"></div>

        <li>
            <a href="javascript:;" class="side-menu side-menu-parent {{  request()->routeIs('analyse.launcher*') ? 'side-menu--active  side-menu--open' : '' }}">
                <div class="side-menu__icon">
                    <i class="fas fa-search"></i>
                </div>
                <div class="side-menu__title">
                    Analyser
                    <div class="side-menu__sub-icon">
                        <i class="fas fa-chevron-down"></i>
                    </div>
                </div>
            </a>
            <ul class="{{ request()->routeIs('analyse.launcher*') ? 'show' : '' }}">
                <li>
                    <a href="{{ route('analyse.launcher.page') }}" class="side-menu {{ request()->routeIs('analyse.launcher.page') ? 'side-menu--active' : '' }}">
                        <div class="side-menu__icon">
                            <i class="far fa-file"></i>
                        </div>
                        <div class="side-menu__title">
                            Une page
                        </div>
                    </a>
                </li>
                <li>
                    <a href="{{ route('analyse.launcher.site') }}" class="side-menu {{ request()->routeIs('analyse.launcher.site') ? 'side-menu--active' : '' }}">
                        <div class="side-menu__icon">
                            <i class="far fa-copy"></i>
                        </div>
                        <div class="side-menu__title">
                            Un site
                        </div>
                    </a>
                </li>

                <li>
                    <a href="{{ route('analyse.launcher.web') }}" class="side-menu {{ request()->routeIs('analyse.launcher.web') ? 'side-menu--active' : '' }}">
                        <div class="side-menu__icon">
                            <i class="fab fa-searchengin"></i>
                        </div>
                        <div class="side-menu__title">
                            Le web
                        </div>
                    </a>
                </li>

                <li>
                    <a href="{{ route('analyse.launcher.custom') }}" class="side-menu {{ request()->routeIs('analyse.launcher.custom') ? 'side-menu--active' : '' }}">
                        <div class="side-menu__icon">
                            <i class="far fa-file-excel"></i>
                        </div>
                        <div class="side-menu__title">
                            Mon contenu
                        </div>
                    </a>
                </li>
            </ul>
        </li>

        <li>
            <a href="{{ route('analyse.suggest') }}" class="side-menu {{ request()->routeIs('analyse.suggest') ? 'side-menu--active' : '' }}">
                <div class="side-menu__icon">
                    <i class="fas fa-hat-wizard"></i>
                </div>
                <div class="side-menu__title">
                    Trouver des Suggestions
                </div>
            </a>
        </li>
        <li>
            <a href="{{ route('dictionnaire.synonyms') }}" class="side-menu {{ request()->routeIs('dictionnaire.synonyms') ? 'side-menu--active' : '' }}">
                <div class="side-menu__icon">
                    <i class="fas fa-pen"></i>
                </div>
                <div class="side-menu__title">
                    Dico Synonymes
                </div>
            </a>
        </li>
        <li>
            <a href="{{ route('dictionnaire.antonyms') }}" class="side-menu {{ request()->routeIs('dictionnaire.antonyms') ? 'side-menu--active' : '' }}">
                <div class="side-menu__icon">
                    <i class="fas fa-pen-alt"></i>
                </div>
                <div class="side-menu__title">
                    Dico Antonymes
                </div>
            </a>
        </li>
        <div class="side-nav__devider my-6"></div>
        <li>
            <a href="#" class="side-menu">
                <div class="side-menu__icon">
                    <i class="far fa-newspaper"></i>
                </div>
                <div class="side-menu__title">
                    Actualités
                </div>
            </a>
        </li>
        <li>
            <a href="#" class="side-menu">
                <div class="side-menu__icon">
                    <i class="far fa-question-circle"></i>
                </div>
                <div class="side-menu__title">
                    FAQ
                </div>
            </a>
        </li>
    </ul>
</nav>
<!-- END: Side Menu -->
