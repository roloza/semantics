<input class="absolute opacity-0" id="tab-single-outline" type="radio" name="tabs2">
<label class="block p-5 leading-normal cursor-pointer font-semibold" for="tab-single-outline">Hiérarchie des titres de la page</label>
<div class="tab-content overflow-hidden border-l-2 leading-normal">
    <div class="p-5">
        <div class="overflow-x-auto">
            <table class="table table-report sm:mt-2">
                <thead>
                <tr>
                    <th class="whitespace-nowrap">Tag HTML</th>
                    <th class="whitespace-nowrap">Contenu</th>
                </tr>
                </thead>
                <tbody>
                @if (isset($audit->structure['outline']))
                    @foreach ($audit->structure['outline'] as $outline)
                    <tr class="intro-x">
                        <td class="outline-{{$outline['tag']}}"><strong>{{ $outline['tag']}}</strong></td>
                        <td>{{ $outline['content']}}</td>
                    </tr>
                    @endforeach
                @endif

                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    .outline-h1 {text-indent: 0px}
    .outline-h2 {text-indent: 10px}
    .outline-h3 {text-indent: 20px}
    .outline-h4 {text-indent: 30px}
    .outline-h5 {text-indent: 40px}
    .outline-h6 {text-indent: 50px}
    .table-report:not(.table-report--bordered):not(.table-report--tabulator) .intro-x {
        border-bottom: 1px solid #DDD;
    }
</style>
