@extends('layouts.app')

@section('pageTitle', 'Detail Kegiatan Lainnya')
@section('mainSection', 'Laporan Pertanggungjawaban')
@section('currentSection', 'Kegiatan Lainnya')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Detail Kegiatan</h3>
        <div class="card-toolbar">
            <a href="{{ route('admin.laporan-lpj.kegiatan_lainnya.index') }}" class="btn btn-light-primary">
                <i class="fas fa-arrow-left me-2"></i> Kembali
            </a>
        </div>
    </div>
    
    <div class="card-body">
        <div class="row mb-7">
            <div class="col-md-6">
                <label class="fw-bold text-muted">Nama Kegiatan</label>
                <div class="fw-bolder fs-5">{{ $kegiatanLainnya->nama_program_kegiatan }}</div>
            </div>
            <div class="col-md-6">
                <label class="fw-bold text-muted">Jenis Kegiatan</label>
                <div class="fw-bolder fs-5">{{ $kegiatanLainnya->jenis_kegiatan }}</div>
            </div>
        </div>

        <div class="row mb-7">
            <div class="col-md-6">
                <label class="fw-bold text-muted">Tanggal Kegiatan</label>
                <div class="fw-bolder fs-5">{{ $kegiatanLainnya->tanggal_kegiatan->format('d F Y') }}</div>
            </div>
            <div class="col-md-6">
                <label class="fw-bold text-muted">Volume</label>
                <div class="fw-bolder fs-5">{{ $kegiatanLainnya->volume }}</div>
            </div>
        </div>

        @if($kegiatanLainnya->foto_jurnal)
        <div class="row mb-7">
            <div class="col-12">
                <label class="fw-bold text-muted">Foto Jurnal</label>
                <div>
                    <a href="{{ asset('storage/'.$kegiatanLainnya->foto_jurnal) }}" 
                       target="_blank" class="btn btn-light-primary">
                        <i class="fas fa-eye me-2"></i> Lihat Foto
                    </a>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection