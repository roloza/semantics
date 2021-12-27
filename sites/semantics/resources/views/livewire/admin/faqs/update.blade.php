<div class="grid grid-cols-12 mt-5">
    <div class="intro-y col-span-12">
        <div class="intro-y box p-5">
            <form>
                <input type="hidden" wire:model="category_id">

                {{-- Name --}}
                <div class="mt-3">
                    <label for="name">Nom</label>
                    <input name="name" type="text" class="form-control w-full" id="exampleFormControlInput1" placeholder="Nom" wire:model="name">
                    @error('title') <span class="text-danger">{{ $message }}</span>@enderror
                </div>

                {{-- Content --}}
                <div class="mt-3">
                    <label for="content" class="form-label">Contenu</label>

                    <textarea  class="form-control w-full" id="content" cols="30" rows="10" wire:model="content" placeholder="Contenu"></textarea>
                    @error('content') <span class="text-danger">{{ $message }}</span>@enderror
                </div>

                {{-- Position --}}
                <div class="mt-3">
                    <label for="name" class="form-label">Position</label>
                    <input name="position" id="name" type="number" class="form-control w-full" wire:model="position">
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
                    <label for="active" class="form-label">Statut</label>
                    <input name="active" id="active" type="number" min="0" max="1" class="form-control w-full" value="" wire:model="active">
                    @error('active') <span class="text-danger">{{ $message }}</span>@enderror
                </div>

                <div class="text-right mt-5">
                    <button wire:click.prevent="update()" class="btn btn-info">Mettre à jour</button>
                    <button wire:click.prevent="cancel()" class="btn btn-dark w-24">Annuler</button>
                </div>
            </form>
        </div>
    </div>
</div>
