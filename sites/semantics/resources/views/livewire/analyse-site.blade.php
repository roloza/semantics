<div>
    <!--  BEGIN: tab analyse page  -->
    <div id="analyse-site" class="tab-pane" role="tabpanel" aria-labelledby="analyse-site-tab">
        <div class="box p-5 mt-5">
            <h2 class="font-medium text-base mr-auto">Analyser la sémantique d'un site</h2>


            <div id="horizontal-form" class="p-5">
                <form wire:submit.prevent="submit">
                    <div class="preview">
                        <div class="form-inline">
                            <label for="horizontal-form-1" class="form-label sm:w-20">Lien</label>
                            <input id="horizontal-form-1" type="text" class="form-control" name="url" placeholder="https://..." wire:model.lazy="url">
                        </div>
                        @error('url') <div class="sm:ml-20 sm:pl-5 text-theme-6 mt-2">{{ $message }}</div> @enderror

                        <div class="form-inline mt-5">
                            <label for="total_crawl_limit" class="form-label sm:w-20">Maximum</label>
                            <select id="total_crawl_limit" name="total_crawl_limit" class="form-select" wire:model.lazy="total_crawl_limit">
                                @foreach($totalCrawlLimitValues as $totalCrawlLimitValue)
                                    <option value="{{$totalCrawlLimitValue}}" wire:key="{{$totalCrawlLimitValue}}">{{$totalCrawlLimitValue}} pages</option>
                                @endforeach
                            </select>
                        </div>
                        @error('total_crawl_limit') <div class="sm:ml-20 sm:pl-5 text-theme-6 mt-2">{{ $message }}</div> @enderror
                        <div class="form-inline mt-5">
                            <div class="flex flex-col sm:flex-row mt-2">
                                <label for="horizontal-form-1" class="form-label sm:w-20">Type</label>
                                <div class="form-check mr-2">
                                     <input id="radio-switch-4" class="form-check-input" type="radio" name="type_content" value="all"  wire:model.lazy="type_content">
                                    <label class="form-check-label" for="radio-switch-4">
                                        Tout le contenu
                                        <a href="javascript:;" data-theme="light" class="tooltip" title="L'ensemble du contenu texte présent dans la page sera pris en compte pour l'analyse sémantique."><i data-feather="help-circle" class="w-4 h-4 mr-2"></i></a>
                                    </label>
                                </div>



                                <div class="form-check mr-2 mt-2 sm:mt-0">
                                    <input id="radio-switch-5" class="form-check-input" type="radio" name="type_content" value="usefull"  wire:model.lazy="type_content">
                                    <label class="form-check-label" for="radio-switch-5">
                                        Contenu utile uniquement
                                        <a href="javascript:;" data-theme="light" class="tooltip" title="Seules certaines balises HTML importantes seront utilisées pour l'analyse sémantique. Permet une analyse plus rapide"><i data-feather="help-circle" class="w-4 h-4 mr-2"></i></a>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="sm:ml-20 sm:pl-5 mt-5">
                            <button class="btn {{ $state['class'] }} mr-1 mb-2" @if($active > 0)disabled @endif>
                                {{ $state['label'] }}
                                @if($active === 1)
                                <svg width="25" viewBox="-2 -2 42 42" xmlns="http://www.w3.org/2000/svg" stroke="white" class="w-4 h-4 ml-2">
                                    <g fill="none" fill-rule="evenodd">
                                        <g transform="translate(1 1)" stroke-width="4">
                                            <circle stroke-opacity=".5" cx="18" cy="18" r="18"></circle>
                                            <path d="M36 18c0-9.94-8.06-18-18-18">
                                                <animateTransform attributeName="transform" type="rotate" from="0 18 18" to="360 18 18" dur="1s" repeatCount="indefinite"></animateTransform>
                                            </path>
                                        </g>
                                    </g>
                                </svg>
                                @endif
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--  END: tab analyse page -->
    @if($active)
        @livewire('progess-task', ['uuid' => $uuid])
    @endif

</div>
