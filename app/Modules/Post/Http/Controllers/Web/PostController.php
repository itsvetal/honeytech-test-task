<?php

namespace App\Modules\Post\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Modules\Post\Http\Requests\Web\PostRequest;
use App\Modules\Post\Models\Post;
use App\Modules\Tag\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        $query = Post::with('tags');

        if ($request->filled('tag')) {
            $query->when($request->has('tag'), function ($query) use ($request) {
                $query->whereHas('tags', function ($q) use($request) {
                    $q->where('name', $request->tag);
                });
            });
        }

        $posts = $query->paginate(10);
        return view('posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        $tags = Tag::all();

        return view('posts.create', compact('tags'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostRequest $request)
    {
        $validated = $request->validated();

        $thumbnailPath = null;
        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = $request->file('thumbnail')->store('thumbnails', 'public');
            $validated['thumbnail'] = $thumbnailPath;
        }

        $post = Post::create($validated);

        if ($request->has('tags')) {
            $post->tags()->attach($request->tags);
        }
        return redirect()->route('posts.index')->with('success', 'Post is created!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        $post->load('tags');
        return view('posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        $tags = Tag::all();
        $post->load('tags');
        return view('posts.edit', compact('post', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostRequest $request, Post $post)
    {
        $validated = $request->validated();

        if ($request->has('thumbnail')) {
            if ($post->thumbnail) {
                Storage::disk('public')->delete($post->thumbnail);
            }
            $thumbnailPath = $request->file('thumbnail')->store('thumbnails', 'public');
            $validated['thumbnail'] = $thumbnailPath;
        }
        $post->update($validated);
        $post->tags()->sync($request->tags ?? []);
        return redirect()->route('posts.index')->with('success', 'Post is updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return redirect()->route('posts.index')->with('success', 'Post is removed!');
    }
}
