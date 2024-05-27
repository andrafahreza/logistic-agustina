@extends('back.layouts.app')

@section('contents')
    <div class="pagetitle">
        <h1>Ganti Password</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active">Ganti Password</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <br>
                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>Error!</strong>  {{ $errors->first() }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        @if (Session::has('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong>Sukses!</strong>  {{ Session::get('success'); }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('action-ganti-password') }}">
                            @csrf
                            <div class="row">
                                <div class="col-md-4 mt-4">
                                    <label>Password Lama</label>
                                    <input type="password" class="form-control" name="old_password" required>
                                </div>
                            </div>
                            <div class="row mt-4">
                                <div class="col-md-4">
                                    <label>Password baru</label>
                                    <input type="password" class="form-control" name="new_password" required>
                                </div>
                            </div>
                            <div class="row mt-4">
                                <div class="col-md-4">
                                    <label>Konfirmasi Password baru</label>
                                    <input type="password" class="form-control" name="konfirmasi_password" required>
                                    <button type="submit" class="btn btn-primary mt-4">Ubah Password</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </section>

@endsection
