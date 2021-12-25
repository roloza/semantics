<!--  BEGIN: Search Analyse  -->
<div class="xl:col-start-4 xl:col-span-6 col-span-12 mt-8">
    <div class="intro-y flex flex-col-reverse sm:flex-row items-center">
        <div class="w-full relative mr-auto mt-3 sm:mt-0 ">
            <div class="flex justify-center">
                <h1 class="text-lg font-medium truncate mr-5">Outil d'analyse sémantique</h1>
            </div>
            <div class="flex justify-center">
                <h2>Etudiez les mots-clés de votre site, de vos concurants ou du web en général ...</h2>
            </div>
            <div id="home-analyse-form" class="p-5" data-user="@auth{{ Crypt::encrypt((string)Auth::user()) }}@endauth" data-route="{{route('v1.semantics.store')}}" data-routeAnalyse="{{route('accueil')}}/analyse/page/">
                <input id="url" type="text" class="form-control form-control-rounded" placeholder="Url à analyser ... ">
                <div class="flex justify-center">
                    <button id="btn-submit" class="btn btn-secondary mt-5"><i class="fas fa-search"></i><span class="ml-2">Démarrer l'analyse</span><i class="fas fa-cog fa-spin ml-4 hidden" id="home-analyse-loader"></i></button>
                    <a href="{{ route('analyse.launcher.page') }}" class="btn btn-secondary ml-5 mt-5"><i class="fas fa-cog"></i><span class="hidden md:block ml-2">Mode Avancé</span></a>
                </div>
            </div>
        </div>
    </div>
</div>
<!--  END: Search Analyse  -->
