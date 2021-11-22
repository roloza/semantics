<input class="absolute opacity-0" id="tab-single-links" type="radio" name="tabs2">
<label class="block p-5 leading-normal cursor-pointer font-semibold" for="tab-single-links">Détail des liens</label>
<div class="tab-content overflow-hidden border-l-2 leading-normal">
    <div class="p-5">
        <div class="overflow-x-auto">
            <table class="table">
                <thead>
                    <tr>
                        <th class="border-b-2 dark:border-dark-5 whitespace-nowrap">Lien</th>
                        <th class="border-b-2 dark:border-dark-5 whitespace-nowrap">Nb</th>

                        <th class="border-b-2 dark:border-dark-5 whitespace-nowrap">Ancre</th>
                        <th class="border-b-2 dark:border-dark-5 whitespace-nowrap">Title</th>
                        <th class="border-b-2 dark:border-dark-5 whitespace-nowrap">Target</th>
                        <th class="border-b-2 dark:border-dark-5 whitespace-nowrap">Rel</th>
                    </tr>
                </thead>
                <tbody>

                    <?php $cpt = 0 ?>
                    @foreach ($audit->links as $link)
                        <tr @if($cpt % 2 === 0)class="bg-gray-200 dark:bg-dark-1" @endif>
                            <td class="border-b dark:border-dark-5">{{ $link['url'] }}</td>
                            <td class="border-b dark:border-dark-5">{{ $link['count'] }}</td>
                            <td class="border-b dark:border-dark-5">{{ $link['text'] }}</td>
                            <td class="border-b dark:border-dark-5">{{ $link['title'] }}</td>
                            <td class="border-b dark:border-dark-5">{{ $link['target'] }}</td>
                            <td class="border-b dark:border-dark-5">{{ $link['rel'] }}</td>
                        </tr>
                        <?php $cpt++ ?>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
