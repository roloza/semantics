<!-- BEGIN: Account Menu -->
<div>
    @if (Route::has('login'))
    <div class="">
        @auth
            <a href="{{ url('/dashboard') }}" class="text-sm text-gray-700 dark:text-gray-500 ">{{ Auth::user()->name }}</a>
        @else
            <a href="{{ route('login') }}" class="text-sm text-gray-700 dark:text-gray-500 ">Se connecter</a>

            @if (Route::has('register'))
                <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 dark:text-gray-500 ">S'enregistrer</a>
            @endif
        @endauth
    </div>
@endif

</div>
<!-- END: Account Menu -->
