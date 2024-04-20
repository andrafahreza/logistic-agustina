@extends('back.layouts.app')

@section('contents')
    <div class="pagetitle">
        <h1>Verifikasi Pelanggan</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active">Verifikasi Pelanggan</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
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
                        <!-- Table with stripped rows -->
                        <table class="table datatable" id="table">
                            <thead>
                                <tr>
                                    <th>#ID</th>
                                    <th>Nama</th>
                                    <th>Nomor Bisnis</th>
                                    <th>Npwp</th>
                                    <th>Jenis Usaha</th>
                                    <th>Alamat</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item->nama }}</td>
                                        <td>{{ $item->pelanggan->nomor_bisnis }}</td>
                                        <td>{{ $item->pelanggan->npwp }}</td>
                                        <td>{{ $item->pelanggan->jenis_usaha }}</td>
                                        <td>{{ $item->pelanggan->alamat }}</td>
                                        <td>
                                            <button type="button" class="btn btn-secondary" onclick="detail({{ $item->id }})">Detail</button>
                                            <button type="button" class="btn btn-success" onclick="verifikasi({{ $item->id }})">Verifikasi</button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <!-- End Table with stripped rows -->
                    </div>
                </div>

            </div>
        </div>
    </section>

    <div class="modal fade" id="detail" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="error-message d-none" id="error-message">
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Error!</strong>  Terjadi kesalahan, silahkan coba lagi
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mt-4">
                            <label>username</label>
                            <input class="form-control" id="username" type="text" name="username" disabled>
                        </div>
                        <div class="col-md-12 mt-4">
                            <label>Nama</label>
                            <input type="text" class="form-control" id="nama" name="nama" disabled>
                        </div>
                        <div class="col-md-12 mt-4">
                            <label>Email</label>
                            <input type="email" class="form-control" id="email" name="email" disabled>
                        </div>
                        <div class="col-md-12 mt-4">
                            <label>No Telepon</label>
                            <input type="text" class="form-control" id="no_telepon" name="no_telepon" disabled>
                        </div>
                        <div class="col-md-12 mt-4">
                            <label>Jenis Kelamin</label>
                            <select class="form-control" name="jenis_kelamin" id="jenis_kelamin" disabled>
                                <option value="l">Laki-Laki</option>
                                <option value="p">Perempuan</option>
                            </select>
                        </div>
                        <div class="col-md-12 mt-4">
                            <label>Alamat</label>
                            <textarea class="form-control" name="alamat" id="alamat" disabled></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div><!-- End Large Modal-->

    <div class="modal fade" id="verifikasi" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="{{ route('verifikasi-pelanggan') }}" method="POST" id="formVerifikasi">
                    @csrf
                    <input type="hidden" name="id" id="idVerifikasi">
                    <div class="modal-header">
                        <h5 class="modal-title">Verifikasi pelanggan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Yakin ingin memverifikasi pelanggan ini?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-success">Verifikasi</button>
                    </div>
                </form>
            </div>
        </div>
    </div><!-- End Large Modal-->
@endsection

@push("scripts")
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <script>
        function detail(id) {
            var url = "{{ route('data-kepala') }}" + "/" + id;
            $.ajax({
                type: "get",
                url: url,
                dataType: "JSON",
                success: function(response) {
                    if (response.alert == '1') {
                        $('#detail').modal('toggle');

                        const data = response.data;
                        $('#username').val(data.username);
                        $('#nama').val(data.nama);
                        $('#email').val(data.email);
                        $('#no_telepon').val(data.no_telepon);
                        $('#jenis_kelamin').val(data.jenis_kelamin);
                        $('#no_telepon').val(data.no_telepon);
                        $('#alamat').val(data.alamat);
                    } else {
                        $('#error-message').removeClass('d-none');
                    }
                },
                error: function(response) {
                    $('#error-message').removeClass('d-none');
                }
            });
        }

        function verifikasi(id) {
            $('#idVerifikasi').val(id);
            $('#verifikasi').modal('toggle');
        }
    </script>
@endpush
