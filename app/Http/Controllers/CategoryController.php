<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        //get posts
        $categories = Category::All();

        //render view with posts
        return view('categories.index', compact('categories'));
    }


    public function create()
    {
        $categories = Category::All();

        return view('categories.create', compact('categories'));
    }


    public function store(Request $request)
    {
        $this->validate($request, [
            'category' => 'required|unique:categories,kategori'
        ]);

        Category::create([
            'kategori' => $request->category
        ]);

        // Redirect to index
        return redirect()->route('posts.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }


    public function show(string $id)
    {
        // //get post by ID
        // $post = Post::findOrFail($id);

        // //render view with post
        // return view('categories.show', compact('post'));
    }


    public function edit(string $id)
    {
        //get post by ID
        $category = Category::findOrFail($id);

        //render view with post
        return view('categories.edit', compact('category'));
    }


    public function update(Request $request, string $id)
    {
        $category = Category::findOrFail($id);

        $this->validate($request, [
            'category' => 'required'
        ]);

        $category->update([
            'kategori' => $request->category
        ]);

        return redirect()->route('categories.index')->with(['success' => 'Data Berhasil Diubah!']);
    }


    public function destroy(string $id)
    {
        $category = Category::findorfail($id);

        $category->delete();

        return redirect()->route('categories.index')->with(['success' => 'Data Berhasil Dihapus!']);
    }
}