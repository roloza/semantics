<div class="intro-y col-span-12 md:col-span-6 xl:col-span-4 box">
    <div class="flex items-center border-b border-gray-200 dark:border-dark-5 px-5 py-4">
        <div class="ml-3 mr-auto">
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
</div>