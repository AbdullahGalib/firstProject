<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Auth;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with('categories', 'users')->get();

        return response()->json(['posts' => $posts], 200);
    }

    public function store(Request $request)
    {
        /*$files = explode(';', $request->image);
        $file = explode('/', $files[0]);

        $ex = end($file);
        $image = $request->file('image');
        $img_name = time() . '.' . $ex;
        $image->move(public_path('images/posts'), $img_name);*/


        $request->validate([
            'title'      => 'required',
            'status'    => 'required'
        ]);



        $post = new Post();

        $post->title = $request->title;
        $post->slug = $request->title;
        $post->content = $request->content;
        $post->category_id = $request->category_id;
        $post->user_id = Auth::Id();
        $post->status = $request->status;


        $post->thumbnail = 'img_name';

        $post->save();
    }

    public function destroy($id)
    {
        Post::find($id)->delete();
    }

    public function edit($id)
    {
        $post = Post::find($id);

        return response()->json(['post' => $post], 200);
    }
    public function update(Request $request)
    {
        $request->validate([
            'title'      => 'required',
            'status'    => 'required'
        ]);
        $post = Post::find($request->id);


        $post->title = $request->title;
        $post->slug = $request->title;
        $post->content = $request->content;
        $post->category_id = $request->category_id;
        $post->status = $request->status;
        $post->save();
    }

    public function postItems(Request $request)
    {
        $sl = 0;
        foreach ($request->data as $id) {
            Post::find($id)->delete();
            $sl++;
        };
        $success = $sl > 0;
        return response()->json(['success' => $success, 'total' => $sl], 200);
    }

    public function changepostItems(Request $request)
    {
        $sl = 0;
        foreach ($request->data as $id) {
            $post = Post::find($id);
            $post->status = $request->status;
            $post->save();
            $sl++;
        };
        $success = $sl > 0;
        return response()->json(['success' => $success, 'total' => $sl], 200);
    }
}
