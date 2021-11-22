<div class="col-span-12">
    <div class="intro-y box p-5 mt-5">
        <div class="intro-y flex items-center h-10">
            <div class="relative text-gray-700 dark:text-gray-300">
                <input type="text" class="form-control py-3 px-4 w-full lg:w-64 box pr-10 placeholder-theme-13" placeholder="Rerchercher un mot-clé..." wire:model.debounce.0ms="search">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search w-4 h-4 absolute my-auto inset-y-0 mr-3 right-0"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
            </div>
        </div>
    </div>
    <div class="grid grid-cols-12 gap-5 mt-5">
        @foreach($suggestKeywords as $suggestKeyword)
        <a href="{{ route('analyse.show.suggestions', ['type' => $job->type->slug, 'uuid' => $job->uuid, 'keyword' => $suggestKeyword->forme]) }}" class="col-span-12 sm:col-span-4 xxl:col-span-3 box p-5 cursor-pointer zoom-in">
            <div class="font-medium text-base">{{ $suggestKeyword->forme }}</div>
        </a>
        @endforeach
    </div>

</div>
