@extends('back.layouts.app')

@section('contents')
    <div class="pagetitle">
        <h1>Pengelola Pengiriman Barang</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item">Pengiriman</li>
                <li class="breadcrumb-item active">Pengelola Pengiriman Barang</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <a href="{{ route('tambah-request-pengiriman') }}" class="btn btn-primary mt-4">+ Tambah</a>
                        <br><br>
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
                                    <th>No Resi</th>
                                    <th>Nama Barang</th>
                                    <th>Note</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $item)
                                    @php
                                        $status = \App\Models\StatusPesanan::where('data_ekspedisi_id', $item->id)->latest()->first();
                                    @endphp

                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item->no_resi }}</td>
                                        <td>{{ $item->nama_barang }}</td>
                                        <td>{{ $item->note }}</td>
                                        <td>
                                            @if (empty($status))
                                                <span class="badge bg-warning">Menunggu pengiriman</span>
                                            @else
                                                @if ($status->status == "process")
                                                    <span class="badge bg-warning">Proses</span>
                                                    <br>
                                                    <span>Note: {{ $status->note }}</span>
                                                @elseif ($status->status == "denied")
                                                    <span class="badge bg-danger">Dibatalkan</span>
                                                    <br>
                                                    <span>Note: {{ $status->note }}</span>
                                                @else
                                                    <span class="badge bg-success">Selesai</span>
                                                @endif
                                            @endif
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-secondary" onclick="detail({{ $item->id }})">Detail</button>
                                            @if (empty($status->status) || $status->status == "process")
                                                <button type="button" class="btn btn-warning" onclick="update({{ $item->id }})">Update Pesanan</button>
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
                            <span><b>No Resi : </b></span> <span id="no_resi">-</span> <br>
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
                            <span><b>Cabang : </b> </span> <span id="cabang">-</span>
                        </div>
                        <div class="col-md-4 mt-4">
                            <span><b>Supir : </b></span> <span id="supir"></span>
                        </div>
                        <div class="col-md-4 mt-4">
                            <span><b>Note : </b></span> <span id="note"></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mt-4">
                            <br>
                            <table class="table table-striped text-center" id="statusPesanan">
                                <thead>
                                    <th>Waktu</th>
                                    <th>Keterangan</th>
                                    <th>Status</th>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="update" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="{{ route('update-pesanan') }}" method="POST" id="formTambah">
                    @csrf
                    <input type="hidden" name="data_ekspedisi_id" id="data_ekspedisi_id">
                    <div class="modal-header">
                        <h5 class="modal-title">Update Pesanan</h5>
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
                                <label>Status</label>
                                <select class="form-control" name="status" required>
                                    <option value="">Pilih Status</option>
                                    <option value="process">Proses</option>
                                    <option value="denied">Dibatalkan</option>
                                    <option value="done">Selesai</option>
                                </select>
                            </div>
                            <div class="col-md-12 mt-4">
                                <label>Keterangan</label>
                                <textarea class="form-control" name="note" required></textarea>
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
                        $('#no_resi').text(data.no_resi);
                        $('#biaya').text(data.biaya);
                        $('#nama_barang').text(data.nama_barang);
                        $('#jumlah_barang').text(data.jumlah_barang);
                        $('#volume').text(data.volume);
                        $('#nama_penerima').text(data.nama_penerima);
                        $('#alamat_asal').text(data.alamat_asal);
                        $('#alamat_penerima').text(data.alamat_penerima);
                        $('#supir').text(data.supir);
                        $('#note').text(data.note);
                        $('#cabang').text(data.cabang);

                        $('#statusPesanan tbody').empty();
                        $('#statusPesanan').append(data.htmlStatus);
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

        function update(id) {
            $('#data_ekspedisi_id').val(id);
            $('#update').modal('toggle');
        }
    </script>
@endpush
