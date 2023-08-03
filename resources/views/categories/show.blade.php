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
                        <h6>Username</h6>
                        <p>
                            {{ $post->user->name }}
                        </p>
                        <hr>
                        <h6>Nama</h6>
                        <p>
                            {{ $post->user->profile->nama }}
                        </p>
                        <hr>
                        <h6>Email</h6>
                        <p>
                            {{ $post->user->email }}
                        </p>
                        <hr>
                        <h6>No. Handphone</h6>
                        <p>
                            {{ $post->user->profile->no_hp }}
                        </p>
                        <hr>
                        <h6>Alamat</h6>
                        <p>
                            {{ $post->user->profile->alamat }}
                        </p>
                        <hr>
                        <h6>Dibuat pada</h6>
                        <p>
                            {{ $post->created_at }}
                        </p>
                        <hr>
                        <div style="text-align: center" class="mt-5">
                            <a href="{{ url()->previous() }}" class="btn btn-danger btn-md mx-5">Kembali</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
