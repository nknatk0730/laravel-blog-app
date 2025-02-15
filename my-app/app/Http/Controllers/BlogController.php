<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BlogController extends Controller
{
    public function index()
    {
        // ユーザーがログイン済みか確認
        if (!Auth::check()) {
            return redirect()->route('login'); 
        }

        $blogs = Blog::latest()->paginate(3);
        $authUser = Auth::user()->name;

        return view('index', compact('blogs', 'authUser'));
    }

    public function create()
    {
        return view('blogs.create');
    }

    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login'); 
        }

        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'image' => 'required|image',
        ]);

        // imageファイルのアップロード
        $image = $request->file('image');
        // $image_path = $image->store('public/images');
        $image_path = $image->store('images', 'public'); // 'public' ディスクを明示的に指定

        Blog::create([
            'title' => $request->title,
            'content' => $request->content,
            'image' => $image_path,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('blogs.index');
    }

    public function edit(Blog $blog)
    {
        if ($blog->user_id !== Auth::id()) {
            return redirect()->route('blogs.index');
        }

        return view('blogs.edit', compact('blog'));
    }

    public function update(Request $request, Blog $blog)
    {
        if ($blog->user_id !== Auth::id()) {
            return redirect()->route('blogs.index');
        }

        $request->validate([
            'title' => 'required',
            'content' => 'required',
        ]);
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $image_path = $image->store('images', 'public');
        }

        $blog->update([
            'title' => $request->title,
            'content' => $request->content,
            'image' => $image_path ?? '',
        ]);

        return redirect()->route('blogs.index');
    }

    public function destroy(Blog $blog)
    {
        $blog->delete();

        return redirect()->route('blogs.index');
    }
}
