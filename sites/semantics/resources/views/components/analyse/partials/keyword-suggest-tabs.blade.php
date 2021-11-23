{{-- Expressions suggests --}}
<div class="col-span-12 lg:col-span-8 xl:col-span-6 mt-5">
    <div class="report-box-2 xl:min-h-0 intro-x">
        <div class="max-h-full xl:overflow-y-auto box">

            <div class="bg-white dark:bg-dark-3 xl:sticky top-0 px-5 pt-5 pb-6">
                <div class="intro-y block sm:flex items-center h-10">
                    <h2 class="text-lg font-medium truncate mr-5">Expressions suggérées</h2>
                </div>
                <div x-data="{active: 'includings'}">
                    <div class="boxed-tabs nav nav-tabs justify-center border border-gray-400 border-dashed text-gray-600 dark:border-gray-700 dark:bg-dark-3 dark:text-gray-500 rounded-md p-1 mt-5 mx-auto">
                        <a class="btn flex-1 border-0 shadow-none py-1 px-2" x-on:click.prevent="active = 'includings'" x-bind:class="{'active': active === 'includings'}">{{ ucfirst($keyword->lemme) }}</a>
                        @foreach($keywordsIncludeds as $kw => $includeds)
                            <?php $name = "included-" . \Illuminate\Support\Str::slug($kw); ?>
                            <a class="btn flex-1 border-0 shadow-none py-1 px-2" x-on:click.prevent="active='{{$name}}'" x-bind:class="{'active': active === '{{$name}}'}">{{ ucfirst($kw) }}</a>
                        @endforeach
                    </div>
                    <div class="tab-content px-5 pb-5 mt-5">
                        <div class="tab-pane" x-show="active === 'includings'"  x-bind:class="{'active': active === 'includings'}">
                            @foreach($includings as $including)
                                <a href="{{ route('analyse.show.keyword', ['type' => $job->type->slug, 'uuid' => $job->uuid, 'num' => $including->num]) }}" style="line-height: 2rem" class="py-1 px-2 mb-2 rounded-full text-xs bg-gray-200 dark:bg-dark-5 text-gray-600 dark:text-gray-300 ml-auto truncate">{{ ucfirst($including->forme) }}</a>
                            @endforeach
                        </div>
                        @foreach($keywordsIncludeds as $kw => $includeds)
                            <?php $name = "included-" . \Illuminate\Support\Str::slug($kw); ?>
                            <div class="tab-pane" x-show="active === '{{ $name }}'"  x-bind:class="{'active': active === '{{ $name }}'}" x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0 transform scale-90"
                            x-transition:enter-end="opacity-100 transform scale-100">
                                @foreach($includeds as $included)
                                <a href="{{ route('analyse.show.keyword', ['type' => $job->type->slug, 'uuid' => $job->uuid, 'num' => $included->num]) }}" style="line-height: 2rem" class="py-1 px-2 mb-2 rounded-full text-xs bg-gray-200 dark:bg-dark-5 text-gray-600 dark:text-gray-300 ml-auto truncate">{{ ucfirst($included->forme) }}</a>
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- END Expressions suggests --}}
