<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class NewPostController extends Controller
{
    public function index()
    {
        $posts = auth()->user()->posts;

        return response()->json([
            'success' => true,
            'data' => $posts
        ]);
    }

    public function show($id)
    {
        $post = auth()->user()->posts()->find($id);

        if (!$post) {
            return response()->json([
                'success' => false,
                'message' => 'Post not found '
            ], 400);
        }

        return response()->json([
            'success' => true,
            'data' => $post->toArray()
        ], 400);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'description' => 'required'
        ]);

        $post = new Post();
        $post->title = $request->title;
        $post->description = $request->description;

        if (auth()->user()->posts()->save($post))
            return response()->json([
                'Success' => true,
                'Data' => $post->toArray()
            ]);
        else
            return response()->json([
                'Success' => false,
                'Message' => 'Post not added'
            ], 500);
    }

    public function update(Request $request, $id)
    {
        // $post = auth()->user()->posts()->find($id);

        $post = Post::find($id);

        if (!$post) {
            return response()->json([
                'Success' => false,
                'Message' => 'Post not found'
            ], 400);
        }
        // return $request;
        $post->title = $request->title;
        $post->description = $request->description;
        $result = $post->update();
        // $updated = $post->fill($request->all())->save();

        if ($result)
            return response()->json([
                'Message' => 'Success',
                'Data' => $post
            ]);
        else
            return response()->json([
                'Success' => false,
                'Message' => 'Post can not be updated'
            ], 500);
    }

    public function destroy($id)
    {
        $post = auth()->user()->posts()->find($id);

        if (!$post) {
            return response()->json([
                'Success' => false,
                'Message' => 'Post not found'
            ], 400);
        }

        if ($post->delete()) {
            return response()->json([
                'Success' => true
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Post can not be deleted'
            ], 500);
        }
    }
}
