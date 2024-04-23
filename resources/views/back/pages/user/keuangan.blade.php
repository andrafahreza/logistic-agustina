@extends('back.layouts.app')

@section('contents')
    <div class="pagetitle">
        <h1>Keuangan</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item">Employeed</li>
                <li class="breadcrumb-item active">Keuangan</li>
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
                                    <th>Nama</th>
                                    <th>Username</th>
                                    <th>Alamat</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item->nama }}</td>
                                        <td>{{ $item->username }}</td>
                                        <td>{{ $item->alamat }}</td>
                                        <td>{{ $item->email }}</td>
                                        <td>
                                            @if ($item->status == "active")
                                                <span class="badge bg-success">Aktif</span>
                                            @else
                                                <span class="badge bg-danger">Tidak Aktif</span>
                                            @endif
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-warning" onclick="edit({{ $item->id }})">Edit</button>

                                            @if ($item->status == "active")
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
                <form action="{{ route('simpan-keuangan') }}" method="POST" id="formTambah">
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
                                <label>username</label>
                                <input class="form-control" id="username" type="text" name="username" required>
                            </div>
                            <div class="col-md-12 mt-4" id="passwordForm">
                                <label>Password</label>
                                <input type="password" class="form-control" id="password" name="password">
                            </div>
                            <div class="col-md-12 mt-4">
                                <label>Nama</label>
                                <input type="text" class="form-control" id="nama" name="nama" required>
                            </div>
                            <div class="col-md-12 mt-4">
                                <label>Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="col-md-12 mt-4">
                                <label>No Telepon</label>
                                <input type="text" class="form-control" id="no_telepon" name="no_telepon" required>
                            </div>
                            <div class="col-md-12 mt-4">
                                <label>Jenis Kelamin</label>
                                <select class="form-control" name="jenis_kelamin" id="jenis_kelamin" required>
                                    <option value="l">Laki-Laki</option>
                                    <option value="p">Perempuan</option>
                                </select>
                            </div>
                            <div class="col-md-12 mt-4">
                                <label>Alamat</label>
                                <textarea class="form-control" name="alamat" id="alamat" required></textarea>
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
                <form action="{{ route('hapus-keuangan') }}" method="POST" id="formTHapus">
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
                <form action="{{ route('nonactive-keuangan') }}" method="POST" id="formTnonactive">
                    @csrf
                    <input type="hidden" name="id" id="idNonActive">
                    <div class="modal-header">
                        <h5 class="modal-title">Nonaktifkan keuangan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Yakin ingin menonaktifkan keuangan ini?</p>
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
                <form action="{{ route('active-keuangan') }}" method="POST" id="formActive">
                    @csrf
                    <input type="hidden" name="id" id="idActive">
                    <div class="modal-header">
                        <h5 class="modal-title">Aktifkan keuangan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Yakin ingin mengaktifkan keuangan ini?</p>
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
            $('#passwordForm').removeClass('d-none');
            $('#password').prop('required', true);
            $('#error-message').addClass('d-none');
            $('#formTambah')[0].reset();
            $('#formTambah').attr("action", "{{ route('simpan-keuangan') }}")
        });

        function edit(id) {
            var url = "{{ route('data-keuangan') }}" + "/" + id;
            $.ajax({
                type: "get",
                url: url,
                dataType: "JSON",
                success: function(response) {
                    if (response.alert == '1') {
                        $('#tambah').modal('toggle');
                        $('#error-message').addClass('d-none');
                        $('#passwordForm').addClass('d-none');
                        $('#password').prop('required', false);

                        const data = response.data;
                        $('#formTambah')[0].reset();
                        $('#formTambah').attr("action", "{{ route('simpan-keuangan') }}" + "/" + data.id);
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
