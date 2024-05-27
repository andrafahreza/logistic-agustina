@extends('back.layouts.app')

@section('contents')
    <div class="pagetitle">
        <h1>Tambah Pengiriman Barang</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item">Pengiriman</li>
                <li class="breadcrumb-item">pengelola Pengiriman Barang</li>
                <li class="breadcrumb-item active">Tambah Pengiriman Barang</li>
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
                            <h5>Data Penjemputan & Sopir</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12 mt-4">
                                    <label>Penjemputan</label>
                                    <select class="form-control" name="penjemputan_id">
                                        <option value="">Pilih Penjemputan</option>
                                        @foreach ($penjemputan as $item)
                                            <option value="{{ $item->id }}">{{ $item->id }} - {{ $item->alamat_penjemputan }}</option>
                                        @endforeach
                                    </select>
                                    <b>Note: </b>isi jika ada penjemputan barang
                                </div>
                                <div class="col-md-12 mt-4">
                                    <label>Supir <span class="text-danger">*</span></label>
                                    <select class="form-control" name="supir_id" required>
                                        <option value="">Pilih Supir</option>
                                        @foreach ($supir as $item)
                                            <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                        @endforeach
                                    </select>
                                    <br><br><br>
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
                                <div class="col-md-4 mt-4">
                                    <label>Cabang <span class="text-danger">*</span></label>
                                    <select class="form-control" name="cabang" id="cabang" required>
                                        <option>Pilih Cabang</option>
                                        @foreach ($cabang as $item)
                                            <option value="{{ $item->id }}">{{ $item->nama_cabang }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 mt-4">
                                    <label>No Resi <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="no_resi" name="no_resi" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 mt-4">
                                    <label>Biaya <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="biaya" id="biaya" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
        $('#cabang').on('change', function () {
            var value = $('#cabang').val();

            $.ajax({
                type: "get",
                url: "{{ route('cek-biaya') }}" + "/" + value,
                dataType: "JSON",
                success: function(response) {
                    if (response.alert == '1') {
                        $('#detail').modal('toggle');
                        $('#error-message').addClass('d-none');

                        const data = response.data;
                        console.log(data);
                        $('#biaya').val(data);
                    } else {
                        alert("Gagal mengambil data biaya");
                    }
                },
                error: function(response) {
                    alert(response);
                }
            });
        });
    </script>
@endpush
