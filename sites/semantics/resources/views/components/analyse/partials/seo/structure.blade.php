<input class="absolute opacity-0" id="tab-single-structure" type="radio" name="tabs2" checked="checked">
<label class="block p-5 leading-normal cursor-pointer font-semibold" for="tab-single-structure">Analyse générale de la structure HTML</label>
<div class="tab-content overflow-hidden border-l-2 leading-normal">
    <div class="p-5">
        <div class="overflow-x-auto">
            <table class="table">
                <thead>
                    <tr>
                        <th class="border-b-2 dark:border-dark-5 whitespace-nowrap">Critère analysé</th>
                        <th class="border-b-2 dark:border-dark-5 whitespace-nowrap">Contenu</th>
                        <th class="border-b-2 dark:border-dark-5 whitespace-nowrap text-center">Baromètre</th>
                    </tr>
                </thead>
                <tbody>

                    <?php $cpt = 0 ?>
                    @foreach ($auditStructure as $name => $item)
                        @if (is_array($item))
                        <tr @if($cpt % 2 === 0)class="bg-gray-200 dark:bg-dark-1" @endif>
                            <td class="border-b dark:border-dark-5">{{ $name }}</td>
                            <td class="border-b dark:border-dark-5">
                                {{ $item['value'] }}<br>
                                <small><strong>{{$item['message'] }}</strong></small>

                            </td>
                            <td class="border-b dark:border-dark-5 font-size-3x1 text-center text-2xl">
                                @if($item['errorLvl'] === 0)
                                    <i class="fas fa-thermometer-empty text-theme-6"></i>
                                @endif

                                @if($item['errorLvl'] === 1)
                                    <i class="fas fa-thermometer-half text-theme-11"></i>
                                @endif

                                @if($item['errorLvl'] === 2)
                                    <i class="fas fa-thermometer-full text-theme-9"></i>
                                @endif
                            </td>
                        </tr>
                        <?php $cpt++ ?>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
