<div class="grid grid-cols-12 gap-6 mt-5">
    <div class="intro-y col-span-12 lg:col-span-6">
        <div class="intro-y box p-5">
            <form wire:submit.prevent="store">

                {{-- Main Image --}}
                <div class="mt-3">
                    <label for="filename" class="form-label">Fichier</label>
                    <input name="filename" id="filename" type="file" class="form-control w-full" value="" wire:model="filename">
                    @error('filename') <span class="text-danger">{{ $message }}</span>@enderror

                </div>

                {{-- Titre --}}
                <div class="mt-3">
                    <label for="name" class="form-label">Titre</label>
                    <input name="name" id="name" type="text" class="form-control w-full" value="" wire:model="title">
                    @error('title') <span class="text-danger">{{ $message }}</span>@enderror
                </div>

                <div class="text-right mt-5">
                    <button class="btn btn-primary w-24">Envoyer</button>
                </div>
            </form>
        </div>
    </div>
</div>
