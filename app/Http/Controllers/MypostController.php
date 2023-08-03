<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;

class MypostController extends Controller
{
    public function index()
    {
        $posts = Post::latest()->get();
        $categories = Category::all();

        //render view with posts
        return view('mypost.index', compact('posts', 'categories'));
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        //
    }


    public function show(string $id)
    {
        //get post by ID
        $post = Post::findOrFail($id);
        $aut = auth()->user();

        //render view with post
        return view('mypost.show', compact('post', 'aut'));
    }


    public function edit(string $id)
    {
        $post = Post::findOrFail($id);
        $categories = Category::All();

        //render view with post
        return view('mypost.edit', compact('post', 'categories'));
    }


    public function update(Request $request, string $id)
    {
        //validate form
        $this->validate($request, [
            'image' => 'image|mimes:jpeg,jpg,png',
            'judul' => 'required',
            'category_id' => 'required',
            'deskripsi' => 'required',
            'jumlah' => 'required',
            'file_buku' => 'mimes:pdf',
        ]);

        //get post by ID
        $post = Post::findOrFail($id);
        $profile = $post->user->profile;

        //check if image is uploaded
        if ($request->hasFile('image') && $request->hasFile('file_buku')) {

            $image = $request->file('image');
            $image->storeAs('public/posts', $image->hashName());

            $filebuku = $request->file('file_buku');
            $filebuku->storeAs('public/posts', $filebuku->hashName());

            Storage::delete('public/posts/' . $post->image);
            Storage::delete('public/posts/' . $post->file_buku);

            $post->update([
                'image' => $image->hashName(),
                // 'user_id' => $request->user_id,
                'judul' => $request->judul,
                'category_id' => $request->category_id,
                'deskripsi' => $request->deskripsi,
                'jumlah' => $request->jumlah,
                'file_buku' => $filebuku->hashName(),
            ]);

            $profile->update([
                'nama' => $request->nama,
            ]);
        } elseif ($request->hasFile('image')) {

            $image = $request->file('image');
            $image->storeAs('public/posts', $image->hashName());

            Storage::delete('public/posts/' . $post->image);

            $post->update([
                'image' => $image->hashName(),
                // 'user_id' => $request->user_id,
                'judul' => $request->judul,
                'category_id' => $request->category_id,
                'deskripsi' => $request->deskripsi,
                'jumlah' => $request->jumlah,
            ]);

            $profile->update([
                'nama' => $request->nama,
            ]);

        } elseif ($request->hasFile('file_buku')) {
            $filebuku = $request->file('file_buku');
            $filebuku->storeAs('public/posts', $filebuku->hashName());

            Storage::delete('public/posts/' . $post->file_buku);

            $post->update([
                'file_buku' => $filebuku->hashName(),
                // 'user_id' => $request->user_id,
                'judul' => $request->judul,
                'category_id' => $request->category_id,
                'deskripsi' => $request->deskripsi,
                'jumlah' => $request->jumlah,
            ]);

            $profile->update([
                'nama' => $request->nama,
            ]);

        } else {

            //update post without image
            $post->update([
                // 'user_id' => $request->user_id,
                'judul' => $request->judul,
                'category_id' => $request->category_id,
                'deskripsi' => $request->deskripsi,
                'jumlah' => $request->jumlah,
            ]);

            $profile->update([
                'nama' => $request->nama,
            ]);
        }

        //redirect to index
        return redirect()->route('mypost.index')->with(['success' => 'Data Berhasil Diubah!']);
    }


    public function destroy(string $id)
    {
        //get post by ID
        $post = Post::findOrFail($id);
        // $profile = $post->user->profile;

        //delete image
        Storage::delete('public/posts/' . $post->image);
        Storage::delete('public/posts/' . $post->file_buku);

        //delete post
        $post->delete();
        // $profile->delete();

        //redirect to index
        return redirect()->route('mypost.index')->with(['success' => 'Data Berhasil Dihapus!']);
    }
}