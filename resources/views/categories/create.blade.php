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
            <div class="card border-0 shadow-sm rounded">
                <div class="card-body">
                    <form action="{{ route('categories.store') }}" method="POST" enctype="multipart/form-data">

                        @csrf

                        <h3 class="text-center mb-5 underline">Tambah Buku</h3>

                        <div class="form-group mb-3">
                            <label class="font-weight-bold">Kategori</label>
                            <input type="text" class="form-control @error('category') is-invalid @enderror"
                                name="category" value="{{ old('category') }}">

                            <!-- error message untuk nama -->
                            @error('category')
                                <div class="alert alert-danger mt-2">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="text-center mt-5">
                            <button type="submit" class="btn btn-md btn-primary mx-5">Tambah</button>
                            <a href="/categories" class="btn btn-md btn-danger mx-5">Kembali</a>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
