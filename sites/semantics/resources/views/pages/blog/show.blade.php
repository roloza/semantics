@extends('layout')

@section('title'){{ $post->name }}@endsection

@section('description'){{ $post->description }}@endsection

@section('keywords'){{ $post->keywords }}@endsection

@section('content')
    <div class="grid grid-cols-12 gap-6 mt-8">
        <div class="col-span-12 lg:col-span-8">
            <div class="intro-y news xl:w-5/5 p-5 box mt-8">
                <!-- BEGIN: Blog Layout -->
                <h1 class="intro-y font-medium text-xl sm:text-2xl">{{ $post->name }}</h1>
                <div class="intro-y text-gray-700 dark:text-gray-600 mt-3 text-xs sm:text-sm">
                    {{ \Carbon\Carbon::parse($post->created_at)->format('d/m/Y')}}<span class="mx-1">•</span>
                    @if ($post->category)
                        <a class="text-theme-1 dark:text-theme-10" href="">{{ $post->category->name }}</a> <span class="mx-1">•</span>
                    @endif
                    Temps de lecture : {{ $readingTime }}
                </div>
                <div class="intro-y mt-6">
                    <div class="news__preview image-fit">
                        <img alt="{{ $post->image ? $post->image->title : '' }}" class="rounded-md zoom-in" src="{{ $post->image ? route('image.displayImage', $post->image->slug) : 'http://rubick-laravel.left4code.com/dist/images/preview-15.jpg' }}">
                    </div>
                </div>

                <div class="intro-y flex relative pt-16 sm:pt-6 items-center pb-6">

                    <a href="" class="intro-x w-8 h-8 sm:w-10 sm:h-10 flex flex-none items-center justify-center rounded-full bg-theme-14 dark:bg-dark-5 dark:text-gray-300 text-theme-10 ml-auto sm:ml-0 tooltip">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-share-2 w-3 h-3"><circle cx="18" cy="5" r="3"></circle><circle cx="6" cy="12" r="3"></circle><circle cx="18" cy="19" r="3"></circle><line x1="8.59" y1="13.51" x2="15.42" y2="17.49"></line><line x1="15.41" y1="6.51" x2="8.59" y2="10.49"></line></svg>
                    </a>
                    <a href="" class="intro-x w-8 h-8 sm:w-10 sm:h-10 flex flex-none items-center justify-center rounded-full bg-theme-1 text-white ml-3 tooltip">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-share w-3 h-3"><path d="M4 12v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-8"></path><polyline points="16 6 12 2 8 6"></polyline><line x1="12" y1="2" x2="12" y2="15"></line></svg>
                    </a>
                </div>

                <div class="intro-y text-justify leading-relaxed article">
                    {!! $post->content  !!}

                </div>
                <div class="mt-4">
                    @foreach($post->tags as $tag)
                        <a href="#" class="inline-block py-1 px-2 rounded last:mr-0 mr-1 bg-theme-14 text-gray-600">{{ $tag->name }}</a>
                    @endforeach
                </div>
                <div class="intro-y flex text-xs sm:text-sm flex-col sm:flex-row items-center mt-5 pt-5 border-t border-gray-200 dark:border-dark-5">
                    <div class="flex items-center">
                        <div class="w-12 h-12 flex-none image-fit">
                            <img alt="Rubick Tailwind HTML Admin Template" class="rounded-full" src="{{ (new \App\Custom\Tools\Avatar($post->author))->base64() }}">
                        </div>
                        <div class="ml-3 mr-auto">
                            {{ $post->author }}
                        </div>
                    </div>
                    <div class="flex items-center text-gray-700 dark:text-gray-600 sm:ml-auto mt-5 sm:mt-0">
                        Partager cet article :
                        <a href="" class="w-8 h-8 sm:w-10 sm:h-10 rounded-full flex items-center justify-center border dark:border-dark-5 ml-2 text-gray-500 zoom-in tooltip">
                            <i class="fab fa-facebook-f w-3 h-3 fill-current"></i>

                        </a>
                        <a href="" class="w-8 h-8 sm:w-10 sm:h-10 rounded-full flex items-center justify-center border dark:border-dark-5 ml-2 text-gray-500 zoom-in tooltip">
                            <i class="fab fa-twitter w-3 h-3 fill-current"></i>

                        </a>
                        <a href="" class="w-8 h-8 sm:w-10 sm:h-10 rounded-full flex items-center justify-center border dark:border-dark-5 ml-2 text-gray-500 zoom-in tooltip">
                            <i class="fab fa-linkedin-in w-3 h-3 fill-current"></i>
                        </a>
                    </div>
                </div>
                <!-- END: Blog Layout -->
            </div>
        </div>
        <div class="col-span-12 lg:col-span-3 mt-8">

                <x-partials.widget-categories :categories="$categories"></x-partials.widget-categories>
                <div  id="summary-container">
                    <div class="box p-5" style="display: none">
                        <h3 class="text-lg font-medium ">Sommaire</h3>
                        <div class="border-t border-theme-1 dark:border-dark-5 mt-4 pt-4 ">
                            <div id="jsSommaireContent"></div>
                        </div>
                    </div>
                </div>
        </div>
    </div>
@endsection
