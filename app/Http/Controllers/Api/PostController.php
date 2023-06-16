<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\CreatePostRequest;
use App\Models\Post;

class PostController extends Controller
{
    public function store(CreatePostRequest $request)
    {
        $validatedData = $request->validated();

        $post = $request->user()->posts()->create([
            'title' => $validatedData['title'],
            'content' => $validatedData['content'],
            'is_published' => false,
        ]);

        return response()->json(['message' => 'Post created successfully.'], 201);
    }

    public function getUnpublishedPosts(Request $request)
    {
        $perPage = $request->query('per_page', 10); 
        $sortBy = $request->query('sort_by', 'created_at');
        $sortDirection = $request->query('sort_direction', 'desc');

        $posts = Post::where('is_published', false)
            ->orderBy($sortBy, $sortDirection)
            ->paginate($perPage);

        return response()->json(['posts' => $posts], 201);
    
    
    }

    public function update(Request $request, Post $post)
    {
        $request->validate([
            'action' => 'required|in:accept,reject',
        ]);

        if ($request->input('action') === 'accept') {
            $post->is_published = true;
            $message = 'Post accepted successfully.';
        } else {
            $post->is_published = false;
            $message = 'Post rejected successfully.';
        }

        $post->save();

        return response()->json(['message' => $message], 200);
    }

    
}
