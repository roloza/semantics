<div>

    @if (session()->has('message'))
        <div class="alert alert-primary show mb-2" role="alert">
            {{ session('message') }}
        </div>
    @endif

    @if($updateMode)
        @include('livewire.admin.faqs.update')
    @else
        @include('livewire.admin.faqs.create')
    @endif

    <div class="grid grid-cols-12 mt-5">
        <div class="intro-y col-span-12">
            <div class="intro-y box p-5">

                <table class="table">
                    <thead>
                    <tr>
                        <th class="border border-b-2 dark:border-dark-5 whitespace-nowrap">#</th>
                        <th class="border border-b-2 dark:border-dark-5 whitespace-nowrap">Nom</th>
                        <th class="border border-b-2 dark:border-dark-5 whitespace-nowrap">Position</th>
                        <th class="border border-b-2 dark:border-dark-5 whitespace-nowrap">Statut</th>
                        <th class="border border-b-2 dark:border-dark-5 whitespace-nowrap">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($faqs as $faq)
                            <tr>
                                <td class="border">{{ $faq->id }}</td>
                                <td class="border">{{ $faq->name }}</td>
                                <td class="border">{{ $faq->position }}</td>
                                <td class="border">{{ $faq->active }}</td>
                                <td class="border">
                                    <button wire:click="edit({{ $faq->id }})" class="btn btn-primary btn-sm">Edit</button>
                                    <button wire:click="delete({{ $faq->id }})" class="btn btn-danger btn-sm">Delete</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>