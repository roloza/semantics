<div class="intro-y box bg-theme-1 p-5 mb-6">
    <h3 class="text-lg font-medium text-white">Catégories</h3>

    <div class="border-t border-theme-2 dark:border-dark-5 mt-4 pt-4 text-white">
        @foreach($categories as $categorie)
            <a href="{{ route('blog.index', ['slug' => $categorie->slug]) }}" class="flex items-center px-3 py-2 truncate">
                <div class="w-2 h-2 bg-theme-11 rounded-full mr-3"></div> {{ $categorie->name }}
            </a>
        @endforeach
    </div>
</div>