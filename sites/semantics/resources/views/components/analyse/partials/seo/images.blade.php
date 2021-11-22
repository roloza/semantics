<input class="absolute opacity-0" id="tab-single-images" type="radio" name="tabs2">
<label class="block p-5 leading-normal cursor-pointer font-semibold" for="tab-single-images">Détail des images</label>
<div class="tab-content overflow-hidden border-l-2 leading-normal">
    <div class="p-5">
        <div class="overflow-x-auto">
            <table class="table">
                <thead>
                    <tr>
                        <th class="border-b-2 dark:border-dark-5 whitespace-nowrap">Lien</th>
                        <th class="border-b-2 dark:border-dark-5 whitespace-nowrap">Balise alt</th>
                        <th class="border-b-2 dark:border-dark-5 whitespace-nowrap">taille</th>
                    </tr>
                </thead>
                <tbody>

                    <?php $cpt = 0 ?>
                    @foreach ($audit->images as $image)
                        <tr @if($cpt % 2 === 0)class="bg-gray-200 dark:bg-dark-1" @endif>
                            <td class="border-b dark:border-dark-5">{{ $image['url'] }}</td>
                            <td class="border-b dark:border-dark-5">{{ $image['alt'] }}</td>
                            <td class="border-b dark:border-dark-5 whitespace-nowrap">
                                @if ( $image['width'] !== null && $image['height'] !== null)
                                    {{ $image['width'] }}x{{ $image['height'] }}
                                @else
                                {{ $image['width'] }}
                                {{ $image['height'] }}
                                @endif
                            </td>
                        </tr>
                        <?php $cpt++ ?>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
