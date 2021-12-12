<?php


namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{

    public function index()
    {
        $posts = Post::with('tags')->notDraft()->get();
        return view('pages.admin.posts.index', ['posts' => $posts]);
    }

    public function create()
    {
        $post = Post::draft();
        return view('pages.admin.posts.edit', ['post' => $post]);
    }

    public function edit(Post $post)
    {
        return view('pages.admin.posts.edit', ['post' => $post]);
    }

    public function update(Request $request, Post $post)
    {
        $post->update($request->all());

        $tags = $request->get('tags') ?? '';

        $post->saveTags($tags);
        return redirect()->route('admin.posts.index', ['post' => $post])->with('success', 'Article modifié');
    }
}