@extends('layouts.app')
@section('pageTitle', 'Detail Pelatih')
@section('mainSection', 'Konfigurasi')
@section('subSection', 'Pelatih')
@section('currentSection', 'Detail Pelatih')

@section('content')
<style>
    .profile-card {
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        border: none;
    }

    .card-title-section {
        font-size: 1.25rem;
        font-weight: 600;
        color: #333;
        margin-bottom: 1.5rem;
    }

    .info-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem 0;
        border-bottom: 1px solid #f0f0f0;
    }

    .info-row:last-child {
        border-bottom: none;
    }

    .info-label {
        color: #6c757d;
        width: 25%;
    }

    .info-value {
        color: #212529;
        font-weight: 500;
        text-align: left;
        flex-grow: 1;
    }

    .info-action a {
        color: #0d6efd;
        text-decoration: none;
        font-size: 0.9rem;
    }

    .info-action i {
        background-color: #e7f1ff;
        padding: 5px;
        border-radius: 50%;
        color: #0d6efd;
    }

    .availability-badge {
        background-color: #d1e7dd;
        color: #0f5132;
        padding: 0.25em 0.6em;
        border-radius: 8px;
        font-size: 0.85em;
        font-weight: 600;
    }

    .profile-avatar-container {
        position: relative;
    }

    .profile-avatar {
        width: 90px;
        height: 90px;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid #fff;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .achievement-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 1rem;
    }

    .achievement-table th, .achievement-table td {
        padding: 1rem;
        border-bottom: 1px solid #f0f0f0;
        text-align: left;
        vertical-align: middle;
    }

    .achievement-table thead th {
        background: #f8f9fa;
        color: #6c757d;
        font-weight: 600;
    }

    .achievement-table tbody tr:last-child td {
        border-bottom: none;
    }

    .achievement-text {
        font-weight: 600;
        display: block;
    }

    .achievement-year {
        font-size: 0.9em;
        color: #6c757d;
    }

    .achievement-icon {
        font-size: 1.5rem;
        margin-right: 1rem;
    }

    .icon-gold { color: #ffd700; }
    .icon-silver { color: #c0c0c0; }
    .icon-bronze { color: #cd7f32; }

    .pagination-container {
        display: flex;
        justify-content: flex-end;
        margin-top: 1.5rem;
    }

</style>

<div class="container mt-4">
    <div class="card profile-card">
        <div class="card-body p-4">

            {{-- Personal Info Section --}}
            <h4 class="card-title-section">Profil Pelatih</h4>

            <div class="info-row">
                <div class="info-label">Foto</div>
                <div class="info-value d-flex justify-content-between align-items-center">
                    <span>150x150px JPEG, PNG Image</span>
                    <div class="profile-avatar-container">
                        @if ($pelatih->foto)
                            <img src="{{ Storage::url($pelatih->foto) }}" class="profile-avatar" alt="Foto Profil">
                        @else
                            <div class="profile-avatar bg-secondary text-white d-flex align-items-center justify-content-center">
                                <span style="font-size: 2rem;">{{ strtoupper(substr($pelatih->nama, 0, 1)) }}</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            @php
                $profileData = [
                    'Nama' => $pelatih->nama,
                    'Cabor' => $pelatih->cabor,
                    'Email' => $pelatih->email ?? '-',
                    'Ketersediaan' => '<span class="availability-badge">Tersedia sekarang</span>',
                    'No Telepon' => $pelatih->no_telepon ?? '-',
                    'Tempat Lahir' => $pelatih->tempat_lahir,
                    'Tanggal Lahir' => \Carbon\Carbon::parse($pelatih->tanggal_lahir)->format('d M Y'),
                    'Kelamin' => $pelatih->kelamin,
                    'Alamat' => $pelatih->alamat,
                ];
            @endphp

            @foreach($profileData as $label => $value)
            <div class="info-row">
                <div class="info-label">{{ $label }}</div>
                <div class="info-value">
                    {!! $value ?: 'Belum ada data yang tercantum' !!}
                </div>
                <div class="info-action">
                    @if ($label === 'Alamat' && !$value)
                        <a href="{{ route('admin.konfigurasi.pelatih.edit', $pelatih->id) }}">tambah</a>
                    @elseif ($label !== 'Ketersediaan')
                        <a href="{{ route('admin.konfigurasi.pelatih.edit', $pelatih->id) }}"><i class="fas fa-external-link-alt"></i></a>
                    @endif
                </div>
            </div>
            @endforeach

            <hr class="my-5">

            <h4 class="card-title-section d-flex justify-content-between align-items-center">
                Informasi Kejuaraan
                <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#addPrestasiModal">
                    <i class="fas fa-plus me-1"></i> Tambah
                </button>
            </h4>

            <table class="achievement-table">
                <thead>
                    <tr>
                        <th style="width: 5%;">No</th>
                        <th>Prestasi Kejuaraan</th>
                        <th style="width: 20%;">Tempat Lomba</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pelatih->prestasis as $index => $p)
                        @php
                            $text = strtolower($p->nama_prestasi);
                            $icon = 'fa-medal';
                            $colorClass = '';
                            if (str_contains($text, 'juara 1') || str_contains($text, 'emas')) {
                                $icon = 'fa-trophy';
                                $colorClass = 'icon-gold';
                            } elseif (str_contains($text, 'juara 2') || str_contains($text, 'perak')) {
                                $icon = 'fa-trophy';
                                $colorClass = 'icon-silver';
                            } elseif (str_contains($text, 'juara 3') || str_contains($text, 'perunggu')) {
                                $icon = 'fa-trophy';
                                $colorClass = 'icon-bronze';
                            }
                        @endphp
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <i class="fas {{ $icon }} achievement-icon {{ $colorClass }}"></i>
                                    <div>
                                        <span class="achievement-text">{{ $p->nama_prestasi }}</span>
                                        <span class="achievement-year">{{ $p->tahun }}</span>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $p->tempat }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center py-4 text-muted">Belum ada data pencapaian.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Modal Tambah Prestasi -->
            <div class="modal fade" id="addPrestasiModal" tabindex="-1" aria-labelledby="addPrestasiModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <form action="{{ route('admin.konfigurasi.pelatih.prestasi.store', $pelatih->id) }}" method="POST" class="modal-content">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="addPrestasiModalLabel">Tambah Prestasi</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="nama_prestasi" class="form-label">Nama Prestasi</label>
                                <input type="text" name="nama_prestasi" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="tahun" class="form-label">Tahun</label>
                                <input type="number" name="tahun" class="form-control" required min="1900" max="{{ now()->year }}">
                            </div>
                            <div class="mb-3">
                                <label for="tempat" class="form-label">Tempat Lomba</label>
                                <input type="text" name="tempat" class="form-control" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="pagination-container">
                <nav aria-label="Achievement pagination">
                    <ul class="pagination">
                        <li class="page-item disabled"><a class="page-link" href="#">&larr;</a></li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item"><a class="page-link" href="#">4</a></li>
                        <li class="page-item"><a class="page-link" href="#">5</a></li>
                        <li class="page-item"><a class="page-link" href="#">&rarr;</a></li>
                    </ul>
                </nav>
            </div>

        </div>
    </div>

    {{-- Action Buttons --}}
    <div class="text-center mt-4">
        <a href="{{ route('admin.konfigurasi.pelatih.index') }}" class="btn btn-secondary px-4">
            <i class="fas fa-arrow-left me-1"></i> Kembali
        </a>
        <a href="{{ route('admin.konfigurasi.pelatih.edit', $pelatih->id) }}" class="btn btn-primary px-4">
            <i class="fas fa-edit me-1"></i> Edit Profil
        </a>
    </div>

</div>
@endsection
