{{-- resources/views/admin/prestasi/index.blade.php --}}
@extends('layouts.app')

@section('pageTitle', 'Manajemen Prestasi')
@section('mainSection', 'Konfigurasi')
@section('mainSectionUrl', route('admin.konfigurasi.atlet.index'))
@section('subSection', 'Prestasi')
@section('currentSection', 'Daftar Prestasi')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">Daftar Prestasi</h5>
        <a href="{{ route('admin.konfigurasi.prestasi.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus"></i> Tambah Prestasi
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th>Nama</th>
                        <th>Jenis Kelamin</th>
                        <th>Prestasi</th>
                        <th>Cabor</th>
                        <th>Tingkat</th>
                        <th>Tempat & Tahun</th>
                        <th>Medali</th>
                        <th width="15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($prestasis as $key => $prestasi)
                    <tr>
                        <td>{{ $prestasis->firstItem() + $key }}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                @if(($prestasi->subject->foto_atlet ?? $prestasi->subject->foto_pelatih ?? null))
                                <img src="{{ asset('storage/' . ($prestasi->subject->foto_atlet ?? $prestasi->subject->foto_pelatih)) }}"
                                     alt="{{ $prestasi->subject->nama }}"
                                     class="rounded-circle me-2" width="40" height="40">
                                @else
                                <div class="rounded-circle bg-light me-2 d-flex align-items-center justify-content-center"
                                     style="width: 40px; height: 40px;">
                                    <i class="fas fa-user text-muted"></i>
                                </div>
                                @endif
                                <div>
                                    <strong>{{ $prestasi->subject->nama }}</strong><br>
                                    <small class="text-muted">
                                        {{ class_basename($prestasi->subject_type) }}
                                    </small>
                                </div>
                            </div>
                        </td>
                        <td>
                            @if($prestasi->subject_type === 'App\Models\Atlet')
                                {{ $prestasi->subject->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}
                            @elseif($prestasi->subject_type === 'App\Models\Pelatih')
                                {{ $prestasi->subject->kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}
                            @endif
                        </td>
                        <td>{{ $prestasi->nama_prestasi }}</td>
                        <td>
                            @if($prestasi->subject->cabangOlahraga)
                                {{ $prestasi->subject->cabangOlahraga->nama_cabor }}
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>{{ $prestasi->tingkat }}</td>
                        <td>
                            {{ $prestasi->tempat }}<br>
                            <small class="text-muted">{{ $prestasi->tahun }}</small>
                        </td>
                        <td>
                            @php
                                $medalClass = '';
                                switch($prestasi->medali) {
                                    case 'Emas':
                                        $medalClass = 'text-warning';
                                        break;
                                    case 'Perak':
                                        $medalClass = 'text-secondary';
                                        break;
                                    case 'Perunggu':
                                        $medalClass = 'text-danger';
                                        break;
                                    default:
                                        $medalClass = 'text-primary';
                                }
                            @endphp
                            <span class="{{ $medalClass }}">
                                <i class="fas fa-medal me-1"></i> {{ $prestasi->medali }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('admin.konfigurasi.prestasi.edit', $prestasi->id) }}"
                               class="btn btn-sm btn-warning" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.konfigurasi.prestasi.destroy', $prestasi->id) }}"
                                  method="POST" class="d-inline"
                                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center">Belum ada data prestasi</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3">
            {{ $prestasis->links() }}
        </div>
    </div>
</div>
@endsection
