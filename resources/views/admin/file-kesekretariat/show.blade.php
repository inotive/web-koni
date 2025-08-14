@extends('layouts.app')

@section('pageTitle', 'Detail Kegiatan Lainnya')
@section('mainSection', 'Laporan Pertanggungjawaban')
@section('currentSection', 'Kegiatan Lainnya')

@section('content')
<div class="card">
    <!-- Header dengan tombol kembali -->
    <div class="card-header">
        <h3 class="card-title">Detail Kegiatan</h3>
        <div class="card-toolbar">
            <a href="{{ route('admin.laporan-lpj.kegiatan_lainnya.index') }}" 
               class="btn btn-sm btn-light-primary">
                <i class="fas fa-arrow-left me-2"></i> Kembali
            </a>
        </div>
    </div>
    
    <!-- Isi konten detail kegiatan -->
    <div class="card-body">
        <!-- Tampilkan detail kegiatan di sini -->
        <div class="row">
            <div class="col-md-6">
                <p><strong>Nama Kegiatan:</strong> {{ $kegiatan->nama_program_kegiatan }}</p>
                <!-- Tambahkan field lainnya -->
            </div>
        </div>
    </div>
    
    <!-- Footer dengan tombol aksi -->
    <div class="card-footer">
        <a href="{{ route('admin.laporan-lpj.kegiatan_lainnya.edit', $kegiatan->id) }}" 
           class="btn btn-warning">
            <i class="fas fa-edit me-2"></i> Edit
        </a>
        <!-- Tombol delete -->
    </div>
</div>
@endsection