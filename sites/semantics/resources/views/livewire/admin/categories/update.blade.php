<div class="grid grid-cols-12 gap-6 mt-5">
    <div class="intro-y col-span-12 lg:col-span-6">
        <div class="intro-y box p-5">
            <form>
                <input type="hidden" wire:model="category_id">


                <div class="mt-3">
                    <label for="name">Nom</label>
                    <input name="name" type="text" class="form-control  w-full" id="exampleFormControlInput1" placeholder="Nom" wire:model="name">
                    @error('title') <span class="text-danger">{{ $message }}</span>@enderror
                </div>
                <div class="text-right mt-5">
                    <button wire:click.prevent="update()" class="btn btn-info">Mettre à jour</button>
                    <button wire:click.prevent="cancel()" class="btn btn-dark w-24">Annuler</button>
                </div>
            </form>
        </div>
    </div>
</div>
