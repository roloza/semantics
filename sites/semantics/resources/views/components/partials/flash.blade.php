<div>
@if (session()->has('message'))
    <div>
        <div class="alert alert-{{$type}}-soft alert-dismissible {{ $display }} flex items-center mb-2" role="alert" >
            {{ session('message') }}
            <button type="button" class="btn-close" data-dismiss="alert" aria-label="Close" wire:click="$emit('close')">
                X
            </button>
        </div>
    </div>
@endif

</div>
