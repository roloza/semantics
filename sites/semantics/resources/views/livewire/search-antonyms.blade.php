<div class="intro-y col-span-12 lg:col-span-8">
    <div class="intro-y box p-6">
        <div class="col-span-12">
            <h2 class="font-medium text-base mr-auto">
                Identifiez d'autres façon d'écrire sur une thématique
            </h2>
        </div>
        <div class="col-span-12 relative text-gray-700 dark:text-gray-300 w-3/4 mt-6">
            <input type="text" class="form-control py-3 px-4 w-full box pr-10 placeholder-theme-13" placeholder="Rerchercher un antonyme..." wire:model.debounce.200ms="search">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search w-4 h-4 absolute my-auto inset-y-0 mr-3 right-0"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
        </div>
    </div>

    <div class="grid grid-cols-12 gap-5 mt-6">
        @forelse($results as $keyword)
            <div class="col-span-12 box p-3 mt-8 bg-theme-1 text-white">
                <div class="intro-y flex flex-col sm:flex-row items-center">
                    <h2 class="text-lg font-medium mr-auto">{{ $keyword['racine'] }}</h2>
                </div>
            </div>
            @foreach($keyword['words'] as $word)
            <span class="col-span-6 md:col-span-4 xl:col-span-3 box p-5 zoom-in" wire:click="searchAntonyms('{{$word}}')">
                <div class="font-medium text-base">{{ $word }}</div>
            </span>
            @endforeach
        @empty
            @if ($search && $search != '')
            <div class="col-span-4 box p-5">
                <p>
                    Aucun antonyme trouvé pour <strong>{{$search}}</strong>.<br>
                    Essayer de rechercher un autre mot-clé
                </p>

            </div>
            @endif
        @endforelse
    </div>

</div>
