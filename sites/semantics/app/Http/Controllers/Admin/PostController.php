<?php


namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Image;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PostController extends Controller
{

    public function index()
    {
        $posts = Post::notDraft()->orderBy('created_at', 'DESC')->paginate(25);
        return view('pages.admin.posts.index', ['posts' => $posts]);
    }

    public function create()
    {
        $post = Post::draft();
        $images = Image::all();
        $categories = Category::all();
        $posts = Post::where('id', '<>', $post->id)->get();

        return view('pages.admin.posts.edit', [
            'posts' => $posts,
            'post' => $post,
            'tags' => '',
            'images' => $images,
            'categories' => $categories,
        ]);
    }

    public function edit(Post $post)
    {
        $images = Image::all();
        $categories = Category::all();
        $posts = Post::where('id', '<>', $post->id)->get();

        $tags = '';
        foreach ($post->tags as $tag) {
            $tags .= ',' . $tag->name;
        }
        $tags = trim($tags, ',');


        return view('pages.admin.posts.edit', [
            'posts' => $posts,
            'post' => $post,
            'images' => $images,
            'categories' => $categories,
            'tags' => $tags,
        ]);
    }

    public function update(Request $request, Post $post)
    {
        // Form validation
        $request->validate([
            'name' => 'required',
            'content' => 'required',
            'image_id' => '',
            'category_id' => '',
            'description' => '',
            'keywords' => '',
            'author' => '',
            'parent_id' => '',
            'published' => '',
        ]);

        $post->update([
            'name' => $request->name,
            'content' => $request->get('content'),
            'slug' => Str::slug($request->name),
            'image_id' => $request->image_id  ?? null,
            'category_id' => $request->category_id ?? null,
            'description' => $request->description ?? '',
            'keywords' => $request->keywords ?? '',
            'author' => $request->author ?? 'Roloza',
            'parent_id' => $request->parent_id ?? null,
            'published' => $request->published && $request->published === 'on',
        ]);

        $tags = $request->get('tags') ?? '';

        $post->saveTags($tags);
        return redirect()->route('admin.posts.index', ['post' => $post])->with('success', 'Article modifié');
    }
}