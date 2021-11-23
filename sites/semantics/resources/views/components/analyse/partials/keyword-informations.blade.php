{{-- BEGIN Informations générales --}}
<div class="col-span-12 lg:col-span-8 xl:col-span-6">
    <div class="report-box-2 intro-y">
        <div class="box sm:flex">
            <div class="px-8 py-12 flex flex-col justify-center flex-1">
                <div class="relative text-3xl font-bold mb-12">
                    {{ ucfirst($keyword->forme) }}
                </div>
                <div class="text-theme-12 text-5xl">
                    <i class="fas fa-hashtag"></i>
                </div>
                <div class="relative text-3xl font-bold mt-12 pl-4">
                    {{ $keyword->freq }}
                </div>

                <div class="mt-4 text-gray-600 dark:text-gray-600">Nombre d'occurences du mot-clé dans le corpus</div>
            </div>
            <div class="px-8 py-12 flex flex-col justify-center flex-1 border-t sm:border-t-0 sm:border-l border-gray-300 dark:border-dark-5 border-dashed">
                <div class="text-gray-600 dark:text-gray-600 text-xs">Forme lemmatisée</div>
                <div class="mt-1.5 flex items-center">
                    <div class="text-base">{{ ucfirst($keyword->lemme) }}</div>

                </div>
                <div class="text-gray-600 dark:text-gray-600 text-xs mt-5">Catégorie grammaticale</div>
                <div class="mt-1.5 flex items-center">
                    <div class="text-base">{{ $keyword->category_name }}</div>
                </div>
                <div class="text-gray-600 dark:text-gray-600 text-xs mt-5">Nombre de documents</div>
                <div class="mt-1.5 flex items-center">
                    <div class="text-base">{{ $keyword->nb_doc }}</div>
                </div>
                <div class="text-gray-600 dark:text-gray-600 text-xs mt-5">Nombre d'including</div>
                <div class="mt-1.5 flex items-center">
                    <div class="text-base">{{ $keyword->nincl }}</div>
                </div>
                <div class="text-gray-600 dark:text-gray-600 text-xs mt-5">Longueur de l'expression</div>
                <div class="mt-1.5 flex items-center">
                    <div class="text-base">{{ $keyword->longueur }}</div>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- END Informations générales --}}
