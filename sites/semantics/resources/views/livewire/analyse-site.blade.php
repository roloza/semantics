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
                                @if($active === 2)
                                    <div class="fa-1x ml-2">
                                        <i class="fas fa-cog fa-spin"></i>
                                    </div>
                                @endif
                                @if($active === 4)
                                    <i class="fas fa-exclamation-triangle ml-2"></i>
                                @endif
                            </button>
                            @if($active >=3)
                                <a href="{{ route('analyse.launcher.page') }}" class="btn btn-primary mr-1 mb-2">Nouveau <i class="fas fa-plus ml-2"></i></a>
                            @endif

                        </div>
                    </div>
                </form>
                @if($label !== '')
                    <div class="alert alert-secondary-soft show flex items-center mb-2 mt-4" role="alert">
                        <i class="fas fa-exclamation-triangle w-6 h-6 mr-2"></i>
                        {{ $label }}
                    </div>
                @endif
            </div>
        </div>
    </div>
    <!--  END: tab analyse page -->
    @if($active)
        @livewire('progess-task', ['uuid' => $uuid])
    @endif

</div>
