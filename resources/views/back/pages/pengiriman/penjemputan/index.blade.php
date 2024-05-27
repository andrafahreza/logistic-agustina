@extends('back.layouts.app')

@section('contents')
    <div class="pagetitle">
        <h1>Penjemputan Barang</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item">Pengiriman</li>
                <li class="breadcrumb-item active">Pengelola Penjemputan Barang</li>
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
                                    <th>Nama Kurir</th>
                                    <th>Alamat Penjemputan</th>
                                    <th>Status</th>
                                    <th>Bukti Penjemputan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item->nama_kurir }}</td>
                                        <td>{{ $item->alamat_penjemputan }}</td>
                                        <td>
                                            @if ($item->status == "proses")
                                                <span class="badge bg-warning">{{ $item->status }}</span>
                                            @elseif ($item->status == "gagal")
                                                <span class="badge bg-danger">{{ $item->status }}</span> <br>
                                                ket: {{ $item->keterangan }}
                                            @else
                                                <span class="badge bg-success">{{ $item->status }}</span>
                                            @endif

                                        </td>
                                        <td>
                                            @if ($item->bukti_penjemputan)
                                                <a href="{{ asset($item->bukti_penjemputan) }}" target="_blank">
                                                    <img src="{{ asset($item->bukti_penjemputan) }}" width="200">
                                                </a>
                                            @else
                                                <span class="badge bg-secondary">Belum upload</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($item->status == "proses")
                                                <button type="button" class="btn btn-warning" onclick="upload({{ $item->id }})">Upload Bukti</button>
                                                <button type="button" class="btn btn-warning" onclick="edit({{ $item->id }})">Edit</button>
                                                <button type="button" class="btn btn-danger" onclick="batal({{ $item->id }})">Batalkan</button>
                                                <button type="button" class="btn btn-danger" onclick="hapus({{ $item->id }})">Hapus</button>
                                            @endif
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
                <form action="{{ route('simpan-penjemputan') }}" method="POST" id="formTambah">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Simpan Data</h5>
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
                                <label>Nama Kurir</label>
                                <input class="form-control" id="nama_kurir" type="text" name="nama_kurir" required>
                            </div>
                            <div class="col-md-12 mt-4">
                                <label>Alamat penjemputan</label>
                                <textarea class="form-control" id="alamat_penjemputan" name="alamat_penjemputan" required></textarea>
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
                <form action="{{ route('hapus-penjemputan') }}" method="POST" id="formTHapus">
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

    <div class="modal fade" id="batal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="{{ route('batal-penjemputan') }}" method="POST" id="formTBatal">
                    @csrf
                    <input type="hidden" name="id" id="idBatal">
                    <div class="modal-header">
                        <h5 class="modal-title">Batalkan penjemputan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <label>Keterangan Pembatalan</label>
                                <textarea class="form-control" name="keterangan" required></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-danger">Batalkan</button>
                    </div>
                </form>
            </div>
        </div>
    </div><!-- End Large Modal-->

    <div class="modal fade" id="upload" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="{{ route('upload-penjemputan') }}" method="POST" id="formTUpload" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" id="idUpload">
                    <div class="modal-header">
                        <h5 class="modal-title">Upload Bukti</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <label>Upload File Bukti</label>
                                <input type="file" name="bukti_penjemputan" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-success">Upload</button>
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
            $('#formTambah').attr("action", "{{ route('simpan-penjemputan') }}")
        });

        function edit(id) {
            var url = "{{ route('data-penjemputan') }}" + "/" + id;
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
                        $('#formTambah').attr("action", "{{ route('simpan-penjemputan') }}" + "/" + data.id);
                        $('#nama_kurir').val(data.nama_kurir);
                        $('#alamat_penjemputan').val(data.alamat_penjemputan);
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

        function batal(id) {
            $('#idBatal').val(id);
            $('#batal').modal('toggle');
        }

        function upload(id) {
            $('#idUpload').val(id);
            $('#upload').modal('toggle');
        }
    </script>
@endpush
