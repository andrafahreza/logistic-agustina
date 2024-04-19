@extends('back.layouts.app')

@section('contents')
    <div class="pagetitle">
        <h1>Vendor</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item">Master Data</li>
                <li class="breadcrumb-item">Pengguna</li>
                <li class="breadcrumb-item active">Vendor</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <button type="button" class="btn btn-primary mt-4" data-bs-toggle="modal" data-bs-target="#tambah" id="btnTambah">+ Tambah</button> <br><br>
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
                                    <th>Id Pengguna</th>
                                    <th>Kode vendor</th>
                                    <th>No Ktp</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item->user->id }}</td>
                                        <td>{{ $item->kode }}</td>
                                        <td>{{ $item->no_ktp }}</td>
                                        <td>
                                            @if ($item->user->status == "active")
                                                <span class="badge bg-success">Aktif</span>
                                            @else
                                                <span class="badge bg-danger">Tidak Aktif</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a class="btn btn-secondary" href="{{ route('list-kendaraan', ['id' => $item->id]) }}">List Kendaraan</a>
                                            <button type="button" class="btn btn-warning" onclick="edit({{ $item->id }})">Edit</button>

                                            @if ($item->user->status == "active")
                                                <button type="button" class="btn btn-danger" onclick="nonactive({{ $item->id }})">Nonaktifkan</button>
                                            @else
                                                <button type="button" class="btn btn-success" onclick="active({{ $item->id }})">Aktifkan</button>
                                            @endif
                                            <button type="button" class="btn btn-danger" onclick="hapus({{ $item->id }})">Hapus</button>
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

    <div class="modal fade" id="tambah" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="{{ route('simpan-vendor') }}" method="POST" id="formTambah">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Data</h5>
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
                                <label>Kode vendor</label>
                                <input class="form-control" id="kode" type="number" name="kode" required>
                            </div>
                            <div class="col-md-12 mt-4">
                                <label>No Ktp</label>
                                <input type="number" class="form-control" id="no_ktp" name="no_ktp" required>
                            </div>
                            <div class="col-md-12 mt-4">
                                <label>Username Vendor</label>
                                <input type="text" class="form-control" id="username" name="username" required>
                            </div>
                            <div class="col-md-12 mt-4">
                                <label>Alamat</label>
                                <input type="text" class="form-control" id="alamat" name="alamat" required>
                            </div>
                            <div class="col-md-12 mt-4">
                                <label>Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="col-md-12 mt-4">
                                <label>No Telepon</label>
                                <input type="text" class="form-control" id="no_telepon" name="no_telepon" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div><!-- End Large Modal-->

    <div class="modal fade" id="hapus" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="{{ route('hapus-vendor') }}" method="POST" id="formTHapus">
                    @csrf
                    <input type="hidden" name="id" id="idHapus">
                    <div class="modal-header">
                        <h5 class="modal-title">Hapus Data</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Yakin ingin menghapus data ini?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </div>
                </form>
            </div>
        </div>
    </div><!-- End Large Modal-->

    <div class="modal fade" id="nonActive" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="{{ route('nonactive-vendor') }}" method="POST" id="formTnonactive">
                    @csrf
                    <input type="hidden" name="id" id="idNonActive">
                    <div class="modal-header">
                        <h5 class="modal-title">Nonaktifkan Vendor</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Yakin ingin menonaktifkan vendor ini?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-danger">Nonaktifkan</button>
                    </div>
                </form>
            </div>
        </div>
    </div><!-- End Large Modal-->

    <div class="modal fade" id="active" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="{{ route('active-vendor') }}" method="POST" id="formActive">
                    @csrf
                    <input type="hidden" name="id" id="idActive">
                    <div class="modal-header">
                        <h5 class="modal-title">Aktifkan Vendor</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Yakin ingin mengaktifkan vendor ini?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-success">Aktifkan</button>
                    </div>
                </form>
            </div>
        </div>
    </div><!-- End Large Modal-->
@endsection

@push("scripts")
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <script>
        $('#btnTambah').click(function() {
            $('#error-message').addClass('d-none');
            $('#formTambah')[0].reset();
            $('#formTambah').attr("action", "{{ route('simpan-vendor') }}")
        });

        function edit(id) {
            var url = "{{ route('data-vendor') }}" + "/" + id;
            $.ajax({
                type: "get",
                url: url,
                dataType: "JSON",
                success: function(response) {
                    if (response.alert == '1') {
                        $('#tambah').modal('toggle');
                        $('#error-message').addClass('d-none');

                        const data = response.data;
                        $('#formTambah')[0].reset();
                        $('#formTambah').attr("action", "{{ route('simpan-vendor') }}" + "/" + data.id);
                        $('#kode').val(data.kode);
                        $('#no_ktp').val(data.no_ktp);
                        $('#username').val(data.username);
                        $('#alamat').val(data.alamat);
                        $('#email').val(data.email);
                        $('#no_telepon').val(data.no_telepon);
                    } else {
                        $('#error-message').removeClass('d-none');
                    }
                },
                error: function(response) {
                    $('#error-message').removeClass('d-none');
                }
            });
        }

        function hapus(id) {
            $('#idHapus').val(id);
            $('#hapus').modal('toggle');
        }

        function nonactive(id) {
            $('#idNonActive').val(id);
            $('#nonActive').modal('toggle');
        }

        function active(id) {
            $('#idActive').val(id);
            $('#active').modal('toggle');
        }
    </script>
@endpush
