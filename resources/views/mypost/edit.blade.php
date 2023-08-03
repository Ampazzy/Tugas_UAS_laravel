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

        <div class="container mt-5 mb-5" style="width: 50%">
            <div class="row">
                <div class="col-md-12">
                    <div class="card border-0 shadow-sm rounded">
                        <div class="card-body">
                            <form action="{{ route('mypost.update', $post->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <h3 class="text-center mb-5 underline">Edit Buku</h3>

                                <div class="form-group mb-3">
                                    <label class="font-weight-bold">Nama</label>
                                    <input type="text" class="form-control @error('nama') is-invalid @enderror"
                                        name="nama" value="{{ old('nama', $post->user->profile->nama) }}" readonly>

                                    <!-- error message untuk nama -->
                                    @error('nama')
                                        <div class="alert alert-danger mt-2">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label class="font-weight-bold">Cover Buku (jpeg,jpg,png)</label>
                                    <input type="file" class="form-control @error('image') is-invalid @enderror"
                                        name="image">

                                    <!-- error message untuk judul -->
                                    @error('image')
                                        <div class="alert alert-danger mt-2">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label class="font-weight-bold">Judul</label>
                                    <input type="text" class="form-control @error('judul') is-invalid @enderror"
                                        name="judul" value="{{ old('judul', $post->judul) }}"
                                        placeholder="Masukkan Judul Post">

                                    <!-- error message untuk judul -->
                                    @error('judul')
                                        <div class="alert alert-danger mt-2">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label class="font-weight-bold">Kategori</label>
                                    <select class="form-control @error('category_id') is-invalid @enderror"
                                        name="category_id">
                                        <option value="">Pilih Kategori</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                @if (old('category_id', $category->id) == $category->id) selected @endif>
                                                {{ $category->kategori }}</option>
                                        @endforeach
                                    </select>

                                    <!-- error message untuk category -->
                                    @error('category_id')
                                        <div class="alert alert-danger mt-2">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label class="font-weight-bold">Jumlah</label>
                                    <input type="text" class="form-control @error('jumlah') is-invalid @enderror"
                                        name="jumlah" value="{{ old('jumlah', $post->jumlah) }}"
                                        placeholder="Isi dengan angka!">

                                    <!-- error message untuk jumlah -->
                                    @error('jumlah')
                                        <div class="alert alert-danger mt-2">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label class="font-weight-bold">Deskripsi</label>
                                    <textarea class="form-control @error('deskripsi') is-invalid @enderror" name="deskripsi" rows="5"
                                        placeholder="Masukkan deskripsi">{{ old('deskripsi', $post->deskripsi) }}</textarea>

                                    <!-- error message untuk content -->
                                    @error('deskripsi')
                                        <div class="alert alert-danger mt-2">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label class="font-weight-bold">File Buku (PDF)</label>
                                    <input type="file" class="form-control @error('file_buku') is-invalid @enderror"
                                        name="file_buku">

                                    <!-- error message untuk title -->
                                    @error('file_buku')
                                        <div class="alert alert-danger mt-2">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div style="text-align: center" class="mt-5">
                                    <button type="submit" class="btn btn-md btn-primary mx-5">UPDATE</button>
                                    <a href="/mypost" class="btn btn-md btn-danger mx-5">Back</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </body>

    </html>
