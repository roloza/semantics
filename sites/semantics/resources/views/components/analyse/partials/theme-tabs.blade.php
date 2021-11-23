 {{-- BEGIN Synonymes --}}
 <div class="col-span-12 lg:col-span-8 xl:col-span-6">
    @if(count($keywordsSuggest) > 0 || count($synonymsByKeywords) > 0 | count($antonymesByKeywords) > 0)
     <div class="report-box-2 xl:min-h-0 intro-x">
         <div class="max-h-full xl:overflow-y-auto box ">
             <div class="bg-white dark:bg-dark-3 xl:sticky top-0 px-5 pt-5 pb-6">

                 <div class="boxed-tabs nav nav-tabs justify-center border border-gray-400 border-dashed text-gray-600 dark:border-gray-700 dark:bg-dark-3 dark:text-gray-500 rounded-md p-1 mt-5 mx-auto" role="tablist">
                     @if(count($keywordsSuggest) > 0)
                         <a data-toggle="tab" data-target="#suggestions" href="javascript:;" class="btn flex-1 border-0 shadow-none py-1 px-2 active" id="suggestions-tab" role="tab" aria-controls="suggestions" aria-selected="true">Sur le même thême</a>
                     @endif
                     <a data-toggle="tab" data-target="#synonymes" href="javascript:;" class="btn flex-1 border-0 shadow-none py-1 px-2" id="synonymes-tab" role="tab" aria-controls="synonymes" aria-selected="true">Synonymes</a>
                     <a data-toggle="tab" data-target="#antonymes" href="javascript:;" class="btn flex-1 border-0 shadow-none py-1 px-2" id="antonymes-tab" role="tab" aria-selected="false">Antonymes</a>
                 </div>
             </div>
             <div class="tab-content px-5 pb-5">
                 @if(count($keywordsSuggest) > 0)
                     <div class="tab-pane active" id="suggestions" role="tabpanel" aria-labelledby="suggestions-tab">
                         <div class="mt-2">
                             @foreach($keywordsSuggest as $keywordSuggest)
                                 <a href="{{ route('analyse.show.keyword', ['type' => $job->type->slug, 'uuid' => $job->uuid, 'num' => $keywordSuggest['num']]) }}" style="line-height: 2rem" class="py-1 px-2 mb-2 rounded-full text-xs bg-gray-200 dark:bg-dark-5 text-gray-600 dark:text-gray-300 ml-auto truncate">{{ ucfirst($keywordSuggest['forme']) }}</a>
                             @endforeach
                         </div>
                     </div>
                 @endif
                 <div class="tab-pane" id="synonymes" role="tabpanel" aria-labelledby="synonymes-tab">
                     @foreach($synonymsByKeywords as $kw => $synonyms)
                         <h3 class="text-lg font-medium truncate mr-3 mt-5">{{ ucfirst($kw) }}</h3>
                         <div class="mt-2">
                             @foreach($synonyms as $synonym)
                                 @if ($synonym instanceof \App\Models\SyntexRtListe)
                                     <a href="{{ route('analyse.show.keyword', ['type' => $job->type->slug, 'uuid' => $job->uuid, 'num' => $synonym->num]) }}" style="line-height: 2rem" class="py-1 px-2 mb-2 rounded-full text-xs bg-gray-200 dark:bg-dark-5 text-gray-600 dark:text-gray-300 ml-auto truncate">{{ ucfirst($synonym->lemme) }}</a>
                                 @else
                                     <span style="line-height: 2rem" class="py-1 px-2 mb-2 rounded-full text-xs bg-gray-200 dark:bg-dark-5 text-gray-600 dark:text-gray-300 ml-auto truncate">{{ ucfirst($synonym) }}</span>
                                 @endif
                             @endforeach
                         </div>
                     @endforeach
                 </div>

                 <div class="tab-pane" id="antonymes" role="tabpanel" aria-labelledby="antonymes-tab">
                     @foreach($antonymesByKeywords as $kw => $antonyms)
                         <h3 class="text-lg font-medium truncate mr-3 mt-5">{{ ucfirst($kw) }}</h3>
                         <div class="mt-2">
                             @foreach($antonyms as $antonym)
                                 @if ($antonym instanceof \App\Models\SyntexRtListe)
                                     <a href="{{ route('analyse.show.keyword', ['type' => $job->type->slug, 'uuid' => $job->uuid, 'num' => $antonym->num]) }}" style="line-height: 2rem" class="py-1 px-2 mb-2 rounded-full text-xs bg-gray-200 dark:bg-dark-5 text-gray-600 dark:text-gray-300 ml-auto truncate">{{ ucfirst($antonym->lemme) }}</a>
                                 @else
                                     <span style="line-height: 2rem" class="py-1 px-2 mb-2 rounded-full text-xs bg-gray-200 dark:bg-dark-5 text-gray-600 dark:text-gray-300 ml-auto truncate">{{ ucfirst($antonym) }}</span>
                                 @endif
                             @endforeach
                         </div>
                     @endforeach
                 </div>
             </div>
         </div>
     </div>
 </div>
@endif
{{-- END Synonymes --}}
