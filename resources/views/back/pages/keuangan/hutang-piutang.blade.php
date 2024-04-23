@extends('back.layouts.app')

@section('contents')
    <div class="pagetitle">
        <h1>Data Pembayaran Ekspedisi</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item">Pengiriman</li>
                <li class="breadcrumb-item active">Hutang & Piutang</li>
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
                                    <th>#ID Data Ekspedisi</th>
                                    <th>Nama Barang</th>
                                    <th>File Pengiriman</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $item)
                                    @php
                                        $status = \App\Models\StatusPesanan::where('data_ekspedisi_id', $item->data_ekspedisi->id)->latest()->first();
                                    @endphp

                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item->data_ekspedisi_id }}</td>
                                        <td>{{ $item->data_ekspedisi->nama_barang }}</td>
                                        <td><a href="{{ asset("images/".$item->data_ekspedisi->file_surat_pengiriman) }}" target="_blank">Lihat File</a></td>
                                        <td>
                                            @if ($item->status == "process")
                                                <span class="badge bg-warning">Belum Dibayar</span>
                                            @else
                                                <span class="badge bg-success">Lunas</span>
                                            @endif
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-secondary" onclick="detail({{ $item->data_ekspedisi->id }})">Detail</button>

                                            @if ($item->status == "process")
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
                <form action="{{ route('simpan-pembayaran-ekspedisi') }}" method="POST" id="formTambah">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Data Pembayaran</h5>
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
                                <label>Data Ekspedisi</label>
                                <select class="form-control" name="id" required>
                                    <option value="">Pilih Data Ekspedisi</option>
                                    @foreach ($dataTambah as $item)
                                        <option value="{{ $item->id }}">No AWB: {{ $item->no_awb }}</option>
                                    @endforeach
                                </select>
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

    <div class="modal fade" id="detail" tabindex="-1">
        <div class="modal-dialog modal-xl">
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
                        <div class="col-md-12">
                            <span><b>Status : </b></span> <span id="status">Menunggu Antrian</span> <br>
                            <span><b>No Awb : </b></span> <span id="no_awb">-</span> <br>
                            <span><b>Biaya : </b></span> <span id="biaya">-</span>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-md-4">
                            <span><b>Nama Barang : </b></span> <span id="nama_barang"></span>
                        </div>
                        <div class="col-md-4">
                            <span><b>Jumlah Barang : </b></span> <span id="jumlah_barang"></span>
                        </div>
                        <div class="col-md-4">
                            <span><b>Volume Barang : </b></span> <span id="volume"></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mt-4">
                            <span><b>Nama Penerima : </b></span> <span id="nama_penerima"></span>
                        </div>
                        <div class="col-md-4 mt-4">
                            <span><b>Alamat Asal : </b></span> <span id="alamat_asal"></span>
                        </div>
                        <div class="col-md-4 mt-4">
                            <span><b>Alamat Penerima : </b></span> <span id="alamat_penerima"></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mt-4">
                            <span><b>Kendaraan : </b> </span> <span id="kendaraan">-</span>
                        </div>
                        <div class="col-md-4 mt-4">
                            <span><b>Supir : </b></span> <span id="supir"></span>
                        </div>
                        <div class="col-md-4 mt-4">
                            <span><b>Note : </b></span> <span id="note"></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mt-4">
                            <span><b>Provinsi : </b> </span> <span id="provinsi">-</span>
                        </div>
                        <div class="col-md-4 mt-4">
                            <span><b>Kecamatan : </b></span> <span id="kecamatan"></span>
                        </div>
                        <div class="col-md-4 mt-4">
                            <span><b>Kelurahan : </b></span> <span id="kelurahan"></span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div><!-- End Large Modal-->

    <div class="modal fade" id="hapus" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="{{ route('hapus-pembayaran-ekspedisi') }}" method="POST" id="formTHapus">
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
        function detail(id) {
            var url = "{{ route('data-request-pengiriman') }}" + "/" + id;

            $.ajax({
                type: "get",
                url: url,
                dataType: "JSON",
                success: function(response) {
                    if (response.alert == '1') {
                        $('#detail').modal('toggle');
                        $('#error-message').addClass('d-none');

                        const data = response.data;
                        console.log(data);
                        $('#status').text(data.status);
                        $('#no_awb').text(data.no_awb);
                        $('#biaya').text(data.biaya);
                        $('#nama_barang').text(data.nama_barang);
                        $('#jumlah_barang').text(data.jumlah_barang);
                        $('#volume').text(data.volume);
                        $('#nama_penerima').text(data.nama_penerima);
                        $('#alamat_asal').text(data.alamat_asal);
                        $('#alamat_penerima').text(data.alamat_penerima);
                        $('#kendaraan').text(data.kendaraan);
                        $('#supir').text(data.supir);
                        $('#note').text(data.note);
                        $('#provinsi').text(data.provinsi);
                        $('#kecamatan').text(data.kecamatan);
                        $('#kelurahan').text(data.kelurahan);
                    } else {
                        $('#detail').modal('toggle');
                        $('#error-message').removeClass('d-none');
                    }
                },
                error: function(response) {
                    $('#detail').modal('toggle');
                    $('#error-message').removeClass('d-none');
                }
            });
        }

        function hapus(id) {
            $('#idHapus').val(id);
            $('#hapus').modal('toggle');
        }
    </script>
@endpush
