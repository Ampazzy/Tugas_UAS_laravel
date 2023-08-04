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

    <nav class="navbar navbar-expand-lg bg-info">
        <div class="container-fluid">
            <a class="navbar-brand mx-5" href="#" style="font-size: 32px"><b>Perpustakaan</b></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 nav-underline">
                    <li class="nav-item">
                        <a class="nav-link" href="/posts" style="font-size: 24px">Buku</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/categories" style="font-size: 24px">Kategori</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link link-light active" aria-current="page" href="/mypost"
                            style="font-size: 24px">Postinganku</a>
                    </li>
                </ul>
                <div class="dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                        aria-expanded="false" style="font-size: 24px">
                        {{ auth()->user()->name }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li> <a href="{{ route('profiles.index') }}" class="dropdown-item">Profile</a>
                        </li>
                        @can('admin')
                            <li><a href="{{ route('categories.create') }}" class="dropdown-item">Tambah kategori</a></li>
                        @endcan
                        <li><a href="{{ route('posts.create') }}" class="dropdown-item">Tambah buku</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li class="text-center">
                            <form action="/logout" method="POST">
                                @csrf
                                <button type="submit" class="btn-unstyled text-danger"
                                    style="border: none">Logout</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card border-0 shadow-sm rounded">
                    <div class="card-body">

                        <div class="row justify-content-center mb-3">
                            <div class="col-md-6" style="width: 30%">
                                <div class="input-group mb-3">
                                    <select class="form-select" name="search" id="searchSelect">
                                        <option value="">Semua kategori</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->kategori }}">
                                                {{ $category->kategori }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <table class="table table-bordered">
                            <thead class="text-center">
                                <tr>
                                    <th scope="col">Cover</th>
                                    <th scope="col">Judul</th>
                                    <th scope="col">Kategori</th>
                                    <th scope="col">Jumlah</th>

                                    @can('admin')
                                        <th scope="col"></th>
                                    @endcan

                                </tr>
                            </thead>
                            <tbody class="text-center">

                                @php
                                    $user = auth()->user();
                                    $posts = $user->post;
                                    
                                @endphp

                                @forelse ($posts as $post)
                                    <tr class="category-row">
                                        <td class="text-center">
                                            <img src="{{ asset('/storage/posts/' . $post->image) }}" class="rounded"
                                                style="width: 150px">
                                        </td>
                                        <td
                                            style="word-break: break-word;
                                        max-width: 125px;">
                                            {{ $post->judul }}</td>
                                        <td>{{ $post->category->kategori }}</td>
                                        <td>{{ $post->jumlah }}</td>

                                        <td class="text-center">
                                            <form onsubmit="return confirm('Apakah Anda Yakin ?');"
                                                action="{{ route('mypost.destroy', $post->id) }}" method="POST">
                                                <a href="{{ route('mypost.show', $post->id) }}"
                                                    class="btn btn-sm btn-dark">Detail</a>
                                                <a href="{{ route('mypost.edit', $post->id) }}"
                                                    class="btn btn-sm btn-primary">Edit</a>
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <div class="alert alert-danger">
                                        Kamu tidak memiliki postingan.
                                    </div>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        //message with toastr
        @if (session()->has('success'))

            toastr.success('{{ session('success') }}', 'BERHASIL!');
        @elseif (session()->has('error'))

            toastr.error('{{ session('error') }}', 'GAGAL!');
        @endif
    </script>

    <script>
        // Get the select element
        const searchSelect = document.getElementById('searchSelect');
        const categoryRows = document.querySelectorAll('.category-row');
        const emptyAlert = document.getElementById('emptyAlert');

        // Add event listener to trigger search on change
        searchSelect.addEventListener('change', function() {
            const selectedValue = this.value;
            let isDataAvailable = false; // Flag to check if data is available after filtering

            categoryRows.forEach(row => {
                const categoryCell = row.querySelector(
                    'td:nth-child(3)'); // Assuming category cell is the third column
                const category = categoryCell.textContent.toLowerCase();
                const match = category.includes(selectedValue.toLowerCase());

                if (match) {
                    row.style.display = '';
                    isDataAvailable = true; // Data is available after filtering
                } else {
                    row.style.display = 'none';
                }
            });

            // Show or hide the empty alert based on the data availability
            if (isDataAvailable) {
                emptyAlert.style.display = 'none';
            } else {
                emptyAlert.style.display = 'block';
            }
        });
    </script>

</body>

</html>
