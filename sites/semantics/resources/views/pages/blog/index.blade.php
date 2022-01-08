@extends('layout')

@section('title')
    Liste des articles
@endsection

@section('description')
@endsection

@section('keywords')
    analyse sémantique, mots-clés, descripteurs, analyse de texte, expressions
@endsection

@section('content')
    <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">{{$category !== null ? 'Articles de la catégorie ' . $category->name : 'Tous les articles'}}</h2>
        <div class="sm:ml-auto mt-3 sm:mt-0 relative text-gray-700 dark:text-gray-300">
            <div x-data="{dropdownMenu: false}" class="relative">
                <!-- Dropdown toggle button -->
                <button @click="dropdownMenu = ! dropdownMenu" class="dropdown-toggle btn btn-primary font-normal">
                    <span class="mr-4">Choix de la catégorie</span>
                    <i class="fas fa-chevron-down"></i>
                </button>
                <!-- Dropdown list -->
                <div x-show="dropdownMenu" class="absolute right-0 py-2 mt-2 bg-white bg-gray-100 rounded-md shadow-xl w-44">
                    <a href="{{ route('blog.index') }}" class="block px-4 py-2 text-sm text-gray-300 text-gray-700 hover:bg-gray-400 hover:text-white">
                        Tous les articles
                    </a>
                    @foreach($categories as $categoryElement)
                    <a href="{{ route('blog.index', ['slug' => $categoryElement->slug]) }}" class="block px-4 py-2 text-sm text-gray-300 text-gray-700 hover:bg-gray-400 hover:text-white">
                        {{ $categoryElement->name }}
                    </a>
                    @endforeach
                </div>


            </div>
        </div>
    </div>

    {{-- Articles --}}
    <div class="intro-y grid grid-cols-12 gap-6 mt-5">

        @foreach($posts as $post)
            <x-partials.article-card :post="$post"/>
        @endforeach

        <div class="intro-y col-span-12 flex flex-wrap sm:flex-row sm:flex-nowrap items-center">
            {{ $posts->links() }}
        </div>
    </div>
@endsection
