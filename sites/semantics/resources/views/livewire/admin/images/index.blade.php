<div>

    @if (session()->has('message'))
        <div class="alert alert-primary show mb-2" role="alert">
            {{ session('message') }}
        </div>
    @endif

    @if($updateMode)
        @include('livewire.admin.images.update')
    @else
        @include('livewire.admin.images.create')
    @endif

    <div class="intro-y grid grid-cols-12 gap-3 sm:gap-6 mt-5">
        @foreach($images as $image)
            <div class="intro-y col-span-6 sm:col-span-4 md:col-span-3 xxl:col-span-2">

                <div class="file box rounded-md px-5 pt-8 pb-5 px-3 sm:px-5 relative zoom-in">
                    <a href="" class="w-3/5 file__icon file__icon--image mx-auto">
                        <div class="file__icon--image__preview image-fit">
                            <img src="{{ route('image.displayImage', $image->slug) }}">
                        </div>
                    </a>
                    <a href="" class="block font-medium mt-4 text-center truncate">{{ $image->filename }}</a>
                    <div class="text-gray-600 text-xs text-center mt-0.5">{{ $image->title }}</div>
                    <div class="absolute top-0 right-0 mr-2 mt-2 dropdown ml-auto">
                        <button wire:click="edit({{ $image->id }})" class="btn btn-primary btn-sm">Edit</button>
                        <button wire:click="delete({{ $image->id }})" class="btn btn-danger btn-sm">Delete</button>
                    </div>
                </div>
            </div>
        @endforeach

    </div>
</div>