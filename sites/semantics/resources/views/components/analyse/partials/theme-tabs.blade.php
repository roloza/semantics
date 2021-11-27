 {{-- BEGIN Synonymes --}}
<div class="col-span-12 lg:col-span-8 xl:col-span-6 mt-5">
    <div class="report-box-2 xl:min-h-0 intro-x">
        <div class="max-h-full xl:overflow-y-auto box">

            <div class="bg-white dark:bg-dark-3 xl:sticky top-0 px-5 pt-5 pb-6">
                <div class="intro-y block sm:flex items-center h-10">
                    <h2 class="text-lg font-medium truncate mr-5">Sur le même thême</h2>
                </div>
                <div x-data="{active: 'theme'}">
                    <div class="boxed-tabs nav nav-tabs justify-center border border-gray-400 border-dashed text-gray-600 dark:border-gray-700 dark:bg-dark-3 dark:text-gray-500 rounded-md p-1 mt-5 mx-auto">
                        <a class="btn flex-1 border-0 shadow-none py-1 px-2" x-on:click.prevent="active = 'theme'" x-bind:class="{'active': active === 'theme'}">Sur le même thême</a>
                        <a class="btn flex-1 border-0 shadow-none py-1 px-2" x-on:click.prevent="active = 'synonyme'" x-bind:class="{'active': active === 'synonyme'}">Synonymes</a>
                        <a class="btn flex-1 border-0 shadow-none py-1 px-2" x-on:click.prevent="active = 'antonyme'" x-bind:class="{'active': active === 'antonyme'}">Antonymes</a>
                    </div>

                    <div class="tab-content px-5 pb-5 mt-5">
                        {{-- tab Sur le même theme --}}
                        <div class="tab-pane" x-show="active === 'theme'"  x-bind:class="{'active': active === 'theme'}">
                            @foreach($keywordsSuggest as $kw => $keywordSuggest)
                                <a href="" style="line-height: 2rem" class="py-1 px-2 mb-2 rounded-full text-xs bg-gray-200 dark:bg-dark-5 text-gray-600 dark:text-gray-300 ml-auto truncate">{{ ucfirst($keywordSuggest['forme']) }}</a>
                            @endforeach
                        </div>

                        {{-- tab Synonymes --}}
                        <div class="tab-pane" x-show="active === 'synonyme'"  x-bind:class="{'active': active === 'synonyme'}">
                            @foreach($synonymsByKeywords as $synonymes)
                                @if (isset($synonymes['racine']))
                                <h3 class="text-lg font-medium truncate mr-3">{{ ucfirst($synonymes['racine']) }}</h3>
                                <div class="mt-2">
                                    @foreach($synonymes['words'] as $word)
                                    <a href="" style="line-height: 2rem" class="py-1 px-2 mb-2 rounded-full text-xs bg-gray-200 dark:bg-dark-5 text-gray-600 dark:text-gray-300 ml-auto truncate">{{ ucfirst($word) }}</a>
                                    @endforeach
                                </div>
                                @endif
                            @endforeach
                        </div>
                        {{-- END tab Synonymes --}}

                        {{-- tab Antonymes --}}
                        <div class="tab-pane" x-show="active === 'antonyme'"  x-bind:class="{'active': active === 'antonyme'}">
                            @foreach($antonymesByKeywords as $antonymes)
                                @if (isset($antonymes['racine']))
                                <h3 class="text-lg font-medium truncate mr-3">{{ ucfirst($antonymes['racine']) }}</h3>
                                <div class="mt-2">
                                    @foreach($antonymes['words'] as $word)
                                    <a href="" style="line-height: 2rem" class="py-1 px-2 mb-2 rounded-full text-xs bg-gray-200 dark:bg-dark-5 text-gray-600 dark:text-gray-300 ml-auto truncate">{{ ucfirst($word) }}</a>
                                    @endforeach
                                </div>
                                @endif
                            @endforeach
                        </div>
                        {{-- END tab Synonymes --}}

                    </div>

                    {{-- END tab Sur le même theme --}}
                </div>
            </div>
        </div>
    </div>
</div>
{{-- END Synonymes --}}

