<div>

    @if (session()->has('message'))
        <div class="alert alert-primary show mb-2" role="alert">
            {{ session('message') }}
        </div>
    @endif

    @if($updateMode)
        @include('livewire.admin.categories.update')
    @else
        @include('livewire.admin.categories.create')
    @endif

    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 lg:col-span-6">
            <div class="intro-y box p-5">

                <table class="table">
                    <thead>
                    <tr>
                        <th class="border border-b-2 dark:border-dark-5 whitespace-nowrap">#</th>
                        <th class="border border-b-2 dark:border-dark-5 whitespace-nowrap">Nom</th>
                        <th class="border border-b-2 dark:border-dark-5 whitespace-nowrap">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($categories as $category)
                            <tr>
                                <td class="border">{{ $category->id }}</td>
                                <td class="border">{{ $category->name }}</td>
                                <td class="border">
                                    <button wire:click="edit({{ $category->id }})" class="btn btn-primary btn-sm">Edit</button>
                                    <button wire:click="delete({{ $category->id }})" class="btn btn-danger btn-sm">Delete</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>