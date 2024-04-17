@extends('back.layouts.app')

@section('contents')
    <div class="pagetitle">
        <h1>Biaya</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item">Master Data</li>
                <li class="breadcrumb-item active">Biaya</li>
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
                                    <th>Kelurahan</th>
                                    <th>Biaya</th>
                                    <th>Service</th>
                                    <th>Minimal Berat</th>
                                    <th>Pengiriman</th>
                                    <th>Jangka Waktu</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item->district->name }}</td>
                                        <td>Rp. {{ number_format((int)$item->biaya) }}</td>
                                        <td>{{ $item->service }}</td>
                                        <td>{{ $item->minimal_berat }}</td>
                                        <td>{{ $item->pengiriman }}</td>
                                        <td>{{ $item->jangka_waktu }}</td>
                                        <td>
                                            <button type="button" class="btn btn-warning" onclick="edit({{ $item->id }})">Edit</button>
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
                <form action="{{ route('simpan-biaya') }}" method="POST" id="formTambah">
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
                            <div class="col-md-4">
                                <label>Provinsi</label>
                                <select class="form-control" name="provinsi" id="provinsi">
                                    <option>Pilih Provinsi</option>
                                    @foreach ($province as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label>Kecamatan</label>
                                <select class="form-control" name="kecamatan" id="kecamatan"></select>
                            </div>
                            <div class="col-md-4">
                                <label>Kelurahan</label>
                                <select class="form-control" name="district_id" id="kelurahan"></select>
                            </div>
                            <div class="col-md-12 mt-4">
                                <label>Biaya</label>
                                <input class="form-control" id="biaya" type="number" name="biaya" required>
                            </div>
                            <div class="col-md-12 mt-4">
                                <label>Service</label>
                                <input class="form-control" id="service" name="service" required>
                            </div>
                            <div class="col-md-12 mt-4">
                                <label>Minimal Berat</label>
                                <input type="text" class="form-control" id="minimal_berat" name="minimal_berat" required>
                            </div>
                            <div class="col-md-12 mt-4">
                                <label>Pengiriman</label>
                                <input type="text" class="form-control" id="pengiriman" name="pengiriman" required>
                            </div>
                            <div class="col-md-12 mt-4">
                                <label>Jangka Waktu</label>
                                <input type="text" class="form-control" id="jangka_waktu" name="jangka_waktu" required>
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
                <form action="{{ route('hapus-biaya') }}" method="POST" id="formTHapus">
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
            $('#formTambah').attr("action", "{{ route('simpan-biaya') }}")
        });

        function edit(id) {
            var url = "{{ route('data-biaya') }}" + "/" + id;
            $.ajax({
                type: "get",
                url: url,
                dataType: "JSON",
                success: function(response) {
                    $('#kecamatan')
                        .find('option')
                        .remove()
                        .end()
                        .append('<option value="">Pilih Kecamatan</option>')
                        .val('');

                    $('#kelurahan')
                        .find('option')
                        .remove()
                        .end()
                        .append('<option value="">Pilih kelurahan</option>')
                        .val('');

                    if (response.alert == '1') {
                        $('#tambah').modal('toggle');
                        $('#error-message').addClass('d-none');

                        const data = response.data;
                        $('#formTambah')[0].reset();
                        $('#formTambah').attr("action", "{{ route('simpan-biaya') }}" + "/" + data.id);
                        $('#biaya').val(data.biaya);
                        $('#service').val(data.service);
                        $('#minimal_berat').val(data.minimal_berat);
                        $('#pengiriman').val(data.pengiriman);
                        $('#jangka_waktu').val(data.jangka_waktu);
                    } else {
                        $('#error-message').removeClass('d-none');
                    }
                },
                error: function(response) {
                    $('#error-message').removeClass('d-none');
                }
            });
        }

        $('#provinsi').on('change', function () {
            var url = "{{ route('get-kecamatan') }}" + "/" + $(this).val();
            $.ajax({
                type: "get",
                url: url,
                dataType: "JSON",
                success: function(response) {
                    $('#kecamatan')
                        .find('option')
                        .remove()
                        .end()
                        .append('<option value="">Pilih Kecamatan</option>')
                        .val('');

                    $('#kelurahan')
                        .find('option')
                        .remove()
                        .end()
                        .append('<option value="">Pilih kelurahan</option>')
                        .val('');

                    if (response.alert == '1') {
                        $.each(response.data, function (i, item) {
                            $('#kecamatan').append($('<option>', {
                                value: item.id,
                                text : item.name
                            }));
                        });
                    } else {
                        alert("Gagal mengambil data kecamatan, silahkan coba lagi");
                    }
                },
                error: function(response) {
                    alert("Gagal mengambil data kecamatan, silahkan coba lagi");
                }
            });
        });

        $('#kecamatan').on('change', function () {
            var url = "{{ route('get-kelurahan') }}" + "/" + $(this).val();
            $.ajax({
                type: "get",
                url: url,
                dataType: "JSON",
                success: function(response) {
                    $('#kelurahan')
                        .find('option')
                        .remove()
                        .end()
                        .append('<option value="">Pilih kelurahan</option>')
                        .val('');

                    if (response.alert == '1') {
                        $.each(response.data, function (i, item) {
                            $('#kelurahan').append($('<option>', {
                                value: item.id,
                                text : item.name
                            }));
                        });
                    } else {
                        alert("Gagal mengambil data kelurahan, silahkan coba lagi");
                    }
                },
                error: function(response) {
                    alert("Gagal mengambil data kelurahan, silahkan coba lagi");
                }
            });
        });

        function hapus(id) {
            $('#idHapus').val(id);
            $('#hapus').modal('toggle');
        }
    </script>
@endpush
