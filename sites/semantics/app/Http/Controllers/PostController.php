<?php

namespace App\Http\Controllers;

use App\Custom\Tools\ReadingTime;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Support\Facades\View;

class PostController extends Controller
{
    public function index($slug = null)
    {

        $breadcrumb = [['title' => 'Tous les articles']];
        View::share('breadcrumb', $breadcrumb);

        $category = null;
        $query = new Post();
        if ($slug !== null) {
            $category = Category::where('slug', $slug)->first();
            if ($category !== null) {
                $query->where('category_id', $category->id);
            }
        }
        $posts = $query->notDraft()->online()->orderBy('created_at', 'DESC')->paginate(12);
        $categories = Category::get();
        return view('pages.blog.index', [
            'posts' => $posts,
            'categories' => $categories,
            'category' => $category
        ]);
    }

    public function show($slug)
    {
        $post = Post::where('slug', $slug)->firstOrFail();
        $categories = Category::get();
        $seconds = ReadingTime::readingTime($post->content);
        $breadcrumb = [['title' => 'Tous les articles', 'link' => route('blog.index')], ['title' => $post->name]];
        View::share('breadcrumb', $breadcrumb);

        return view('pages.blog.show', [
            'post' => $post,
            'categories' => $categories,
            'readingTime' => ReadingTime::parseTime($seconds)
        ]);
    }
}
