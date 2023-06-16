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
}
