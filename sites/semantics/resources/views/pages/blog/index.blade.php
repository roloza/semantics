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
        <h2 class="text-lg font-medium mr-auto">Tous les articles</h2>
    </div>

    {{-- Articles --}}
    <div class="intro-y grid grid-cols-12 gap-6 mt-5">

        @foreach($posts as $post)
        <div class="intro-y col-span-12 md:col-span-6 xl:col-span-4 box">
            <div class="flex items-center border-b border-gray-200 dark:border-dark-5 px-5 py-4">
                <div class="w-10 h-10 flex-none image-fit">
                    <img alt="" class="rounded-full" src="{{ (new \App\Custom\Tools\Avatar($post->author))->base64() }}">
                </div>
                <div class="ml-3 mr-auto">
                    <a href="" class="font-medium">{{ $post->author }}</a>
                    <div class="flex text-gray-600 truncate text-xs mt-0.5">
                        @if ($post->category)
                            <a class="text-theme-1 dark:text-theme-10" href="">{{ $post->category->name }}</a> <span class="mx-1">•</span>
                        @endif
                        {{ \Carbon\Carbon::parse($post->created_at)->format('d/m/Y')}}
                    </div>
                </div>
            </div>
            <div class="p-5">
                <a href="{{ route('blog.show', $post->slug) }}">
                    <div class="h-40 xxl:h-56 image-fit">
                        <img alt="{{ $post->image ? $post->image->title : '' }}" class="rounded-md zoom-in" src="{{ $post->image ? route('image.displayImage', $post->image->slug) : 'http://rubick-laravel.left4code.com/dist/images/preview-1.jpg' }}">
                    </div>
                    <h2 class="block font-medium text-base mt-5">{{ $post->name }}</h2>
                    <div class="text-gray-700 dark:text-gray-600 mt-2">{!! \Illuminate\Support\Str::limit(strip_tags($post->content), 250, $end='...') !!}</div>
                </a>
            </div>
            {{-- Share --}}
            <div class="flex items-center px-5 py-3 border-t border-gray-200 dark:border-dark-5">
                <a href="" class="intro-x w-8 h-8 flex items-center justify-center rounded-full bg-theme-14 dark:bg-dark-5 dark:text-gray-300 text-theme-10 ml-auto tooltip">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-share-2 w-3 h-3"><circle cx="18" cy="5" r="3"></circle><circle cx="6" cy="12" r="3"></circle><circle cx="18" cy="19" r="3"></circle><line x1="8.59" y1="13.51" x2="15.42" y2="17.49"></line><line x1="15.41" y1="6.51" x2="8.59" y2="10.49"></line></svg>
                </a>
                <a href="" class="intro-x w-8 h-8 flex items-center justify-center rounded-full bg-theme-1 text-white ml-2 tooltip">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-share w-3 h-3"><path d="M4 12v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-8"></path><polyline points="16 6 12 2 8 6"></polyline><line x1="12" y1="2" x2="12" y2="15"></line></svg>
                </a>
            </div>
            {{-- END Share --}}
        </div>
        @endforeach

        <div class="intro-y col-span-12 flex flex-wrap sm:flex-row sm:flex-nowrap items-center">
            {{ $posts->links() }}
        </div>
    </div>
@endsection
