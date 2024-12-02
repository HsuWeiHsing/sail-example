<?php

namespace App\Http\Controllers;
// use Illuminate\Support\Facades\Gate;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function create() {
        return view('post.create');
    }

    public function store(Request $request) {
        // Gate::authorize('test');
        
        $validated = $request->validate([
            'title' => 'required|max:20',
            'body' => 'required|max:400',
        ]);

        $validated['user_id'] = auth()->id();

        $post = Post::create($validated);
        $request->session()->flash('message', '保存しました');
        return back();
    }

    public function index() {
        //$posts=Post::find(1);
        // $posts=Post::whereDate('created_at', '2024-11-18')->first();
        // $posts=Post::all();
        $posts=Post::with('user')->get();
        return view('post.index', compact('posts'));
    }

    // public function show (Post $post) {
    //     return view('post.show', compact('post'));
    // }

    public function show($id) {
        $post=Post::find($id);
        return view('post.show', compact('post'));
    }

    public function edit(Post $post) {
        return view('post.edit', compact('post'));
    }

    public function update(Request $request, Post $post) {
        $validated = $request->validate([
            'title' => 'required|max:20',
            'body' => 'required|max:400',
        ]);

        $validated['user_id'] = auth()->id();

        $post->update($validated);

        $request->session()->flash('message', '更新しました');
        return back();
    }

    public function destroy(Request $request , Post $post) {
        \Log::debug('postcontrollerテストテスト');
        $post->delete();
        $request->session()->flash('message', '削除しました');
        return redirect('post');
    }
}
