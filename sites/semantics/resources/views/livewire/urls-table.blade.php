<div>
    <span class="flex flex-col sm:flex-row sm:items-end xl:items-start">
        <div class="xl:flex sm:mr-auto">
            <div class="sm:flex items-center sm:mr-4 mt-2 xl:mt-0">
                <input id="filter-value" class="form-control sm:w-40 xxl:w-full mt-2 sm:mt-0" type="text" placeholder="Recherche..." wire:model.debounce.500ms="search">
                <button id="filter-clear" class="btn btn-secondary w-full sm:w-16 mt-2 sm:mt-0 sm:ml-1" wire:click="resetFilters()">Reset</button>
            </div>
        </div>
    </span>
    <div class="mt-5 overflow-x-auto">
        <table class="table border ">
            <thead>
            <tr>
                <x-table-header :direction="$orderDirection" :field="$orderField" name="url" >Url</x-table-header>
                <th class="border border-b-2 dark:border-dark-5" style="width:150px;">Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($urls as $k => $url)
            <tr {!! $k % 2 !== 0 ? 'class="bg-gray-200 dark:bg-dark-1"' : '' !!}>
                <td class="border-b dark:border-dark-5">
                    <div>
                        <div class="font-medium ">{{ $url->url }}</div>
                        <div class="text-gray-600 text-xs ">{{ $url->title }}</div>
                    </div>
                </td>
                <td class="border-b dark:border-dark-5">
                    <a href="{{ route('analyse.show.url', ['type' => $job->type->slug, 'uuid' => $job->uuid, 'doc_id' => $url->doc_id]) }}" class="btn btn-sm btn-dark w-32 mr-2 mb-2">Détails</a>
                </td>

            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-4">
        {{ $urls->links() }}
    </div>

</div>
