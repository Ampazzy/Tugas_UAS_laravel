<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Post;

use App\Http\Resources\PostResource;

use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function index()
    {
        //get all posts
        $posts = Post::latest()->get();

        //return collection of posts as a resource
        return new PostResource(true, 'List Data', $posts);
    }

    public function store(Request $request)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'image' => 'required|image|mimes:jpeg,jpg,png',
            'judul' => 'required',
            'category_id' => 'required',
            'deskripsi' => 'required',
            'jumlah' => 'required',
            'file_buku' => 'nullable|mimes:pdf',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //upload image
        $image = $request->file('image');
        $image->storeAs('public/posts', $image->hashName());

        $filebuku = $request->file('file_buku');
        $filebuku->storeAs('public/posts', $filebuku->hashName());

        //create post
        $post = Post::create([
            'image' => $image->hashName(),
            'user_id' => $request->user_id,
            'judul' => $request->judul,
            'category_id' => $request->category_id,
            'deskripsi' => $request->deskripsi,
            'jumlah' => $request->jumlah,
            'file_buku' => $filebuku->hashName(),
        ]);

        //return response
        return new PostResource(true, 'Data Berhasil Ditambahkan!', $post);
    }

    public function show($id)
    {
        //find post by ID
        $post = Post::findOrFail($id);

        //return single post as a resource
        return new PostResource(true, 'Ketemu!', $post);
    }

    public function update(Request $request, $id)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'image' => 'image|mimes:jpeg,jpg,png',
            'judul' => 'required',
            'category_id' => 'required',
            'deskripsi' => 'required',
            'jumlah' => 'required',
            'file_buku' => 'mimes:pdf',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //find post by ID
        $post = Post::findOrFail($id);
        $profile = $post->user->profile;

        //check if image is uploaded
        if ($request->hasFile('image') && $request->hasFile('file_buku')) {

            $image = $request->file('image');
            $image->storeAs('public/posts', $image->hashName());

            $filebuku = $request->file('file_buku');
            $filebuku->storeAs('public/posts', $filebuku->hashName());

            Storage::delete('public/posts/' . basename($post->image));
            Storage::delete('public/posts/' . basename($post->file_buku));

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

            Storage::delete('public/posts/' . basename($post->image));

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

            Storage::delete('public/posts/' . basename($post->file_buku));

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

        //return response
        return new PostResource(true, 'Data Berhasil Diubah!', $post);
    }

    public function destroy($id)
    {

        //get post by ID
        $post = Post::findOrFail($id);

        //delete image
        Storage::delete('public/posts/' . basename($post->image));
        Storage::delete('public/posts/' . basename($post->file_buku));

        //delete post
        $post->delete();


        //return response
        return new PostResource(true, 'Data Post Berhasil Dihapus!', null);
    }
}