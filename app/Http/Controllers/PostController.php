<?php

namespace App\Http\Controllers;

//import Model
use App\Models\Post;
use App\Models\Profile;
use App\Models\Role;
use App\Models\User;
use App\Models\Category;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\App;

use Illuminate\Http\Request;

//return type View
use Illuminate\View\View;

//return type redirectResponse
use Illuminate\Http\RedirectResponse;

//import Facade "Storage"
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function index(): View
    {
        $posts = Post::latest()->get();
        $categories = Category::all();

        //render view with posts
        return view('posts.index', compact('posts', 'categories'));
    }

    public function create(): View
    {
        $posts = Post::All();
        $categories = Category::All();

        return view('posts.create', compact('posts', 'categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        // Validate form
        $this->validate($request, [
            'image' => 'required|image|mimes:jpeg,jpg,png',
            'judul' => 'required',
            'category_id' => 'required',
            'deskripsi' => 'required',
            'jumlah' => 'required',
            'file_buku' => 'nullable|mimes:pdf',
        ]);

        // Upload image
        $image = $request->file('image');
        $image->storeAs('public/posts', $image->hashName());

        $filebuku = $request->file('file_buku');
        $filebuku->storeAs('public/posts', $filebuku->hashName());

        // Create post
        Post::create([
            'image' => $image->hashName(),
            'user_id' => $request->user_id,
            'judul' => $request->judul,
            'category_id' => $request->category_id,
            'deskripsi' => $request->deskripsi,
            'jumlah' => $request->jumlah,
            'file_buku' => $filebuku->hashName(),
        ]);

        // Redirect to index
        return redirect()->route('posts.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }


    public function show(string $id): View
    {
        //get post by ID
        $post = Post::findOrFail($id);

        //render view with post
        return view('posts.show', compact('post'));
    }

    public function edit(string $id): View
    {
        //get post by ID
        $post = Post::findOrFail($id);
        $categories = Category::All();

        //render view with post
        return view('posts.edit', compact('post', 'categories'));
    }

    public function update(Request $request, $id): RedirectResponse
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
        return redirect()->route('posts.index')->with(['success' => 'Data Berhasil Diubah!']);
    }

    public function destroy($id): RedirectResponse
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
        return redirect()->route('posts.index')->with(['success' => 'Data Berhasil Dihapus!']);
    }

    public function exportpdf(Request $request)
    {
        $id = $request->query('id');
        $post = Post::find($id);

        $data2 = $post->judul;
        $data3 = $post->user->profile->nama;
        $data4 = $post->category->kategori;
        $data5 = $post->jumlah;
        $data6 = $post->deskripsi;
        $data7 = $post->created_at;
        $data8 = $post->updated_at;

        // Ambil data gambar dari $post->image (asumsikan sudah base64-encoded)
        $base64Image = $post->image;

        // Menyesuaikan jenis konten dalam data URI sesuai dengan format gambar yang diberikan
        if (strpos($base64Image, 'data:image/jpeg;base64,') === 0) {
            $contentType = 'image/jpeg';
        } elseif (strpos($base64Image, 'data:image/png;base64,') === 0) {
            $contentType = 'image/png';
        } elseif (strpos($base64Image, 'data:image/gif;base64,') === 0) {
            $contentType = 'image/gif';
        } else {
            // Jika format tidak dikenal, berikan default jenis konten (misalnya: JPEG)
            $contentType = 'image/jpeg';
        }

        // Gunakan $base64Image dalam kode HTML Anda
        $imageUrl = $base64Image;

        // Menyematkan gambar dalam tag <img> sebagai data URI dengan jenis konten yang sesuai
        $imageUrl = 'data:' . $contentType . ';base64,' . $imageUrl;

        // Gunakan $imageUrl dalam kode HTML Anda
        // ...

        $pdf = App::make('dompdf.wrapper');
        $pdf->loadHTML(
            '<img src="' . $imageUrl . '" alt="Gambar" style="width: 150px;">
                       <p>Judul: ' . $data2 . '</p>
                       <p>Nama: ' . $data3 . '</p>
                       <p>Kategori: ' . $data4 . '</p>
                       <p>Jumlah: ' . $data5 . '</p>
                       <p>Deskripsi: ' . $data6 . '</p>
                       <p>created_at: ' . $data7 . '</p>
                       <p>updated_at: ' . $data8 . '</p>'
        );

        return $pdf->download($data2 . '_' . $data4 . '.pdf');

    }

}