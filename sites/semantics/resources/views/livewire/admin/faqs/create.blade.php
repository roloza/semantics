<div class="grid grid-cols-12 mt-5">
    <div class="intro-y col-span-12">
        <div class="intro-y box p-5">
            <form wire:submit.prevent="store">

                {{-- Name --}}
                <div class="mt-3">
                    <label for="name" class="form-label">Nom</label>
                    <input name="name" id="name" type="text" class="form-control w-full" value="" wire:model="name">
                    @error('name') <span class="text-danger">{{ $message }}</span>@enderror
                </div>

                {{-- Content --}}
                <div class="mt-3">
                    <label for="content" class="form-label">Contenu</label>
                    <textarea  class="form-control w-full" name="content" id="content" cols="30" rows="10" wire:model="content"></textarea>
                    @error('content') <span class="text-danger">{{ $message }}</span>@enderror
                </div>

                {{-- Position --}}
                <div class="mt-3">
                    <label for="name" class="form-label">Position</label>
                    <input name="position" id="name" type="number" class="form-control w-full" value="" wire:model="position">
                    @error('position') <span class="text-danger">{{ $message }}</span>@enderror
                </div>

                {{-- Icon --}}
                <div class="mt-3">
                    <label for="icon" class="form-label">Icone</label>
                    <input name="icon" id="icon" type="text" class="form-control w-full" value="" wire:model="icon">
                    @error('icon') <span class="text-danger">{{ $message }}</span>@enderror
                </div>

                {{-- Statut --}}
                <div class="mt-3">
                    <label for="name" class="form-label">Statut</label>
                    <input name="active" id="active" type="number" min="0" max="1" class="form-control w-full" value="0" wire:model="active">
                    @error('active') <span class="text-danger">{{ $message }}</span>@enderror
                </div>

                <div class="text-right mt-5">
                    <button class="btn btn-primary w-24">Envoyer</button>
                </div>
            </form>
        </div>
    </div>
</div>
