<!--  BEGIN: Tools List  -->

<div class="col-span-12">
    <div class="intro-y block sm:flex items-center h-10">
        <h2 class="text-lg font-medium truncate mr-5">Que voulez-vous faire ?</h2>
    </div>

    <div class="intro-y box flex flex-col lg:flex-row mt-5">

        <div class="intro-y flex-1 px-5 py-16">
            <i class="far fa-file block text-4xl text-theme-1 dark:text-theme-10 mx-auto"></i>
            <div class="text-xl font-medium text-center mt-10">Analyser une page</div>
            <div class="text-gray-700 dark:text-gray-600 text-center mt-5">
                1 Url <span class="mx-1">•</span> 1 Site
            </div>
            <div class="text-gray-600 dark:text-gray-400 px-10 text-center mx-auto mt-2">
                Analyse sémantique d'une unique page web.
            </div>

            <div class="flex justify-center">
                <a href="{{ route('analyse.launcher.page') }}" class="btn btn-rounded-primary py-3 px-4 block x-auto mt-8">C'est parti !</a>
            </div>
        </div>

        <div
            class="intro-y border-b border-t lg:border-b-0 lg:border-t-0 flex-1 p-5 lg:border-l lg:border-r border-gray-200 dark:border-dark-5 py-16">
            <i class="far fa-copy block text-4xl text-theme-1 dark:text-theme-10 mx-auto"></i>
            <div class="text-xl font-medium text-center mt-10">Analyser un site complet</div>
            <div class="text-gray-700 dark:text-gray-600 text-center mt-5">
                100+ Urls <span class="mx-1">•</span> 1 Site
            </div>
            <div class="text-gray-600 dark:text-gray-400 px-10 text-center mx-auto mt-2">
                Analyse sémantique d'un site web au complet.
            </div>

            <div class="flex justify-center">
                <a href="{{ route('analyse.launcher.site') }}" class="btn btn-rounded-primary py-3 px-4 block x-auto mt-8">C'est parti !</a>
            </div>
        </div>

        <div
            class="intro-y flex-1 p-5  py-16">
            <i class="fab fa-searchengin block text-4xl text-theme-1 dark:text-theme-10 mx-auto"></i>
            <div class="text-xl font-medium text-center mt-10">Analyser le web</div>
            <div class="text-gray-700 dark:text-gray-600 text-center mt-5"> 100+ Urls <span class="mx-1">•</span>
                multi-sites <span class="mx-1">•</span> 1 thématique
            </div>
            <div class="text-gray-600 dark:text-gray-400 px-10 text-center mx-auto mt-2">
                Identifiez les marqueurs sémantiques d'une thématique.
            </div>

            <div class="flex justify-center">
                <a href="{{ route('analyse.launcher.web') }}" class="btn btn-rounded-primary py-3 px-4 block x-auto mt-8">C'est parti !</a>
            </div>
        </div>

    </div>
</div>

<!--  END: Tools List  -->
