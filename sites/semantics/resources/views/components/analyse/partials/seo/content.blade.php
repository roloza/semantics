<input class="absolute opacity-0" id="tab-single-content" type="radio" name="tabs2">
<label class="block p-5 leading-normal cursor-pointer font-semibold" for="tab-single-content">Texte brut extrait</label>
<div class="tab-content overflow-hidden border-l-2 leading-normal">
    <div class="p-5">
        <div class="overflow-x-auto">
            @if (isset($audit->structure['text']))
                <h3 class="block font-medium mt-3 mb-3">Taille du texte : {{ $audit->structure['text']['contentSize'] }}</h3>
               <quote>{{ $audit->structure['text']['content'] }}</quote>
            @endif
        </div>
    </div>
</div>
