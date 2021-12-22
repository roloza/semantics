<!--  BEGIN: Tools List  -->

<div class="col-span-12">
    <div class="intro-y block sm:flex items-center h-10">
        <h2 class="text-lg font-medium truncate mr-5">Essayez aussi nos autres outils</h2>
    </div>

    <div class="intro-y box flex flex-col lg:flex-row mt-5">

        <div class="intro-y flex-1 px-5 py-16">
            <i class="fas fa-hat-wizard block text-4xl text-theme-1 dark:text-theme-10 mx-auto"></i>
            <div class="text-xl font-medium text-center mt-10">Enrichissement sémantique</div>
            <div class="text-gray-700 dark:text-gray-600 text-center mt-5">
                1 thématique
            </div>
            <div class="text-gray-600 dark:text-gray-400 px-10 text-center mx-auto mt-2">
                Trouvez des idées d'expressions pour enrichir le champ sémantique de vos articles.
            </div>

            <div class="flex justify-center">
                <a href="{{ route('analyse.suggest') }}" class="btn btn-rounded-primary py-3 px-4 block x-auto mt-8">C'est parti !</a>
            </div>
        </div>

        <div class="intro-y border-b border-t lg:border-b-0 lg:border-t-0 flex-1 p-5 lg:border-l border-gray-200 dark:border-dark-5 py-16">
            <i class="far fa-file-excel block text-4xl text-theme-1 dark:text-theme-10 mx-auto"></i>
            <div class="text-xl font-medium text-center mt-10">Analyser mon contenu</div>
            <div class="text-gray-700 dark:text-gray-600 text-center mt-5">
                1 liste de contenus
            </div>
            <div class="text-gray-600 dark:text-gray-400 px-10 text-center mx-auto mt-2">
                C'est vous le pilote! Uploadez directement vos contenus à analyser.
            </div>

            <div class="flex justify-center">
                <a href="{{ route('analyse.launcher.custom') }}" class="btn btn-rounded-primary py-3 px-4 block x-auto mt-8">C'est parti !</a>
            </div>
        </div>

        <div class="intro-y border-b border-t lg:border-b-0 lg:border-t-0 flex-1 p-5 lg:border-l lg:border-r border-gray-200 dark:border-dark-5 py-16">
            <i class="fas fa-pen block text-4xl text-theme-1 dark:text-theme-10 mx-auto"></i>
            <div class="text-xl font-medium text-center mt-10">Trouver des Synonymes</div>
            <div class="text-gray-700 dark:text-gray-600 text-center mt-5">
                1 mot-clé
            </div>
            <div class="text-gray-600 dark:text-gray-400 px-10 text-center mx-auto mt-2">
                Identifier des synonymes afin d'élargir votre façon de traiter un sujet.
            </div>

            <div class="flex justify-center">
                <a href="{{ route('dictionnaire.synonyms') }}" class="btn btn-rounded-primary py-3 px-4 block x-auto mt-8">C'est parti !</a>
            </div>
        </div>

        <div class="intro-y flex-1 px-5 py-16">
            <i class="fas fa-pen-alt block text-4xl text-theme-1 dark:text-theme-10 mx-auto"></i>
            <div class="text-xl font-medium text-center mt-10">Trouver des Antonymes</div>
            <div class="text-gray-700 dark:text-gray-600 text-center mt-5">
                1 mot-clé
            </div>
            <div class="text-gray-600 dark:text-gray-400 px-10 text-center mx-auto mt-2">
                Identifier des antonymes afin d'élargir votre façon de traiter un sujet.
            </div>

            <div class="flex justify-center">
                <a href="{{ route('dictionnaire.antonyms') }}" class="btn btn-rounded-primary py-3 px-4 block x-auto mt-8">C'est parti !</a>
            </div>
        </div>

    </div>
</div>

<!--  END: Tools List  -->
