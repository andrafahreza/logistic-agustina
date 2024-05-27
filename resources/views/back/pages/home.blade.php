@extends('back.layouts.app')

@section('contents')
    <div class="pagetitle">
        <h1>Dashboard</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="row">
            @if ($user->level->nama_level == "admin" || $user->level->nama_level == "keuangan" || $user->level->nama_level == "kepala_perusahaan")
                <div class="col-xxl-4 col-xl-12">
                    <div class="card info-card customers-card">
                        <div class="card-body">
                            <h5 class="card-title">Total Pesanan </h5>

                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-people"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>{{ number_format($pesanan->count()) }}</h6>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            @endif
        </div>
    </section>
@endsection
