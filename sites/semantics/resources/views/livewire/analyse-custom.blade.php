<div>
    <!--  BEGIN: tab analyse page  -->
    <div id="analyse-page" class="tab-pane" role="tabpanel" aria-labelledby="analyse-page-tab">
        <div class="box p-5 mt-5">
            <h2 class="font-medium text-base mr-auto">Analyser la sémantique personnalisée (import CSV)</h2>


            <div id="horizontal-form" class="p-5">
                <form wire:submit.prevent="submit">
                    <div class="preview">
                        <div class="form-inline">
                            <label for="horizontal-form-1" class="form-label sm:w-20">Fichier</label>
                            <input id="horizontal-form-1" type="file" class="form-control" name="file" wire:model.lazy="file">
                        </div>
                        @error('file') <div class="sm:ml-20 sm:pl-5 text-theme-6 mt-2">{{ $message }}</div> @enderror
                        <div class="sm:ml-20 sm:pl-5 mt-2">
                            Pour être analysé correctement, votre fichier doit posséder les colonnes suivantes : 
                            <ul class="list-disc ml-8">
                                <li><strong>id</strong> : Clé d'identification unique (chaine de caractères)</li>
                                <li><strong>title</strong> : Titre du contenu (chaine de caractères)</li>
                                <li><strong>content</strong> : Contenu texte à analyser (chaine de caractères)</li>
                            </ul>
                        </div>
           
                        <div class="form-inline mt-5">
                            <label for="separator" class="form-label sm:w-20">Séparateur</label>
                            <select id="separator" name="separator" class="form-select" wire:model.lazy="separator">
                                <option value=";" wire:key=";">;</option>
                                <option value="," wire:key=",">,</option>
                                <option value="|" wire:key="|">|</option>
                                <option value="\t" wire:key="\t">\t</option>
                            </select>
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
    @if($active > 0)
        @livewire('progess-task', ['uuid' => $uuid])
    @endif

</div>
