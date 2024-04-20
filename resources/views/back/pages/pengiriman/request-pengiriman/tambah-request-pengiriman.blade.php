@extends('back.layouts.app')

@section('contents')
    <div class="pagetitle">
        <h1>Tambah Request Pengiriman Barang</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item">Pengiriman</li>
                <li class="breadcrumb-item">Request Pengiriman Barang</li>
                <li class="breadcrumb-item active">Tambah Request Pengiriman Barang</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <form action="{{ route('simpan-request-pengiriman') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <section class="section">
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Error!</strong>  {{ $errors->first() }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <div class="row">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h5>Data Barang</h5>
                        </div>
                        <div class="card-body">
                            <input type="hidden" name="id" value="{{ $id }}">
                            <div class="row">
                                <div class="col-md-12 mt-4">
                                    <label>Nama Barang <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="nama_barang"
                                        value="{{ $data != null ? $data->nama_barang : '' }}" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 mt-4">
                                    <label>Jumlah Barang <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" name="jumlah_barang"
                                        value="{{ $data != null ? $data->jumlah_barang : '' }}" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 mt-4">
                                    <label>Volume Barang <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="volume"
                                        value="{{ $data != null ? $data->volume : '' }}" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 mt-4">
                                    <label>Note <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="note"
                                        value="{{ $data != null ? $data->note : '' }}" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h5>Data Pengirim dan Penerima</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12 mt-4">
                                    <label>Nama Pengirim <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="nama_pengirim"
                                        value="{{ $data != null ? $data->nama_pengirim : '' }}" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 mt-4">
                                    <label>Alamat Asal <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="alamat_asal"
                                        value="{{ $data != null ? $data->alamat_asal : '' }}" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 mt-4">
                                    <label>Nama Penerima <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="nama_penerima"
                                        value="{{ $data != null ? $data->nama_penerima : '' }}" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 mt-4">
                                    <label>Alamat Penerima <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="alamat_penerima"
                                        value="{{ $data != null ? $data->alamat_penerima : '' }}" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h5>Biaya</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12 mt-4">
                                    <label>File Surat Pengiriman <span class="text-danger">*</span></label>
                                    <input type="file" class="form-control" name="file_surat" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 mt-4">
                                    <label>Provinsi <span class="text-danger">*</span></label>
                                    <select class="form-control" name="provinsi" id="provinsi" required>
                                        <option>Pilih Provinsi</option>
                                        @foreach ($province as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4 mt-4">
                                    <label>Kecamatan <span class="text-danger">*</span></label>
                                    <select class="form-control" name="kecamatan" id="kecamatan" required></select>
                                </div>
                                <div class="col-md-4 mt-4">
                                    <label>Kelurahan <span class="text-danger">*</span></label>
                                    <select class="form-control" name="district_id" id="kelurahan" required></select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 mt-4">
                                    <label>Biaya <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="biaya" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <center>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </center>
        </div>
    </form>
@endsection

@push("scripts")
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <script>
        $("#biaya").on('keydown paste focus mousedown', function(e){
            if(e.keyCode != 9) // ignore tab
                e.preventDefault();
        });

        $('#provinsi').on('change', function () {
            var url = "{{ route('get-kecamatan') }}" + "/" + $(this).val();
            $('#biaya').val('');

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
            $('#biaya').val('');

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

        $('#kelurahan').on('change', function() {
            var url = "{{ route('cek-biaya') }}" + "/" + $(this).val();
            $('#biaya').val('');

            $.ajax({
                type: "get",
                url: url,
                dataType: "JSON",
                success: function(response) {
                    console.log(response);
                    if (response.alert == '1') {
                        $('#biaya').val(response.data);
                    } else {
                        alert("Mohon maaf, belum ada biaya pada wilayah tersebut");
                    }
                },
                error: function(response) {
                    console.log(response);
                    alert("Gagal mengambil data kelurahan, silahkan coba lagi");
                }
            });
        });
    </script>
@endpush
