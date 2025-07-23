@extends('layouts.app')

@push('stack-css')
    <!-- Kalau Ada Plugin Tambahan -->
@endpush

@section('breadcrumb-title')
    <h1 class="d-flex flex-column text-dark fw-bold fs-3 mb-0">Halaman Dashboard</h1>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item text-gray-600">Dashboard</li>
@endsection

@section('content')
<!--begin::Content wrapper-->
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <!--begin::Container-->
    <div class="container-xxl" id="kt_content_container">
        <!--begin::Card-->
        <div class="card">
            <div class="card-body">
                <h3>Selamat Datang di Dashboard</h3>
                <p>Ini adalah halaman utama admin.</p>
                <!-- Kamu bisa tambah statistik, chart, dsb -->
            </div>
        </div>
        <!--end::Card-->
    </div>
    <!--end::Container-->
</div>
<!--end::Content wrapper-->
@endsection

@push('stack-script')
    <!-- Tambahkan JS jika ada -->
@endpush
