@extends('back.layouts.app')

@section('contents')
    <div class="pagetitle">
        <h1>Request Pengiriman Barang</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item">Pengiriman</li>
                <li class="breadcrumb-item active">Request Pengiriman Barang</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <a href="{{ route('tambah-request-pengiriman') }}" class="btn btn-primary mt-4">+ Tambah</a> <br><br>
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
                                    <th>Nama Barang</th>
                                    <th>Note</th>
                                    <th>File Pengiriman</th>
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
                                        <td>{{ $item->nama_barang }}</td>
                                        <td>{{ $item->note }}</td>
                                        <td><a href="{{ asset("images/".$item->file_surat_pengiriman) }}" target="_blank">Lihat File</a></td>
                                        <td>
                                            @if (empty($status))
                                                <span class="badge bg-warning">Mengunggu Antrian</span>
                                            @else
                                                @if ($status->status == "process")
                                                    <span class="badge bg-warning">Proses</span>
                                                    <span>Note: {{ $status->note }}</span>
                                                @elseif ($status->status == "denied")
                                                    <span class="badge bg-danger">Ditolak</span>
                                                    <span>Note: {{ $status->note }}</span>
                                                @else
                                                    <span class="badge bg-success">Selesai</span>
                                                @endif
                                            @endif
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-secondary" onclick="detail({{ $item->id }})">Detail</button>

                                            @if (empty($status))
                                                <button type="button" class="btn btn-warning" onclick="edit({{ $item->id }})">Edit</button>
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
        function hapus(id) {
            $('#idHapus').val(id);
            $('#hapus').modal('toggle');
        }
    </script>
@endpush
