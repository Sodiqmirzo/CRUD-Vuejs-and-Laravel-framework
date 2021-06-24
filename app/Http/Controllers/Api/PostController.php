<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    protected $post = '';


    public function __construct(Post $post)
    {
        // $this->middleware('auth:api');
        $this->post = $post;
    }


    public function index()
    {
        $sortField = request('sort_field', 'created_at');
        if(!in_array($sortField, ['title', 'post_text', 'created_at'])) {
            $sortField = 'created_at';
        }
        
        $sortDirection = request('sort_direction', 'desc');
        if(!in_array($sortField, ['asc', 'desc'])) {
            $sortDirection = 'desc';
        }
        $posts = Post::when(request('category_id', '') != '', function($query){
            $query->where('category_id', request('category_id'));
        })->orderBy($sortField, $sortDirection)->paginate(10);
        return PostResource::collection($posts);
    }

    public function store (StorePostRequest $request)
    {
        // dd($request->all());
        // $post = Post::create($request->validate());
        // sleep(3);

        if($request->hasFile('thumbnail')) {
            $filename = $request->thumbnail->getClientOriginalName();
            info($filename); // Writing to  a log, for example
        }

        $post = $this->post->create([
            'title' => $request->get('title'),
            'post_text' => $request->get('post_text'),
            'category_id' => $request->get('category_id'),
        ]);

        return new PostResource($post);
    }

    public function show(Post $post)
    {
        return new PostResource($post);
    }

    public function update(Post $post, StorePostRequest $request)
    {
        $post->update($request->all());
        
        return new PostResource($post);
    }

    public function destroy(Post $post)
    {
        $post->delete();
        
        return response()->noContent();
    }
}