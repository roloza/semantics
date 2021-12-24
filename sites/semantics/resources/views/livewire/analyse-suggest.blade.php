<div>
    <!--  BEGIN: tab analyse page  -->
    <div id="analyse-site" class="tab-pane" role="tabpanel" aria-labelledby="analyse-site-tab">
        <div class="box p-5 mt-5">
            <h2 class="font-medium text-base mr-auto">Identifier la façon dont les internautes parlent d'un sujet</h2>
            <div id="horizontal-form" class="p-5">
                <form wire:submit.prevent="submit">
                    <div class="preview">
                        <div class="form-inline">
                            <label for="horizontal-form-1" class="form-label sm:w-20">Thématique</label>
                            <input id="horizontal-form-1" type="text" class="form-control" name="keyword" placeholder="Thématique à rechercher (un mot-clé ou une expression)" wire:model.lazy="keyword">
                        </div>
                        @error('keyword') <div class="sm:ml-20 sm:pl-5 text-theme-6 mt-2">{{ $message }}</div> @enderror


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
                                <a href="{{ route('analyse.suggest') }}" class="btn btn-primary mr-1 mb-2">Nouveau <i class="fas fa-plus ml-2"></i></a>
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
