<div>
    <div class="form-inline">
        <label for="horizontal-form-1" class="form-label sm:w-20">Mot-clé</label>
        <input id="filter-value" class="form-control sm:w-40 xxl:w-full mt-2 sm:mt-0 " type="text" placeholder="Recherche..." wire:model.debounce.500ms="search">
    </div>
    <div class="form-inline mt-5">
        <label for="horizontal-form-2" class="form-label sm:w-20">Catégorie grammaticale</label>
        <select id="category_name" class="form-select" wire:model="category_name">
            <option value="">Tout</option>
            @foreach($categoriesGram as $categoryGram)
                <option value="{{ $categoryGram->name }}">{{ $categoryGram->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-inline mt-5">
        <label for="horizontal-form-2" class="form-label sm:w-20">Longueur</label>
        @for($i = 1; $i <= 5; $i++)
            <div class="form-check mr-2">
                <input id="checkbox-switch-{{ $i }}" class="form-check-input" type="checkbox"  wire:model.debounce.500ms="longueur.{{ $i }}" >
                <label class="form-check-label" for="checkbox-switch-{{ $i }}">{{ $i }}</label>
            </div>
        @endfor
    </div>
    <div class="sm:ml-20 sm:pl-5 mt-5 flex">
        <button id="filter-clear" class="btn btn-secondary w-full sm:w-16 mt-2 sm:mt-0 sm:ml-1" wire:click="resetFilters()">Reset</button>
        <div class="flex items-center sm:ml-auto mt-3 sm:mt-0">
            <a href="{{ route('export.audit-list', ['uuid' => $job->uuid]) }}" class="ml-3 btn btn-outline-dark flex items-center text-gray-700 dark:text-gray-300"><i class="fas fa-file-export hidden sm:block w-4 h-4 mr-2"></i>Export</a>
        </div>
    </div>

    <div class="mt-5 overflow-x-auto">
        <table class="table border ">
            <thead>
            <tr>
                <x-table-header :direction="$orderDirection" :field="$orderField" name="lemme" style="min-width:200px">Mot-clé</x-table-header>
                <x-table-header :direction="$orderDirection" :field="$orderField" name="longueur" style="width:100px">Longueur</x-table-header>
                <x-table-header :direction="$orderDirection" :field="$orderField" name="cat" style="width:100px">Catégorie</x-table-header>
                <x-table-header :direction="$orderDirection" :field="$orderField" name="score" style="width:100px">Score</x-table-header>
                <x-table-header :direction="$orderDirection" :field="$orderField" name="freq_num" style="width:100px">Occurences</x-table-header>
                <th class="border border-b-2 dark:border-dark-5 whitespace-nowrap" style="width:75px;">Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($keywords as $k => $keyword)
                <tr {!! $k % 2 !== 0 ? 'class="bg-gray-200 dark:bg-dark-1"' : '' !!}>
                    <td class="border-b dark:border-dark-5">{{ $keyword->lemme }}</td>
                    <td class="border-b dark:border-dark-5">{{ $keyword->longueur }}</td>
                    <td class="border-b dark:border-dark-5"><span wire:click="updateCategory('{{ $keyword->category_name }}')" class="py-1 px-2 rounded text-xs bg-gray-300 dark:bg-dark-5 text-gray-600 dark:text-gray-300 cursor-pointer ml-auto truncate">{{ $keyword->category_name }}</span></td>
                    <td class="border-b dark:border-dark-5">
                        <div class="progress h-3 rounded mt-3">
                            <div class="progress-bar bg-theme-1 rounded tooltip" title="{{ $keyword->score }}" role="progressbar" aria-valuenow="{{ $keyword->score}}" aria-valuemin="0" aria-valuemax="100" style="width: {{ max(min($keyword->score / 50, 100), 5)}}%"></div>
                        </div>
                    </td>
                    <td class="border-b dark:border-dark-5">{{ $keyword->freq_num }}</td>
                    <td class="border-b dark:border-dark-5">
                        <a href="{{ route('analyse.show.keyword', ['type' => $job->type->slug, 'uuid' => $job->uuid, 'num' => $keyword->num]) }}" class="btn btn-sm btn-dark w-32 mr-2 mb-2">Détails</a>
                    </td>

                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-4">
        {{ $keywords->links() }}
    </div>

</div>
