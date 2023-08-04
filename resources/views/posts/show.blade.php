    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>My Perpus</title>
        <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.0/dist/umd/popper.min.js"></script>
        <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    </head>

    <body style="background: lightgray">

        <div class="container mt-5 mb-5">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card border-0 shadow-sm rounded">
                        <div class="card-body">
                            <img src="{{ asset('storage/posts/' . $post->image) }}" class="w-100 rounded">
                            <hr>
                            <h3 style="text-align: center; text-decoration: underline" class="mb-5">
                                {{ $post->judul }}
                            </h3>
                            <h6>Publisher</h6>
                            <p>
                                {{ $post->user->profile->nama }}
                            </p>
                            <hr>
                            <h6>Kategori</h6>
                            <p>
                                {{ $post->category->kategori }}
                            </p>
                            <hr>
                            <h6>Jumlah</h6>
                            <p>
                                {{ $post->jumlah }}
                            </p>
                            <hr>
                            <h6>Deskripsi</h6>
                            <p>
                                {{ $post->deskripsi }}
                            </p>
                            <hr>
                            <h6>Dibuat pada</h6>
                            <p>
                                {{ $post->created_at }}
                            </p>
                            <hr>
                            <h6>Perubahan terakhir</h6>
                            <p>
                                {{ $post->updated_at }}
                            </p>
                            <hr>
                            <div style="text-align: center" class="mt-5">
                                <a href="{{ asset('storage/posts/' . $post->file_buku) }}"
                                    class="btn btn-success btn-md mx-5" target="_blank">Download</a>
                                <a href="{{ route('exportpdf', ['id' => $post->id]) }}" class="btn btn-md btn-primary">
                                    to pdf
                                </a>
                                <a href="/posts" class="btn btn-danger btn-md mx-5">Kembali</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>

    </html>
