@extends('back.layouts.app')

@section('contents')
    <div class="pagetitle">
        <h1>Kendaraan</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item">Pesanan</li>
                <li class="breadcrumb-item active">Kendaraan</li>
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
                                    <th>Kode Vendor</th>
                                    <th>No Kendaraan</th>
                                    <th>Jenis Kendaraan</th>
                                    <th>Merk</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item->vendor->kode }}</td>
                                        <td>{{ $item->no_kendaraan }}</td>
                                        <td>{{ $item->jenis_kendaraan }}</td>
                                        <td>{{ $item->merk }}</td>
                                        <td>
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
                <form action="{{ route('simpan-kendaraan') }}" method="POST" id="formTambah">
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
                                <label>Kode Vendor</label>
                                <select class="form-control" name="vendor_id" required>
                                    <option value="">Pilih Vendor</option>
                                    @foreach ($vendor as $item)
                                        <option value="{{ $item->id }}">{{ $item->kode }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-12 mt-4">
                                <label>No Kendaraan</label>
                                <input type="text" class="form-control" id="no_kendaraan" name="no_kendaraan" required>
                            </div>
                            <div class="col-md-12 mt-4">
                                <label>Jenis Kendaraan</label>
                                <input type="text" class="form-control" id="jenis_kendaraan" name="jenis_kendaraan" required>
                            </div>
                            <div class="col-md-12 mt-4">
                                <label>merk</label>
                                <input type="text" class="form-control" id="merk" name="merk" required>
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
                <form action="{{ route('hapus-kendaraan') }}" method="POST" id="formTHapus">
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
@endsection

@push("scripts")
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <script>
        $('#btnTambah').click(function() {
            $('#error-message').addClass('d-none');
            $('#formTambah')[0].reset();
            $('#formTambah').attr("action", "{{ route('simpan-kendaraan') }}")
        });

        function hapus(id) {
            $('#idHapus').val(id);
            $('#hapus').modal('toggle');
        }
    </script>
@endpush
