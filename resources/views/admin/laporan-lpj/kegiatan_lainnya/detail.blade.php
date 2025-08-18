@extends('layouts.app')

@section('pageTitle', 'Detail Laporan LPJ')
@section('mainSection', 'Laporan LPJ')
@section('currentSection', 'Detail Kegiatan')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Detail Laporan LPJ</h4>
            <a href="{{ route('admin.laporan-lpj.kegiatan_lainnya.export', request()->query()) }}" 
               class="btn btn-primary">
                <i class="fas fa-download"></i> Export Data
            </a>
        </div>

        <div class="card-body">
            <table class="table table-bordered table-striped align-middle">
                <thead class="table-light">
                    <tr>
                        <th style="width: 50px;">No</th>
                        <th>Nama Program & Kegiatan</th>
                        <th>Foto Jurnal</th>
                        <th>Dokumen</th>
                        <th>Volume</th>
                        <th>Jml Harga Satuan</th>
                        <th>Jml Harga</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td><strong>{{ $kegiatan->nama_program_kegiatan }}</strong></td>
                        <td>
                            @if($kegiatan->foto_jurnal)
                                <a href="{{ asset('storage/' . $kegiatan->foto_jurnal) }}" target="_blank">
                                    <img src="{{ asset('storage/' . $kegiatan->foto_jurnal) }}" 
                                         class="img-thumbnail"
                                         style="width: 80px; height: 60px; object-fit: cover;">
                                </a>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            @if($kegiatan->dokumen_pendukung)
                                <a href="{{ asset('storage/' . $kegiatan->dokumen_pendukung) }}" target="_blank">
                                    <i class="fas fa-file-pdf text-danger"></i> Lihat Dokumen
                                </a>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>{{ $kegiatan->volume }}</td>
                        <td>Rp {{ number_format($kegiatan->jumlah_harga_satuan, 0, ',', '.') }}</td>
                        <td>Rp {{ number_format($kegiatan->jumlah_harga, 0, ',', '.') }}</td>
                    </tr>
                </tbody>
            </table>

            <div class="mt-4">
                <h5>Keterangan Tambahan</h5>
                <p>{{ $kegiatan->keterangan_tambahan ?? 'Tidak ada keterangan tambahan' }}</p>
            </div>
        </div>
    </div>
</div>
@endsection