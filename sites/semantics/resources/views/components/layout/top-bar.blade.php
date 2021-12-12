<div class="top-bar">
{{--    @include('generics.partials.breadcrumb')--}}
    {{-- @include('generics.partials.search')

    @include('generics.partials.notifications') --}}
    {{-- @include('generics.partials.account') --}}

    <x-layout.breadcrumb></x-layout.breadcrumb>

    <!-- Settings Dropdown -->
    @auth
    <div class="hidden sm:flex sm:items-center sm:ml-6">
        <x-dropdown align="right" width="48">
            <x-slot name="trigger">
                <button class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">

                        <div>
                            <img alt="Avatar" class="rounded-full w-8 h-8" src="{{ (new \App\Custom\Tools\Avatar(Auth::user()->email))->base64() }}">
                        </div>
                        <span class="ml-2">{{ Auth::user()->name }}</span>

                    <div class="ml-1">
                        <i class="fas fa-angle-down fill-current h-4 w-4"></i>

                    </div>
                </button>
            </x-slot>


            <x-slot name="content">
                <x-dropdown-link href="{{ route('user.profile') }}">Mon profil</x-dropdown-link>
                <x-dropdown-link href="{{ route('admin.posts.index') }}">Admin</x-dropdown-link>
                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-dropdown-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-dropdown-link>
                </form>
            </x-slot>
        </x-dropdown>
    </div>
    @else
        <div class="hidden sm:flex sm:items-center sm:ml-6">
        <a href="{{ route('login') }}" class="text-sm text-gray-700 dark:text-gray-500 ">Se connecter</a>

        @if (Route::has('register'))
            <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 dark:text-gray-500 ">S'enregistrer</a>
        @endif
        </div>
    @endauth

</div>
