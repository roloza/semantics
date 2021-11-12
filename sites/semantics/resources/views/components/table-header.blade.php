<th class="border border-b-2 dark:border-dark-5 whitespace-nowrap cursor-pointer" wire:click="setOrderField('{{ $name }}')" style="{{ $style }};">
    {{ $slot }}
    @if($visible)
        <span class="arrow">
            {!! $direction === 'ASC' ? '&uarr;' : ' &darr;' !!}
        </span>
    @endif
</th>
