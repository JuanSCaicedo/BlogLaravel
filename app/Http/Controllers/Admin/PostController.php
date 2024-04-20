<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;

use App\Http\Requests\PostRequest;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.posts.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::pluck('name', 'id');
        $tags = Tag::all();

        return view('admin.posts.create', compact('categories', 'tags'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostRequest $request)
    {
        // return Storage::put('posts', $request->file('file'));
        $post = Post::create($request->all());

        if ($request->file('file')) {
            $url = Storage::put('posts', $request->file('file'));

            $post->image()->create([
                'url' => $url
            ]);
        }

        if ($request->tags) {
            $post->tags()->attach($request->tags);
        }

        return redirect()->route('admin.posts.edit', $post);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return view('admin.posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        $categories = Category::pluck('name', 'id');
        $tags = Tag::all();
        $selectedTags = $post->tags->pluck('id')->toArray(); // Obtener los ID de las etiquetas del post
        return view('admin.posts.edit', compact('post', 'categories', 'tags', 'selectedTags'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostRequest $request, Post $post)
    {
        $post->update($request->all());
    
        if ($request->file('file')) {
            $url = Storage::put('posts', $request->file('file'));
    
            if ($post->image) {
                Storage::delete($post->image->url);
    
                $post->image()->update([
                    'url' => $url
                ]);
            } else {
                $post->image()->create([
                    'url' => $url
                ]);
            }
        }
    
        // Obtener las etiquetas seleccionadas del formulario
        $selectedTags = $request->tags;
    
        // Obtener las etiquetas actualmente asociadas al post
        $postTags = $post->tags->pluck('id')->toArray();
    
        // Etiquetas que han sido deseleccionadas
        $tagsToDetach = array_diff($postTags, $selectedTags);
    
        // Desvincular las etiquetas deseleccionadas
        if (!empty($tagsToDetach)) {
            $post->tags()->detach($tagsToDetach);
        }
    
        // Adjuntar las etiquetas seleccionadas si no están asociadas al post
        if ($selectedTags) {
            foreach ($selectedTags as $tag) {
                if (!in_array($tag, $postTags)) {
                    $post->tags()->attach($tag);
                }
            }
        }
    
        return redirect()->route('admin.posts.edit', $post)->with('info', 'Post Actualizado Correctamente');
    }    


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        //
    }
}
