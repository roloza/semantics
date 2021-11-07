<div class="intro-y pr-1">
    <div class="box p-2">
        <div class="pos__tabs nav nav-tabs justify-center">
            <a href="{{ route('analyse.launcher.page') }}" class="flex-1 py-2 rounded-md text-center {{ $active === "page" ? 'active' : ''}}">Page</a>
            <a href="{{ route('analyse.launcher.site') }}" class="flex-1 py-2 rounded-md text-center {{ $active === "site" ? 'active' : '' }}">Site</a>
            <a href="{{ route('analyse.launcher.web') }}" class="flex-1 py-2 rounded-md text-center {{ $active === "web" ? 'active' : '' }}">Web</a>
            <a href="{{ route('analyse.launcher.custom') }}" class="flex-1 py-2 rounded-md text-center {{ $active === "custom" ? 'active' : '' }}">Personalisé</a>
        </div>
    </div>
</div>
