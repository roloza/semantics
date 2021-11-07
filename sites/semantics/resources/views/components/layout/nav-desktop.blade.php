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
            <a href="{{ route('accueil') }}" class="side-menu side-menu--active">
                <div class="side-menu__icon">
                    <i data-feather="home"></i>
                </div>
                <div class="side-menu__title">
                    Accueil
                </div>
            </a>
        </li>

        <li>
            <a href="{{ route('analyse.list') }}" class="side-menu">
                <div class="side-menu__icon">
                    <i data-feather="activity"></i>
                </div>
                <div class="side-menu__title">
                    Mes analyses
                </div>
            </a>
        </li>

    </ul>
</nav>
<!-- END: Side Menu -->
