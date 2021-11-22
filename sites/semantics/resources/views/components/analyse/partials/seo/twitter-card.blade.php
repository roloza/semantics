<input class="absolute opacity-0" id="tab-single-twitter-card" type="radio" name="tabs2">
<label class="block p-5 leading-normal cursor-pointer font-semibold" for="tab-single-twitter-card">Détail des balises Twitter-card</label>
<div class="tab-content overflow-hidden border-l-2 leading-normal">
    <div class="p-5">
        <div class="overflow-x-auto">
            <table class="table">
                <thead>
                    <tr>
                        <th class="border-b-2 dark:border-dark-5 whitespace-nowrap">Balise</th>
                        <th class="border-b-2 dark:border-dark-5 whitespace-nowrap">Contenu</th>
                    </tr>
                </thead>
                <tbody>

                    <?php $cpt = 0 ?>
                    @foreach ($audit->twitterCard as $name => $value)
                        <tr @if($cpt % 2 === 0)class="bg-gray-200 dark:bg-dark-1" @endif>
                            <td class="border-b dark:border-dark-5">{{ $name}}</td>
                            <td class="border-b dark:border-dark-5">{{ $value }}</td>
                        </tr>
                        <?php $cpt++ ?>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
