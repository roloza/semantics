<!DOCTYPE html>
<html lang="fr">
<!-- BEGIN: Head -->
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="description" content="@yield('description')">
    <meta name="keywords" content="@yield('keywords')">
    <meta name="author" content="Roloza">

    <title>@yield('title')</title>

    <!-- BEGIN: CSS Assets-->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    @yield('style')
    @livewireStyles
    <!-- END: CSS Assets-->
</head>
<!-- END: Head -->

<body class="main">

    {{-- <x-layout.nav-mobile></x-layout.nav-mobile> --}}
    {{-- <div class="flex"> --}}
    <div class="flex">
        <x-layout.nav-desktop></x-layout.nav-desktop>
        <div class="content">
            <x-layout.top-bar></x-layout.top-bar>
            @yield('content')
        </div>
    </div>

<!-- BEGIN: JS Assets-->
{{-- <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.8.2/dist/alpine.min.js" defer></script> --}}
<script src="{{ mix('js/app.js') }}"></script>
@yield('script')
@livewireScripts
<!-- END: JS Assets-->

</body>

</html>
