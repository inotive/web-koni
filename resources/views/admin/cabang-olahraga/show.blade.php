@extends('layouts.app')
@section('pageTitle', 'Cabang Olahraga')
@section('mainSection', 'Konfigurasi')
@section('mainSectionUrl', route('admin.konfigurasi.cabang-olahraga.index'))
@section('subSection', 'Cabang Olahraga')
@section('subSectionUrl', route('admin.konfigurasi.cabang-olahraga.index'))
@section('currentSection', 'Detail Cabang Olahraga')

@section('breadcrumb-title')
    {{-- Halaman Cabang Olahraga --}}
@endsection

@section('content')
<div class="container-fluid">
    <!-- Header Section -->
    <div class="card mb-6">
        <div class="card-header border-0 pt-6">
            <div class="card-title">
                <h2 class="fw-bold text-dark">
                    <i class="ki-duotone ki-sport fs-2 text-primary me-2">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                    Cabang Olahraga: {{ $cabor->nama_cabor ?? 'Nama Cabang Olahraga' }}
                </h2>
            </div>
            <div class="card-toolbar">
                <a href="{{ route('admin.konfigurasi.cabang-olahraga.index') }}" 
                   class="btn btn-sm btn-light-primary">
                    <i class="ki-duotone ki-arrow-left fs-2">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                    Kembali
                </a>
            </div>
        </div>
    </div>

    

    <!-- Tabs Card -->
    <div class="card">
        <div class="card-header border-0">
            <div class="card-title">
                <div class="nav nav-tabs nav-line-tabs nav-stretch fs-6 border-0">
                    <div class="nav-item">
                        <a class="nav-link active fw-bold" data-bs-toggle="tab" href="#kt_tab_pane_atlet">
                            <i class="ki-duotone ki-people fs-2 me-2">
                                <span class="path1"></span>
                                <span class="path2"></span>
                                <span class="path3"></span>
                                <span class="path4"></span>
                                <span class="path5"></span>
                            </i>
                            Informasi Atlet
                            <span class="badge badge-light-primary ms-2">{{ $cabor->atlets->count() ?? 0 }}</span>
                        </a>
                    </div>
                    <div class="nav-item">
                        <a class="nav-link fw-bold" data-bs-toggle="tab" href="#kt_tab_pane_pelatih">
                            <i class="ki-duotone ki-teacher fs-2 me-2">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                            Informasi Pelatih
                            <span class="badge badge-light-success ms-2">{{ $cabor->pelatihs->count() ?? 0 }}</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="tab-content">
                <!-- Tab Pane Atlet -->
                <div class="tab-pane fade show active" id="kt_tab_pane_atlet" role="tabpanel">
                    @if(($cabor->atlets ?? collect())->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-row-dashed table-row-gray-300 gy-7">
                                <thead>
                                    <tr class="fw-semibold fs-6 text-gray-800 border-bottom-2 border-gray-200">
                                        <th class="min-w-50px">No</th>
                                        <th class="min-w-80px">Foto</th>
                                        <th class="min-w-150px">Nama Atlet</th>
                                        <th class="min-w-150px">Tempat & Tanggal Lahir</th>
                                        <th class="min-w-100px">Jenis Kelamin</th>
                                        <th class="min-w-80px">Usia</th>
                                        <th class="min-w-150px">Prestasi Terbaru</th>
                                        <th class="min-w-120px">Kontak</th>
                                        <th class="min-w-80px text-end">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($cabor->atlets as $index => $atlet)
                                    <tr>
                                        <td>
                                            <span class="text-gray-800 fw-bold">{{ $index + 1 }}</span>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @if($atlet->foto)
                                                    <div class="symbol symbol-50px">
                                                        <img src="{{ asset('storage/' . $atlet->foto) }}" 
                                                             alt="Foto {{ $atlet->nama }}" 
                                                             class="rounded object-fit-cover">
                                                    </div>
                                                @else
                                                    <div class="symbol symbol-50px">
                                                        <div class="symbol-label bg-light-primary text-primary">
                                                            <i class="ki-duotone ki-user fs-2">
                                                                <span class="path1"></span>
                                                                <span class="path2"></span>
                                                            </i>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex flex-column">
                                                <span class="text-gray-800 fw-bold mb-1">{{ $atlet->nama ?? '-' }}</span>
                                                <span class="text-muted fs-7">{{ $atlet->alamat_domisili ?? '-' }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="text-gray-800 fw-semibold">
                                                {{ ($atlet->tempat_lahir ?? '-') . ', ' . (isset($atlet->tanggal_lahir) ? \Carbon\Carbon::parse($atlet->tanggal_lahir)->translatedFormat('d F Y') : '-') }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge badge-light-info">{{ ucfirst($atlet->jenis_kelamin ?? '-') }}</span>
                                        </td>
                                        <td>
                                            <span class="text-gray-800 fw-semibold">
                                                {{ isset($atlet->tanggal_lahir) ? \Carbon\Carbon::parse($atlet->tanggal_lahir)->age . ' tahun' : '-' }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="text-gray-600">{{ Str::limit($atlet->prestasi_terbaru ?? '-', 50) }}</span>
                                        </td>
                                        <td>
                                            <div class="d-flex flex-column">
                                                @if($atlet->no_telepon)
                                                    <span class="text-gray-800 fs-7 mb-1">
                                                        <i class="ki-duotone ki-phone fs-6 me-1">
                                                            <span class="path1"></span>
                                                            <span class="path2"></span>
                                                        </i>
                                                        {{ $atlet->no_telepon }}
                                                    </span>
                                                @endif
                                                @if($atlet->email)
                                                    <span class="text-gray-600 fs-7">
                                                        <i class="ki-duotone ki-sms fs-6 me-1">
                                                            <span class="path1"></span>
                                                            <span class="path2"></span>
                                                        </i>
                                                        {{ $atlet->email }}
                                                    </span>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="text-end">
                                            <a href="{{ route('admin.konfigurasi.atlet.show', $atlet->id ?? '#') }}" 
                                               class="btn btn-sm btn-light-primary">
                                                <i class="ki-duotone ki-eye fs-5">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                    <span class="path3"></span>
                                                </i>
                                                Lihat
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="d-flex flex-column flex-center text-center p-10">
                            <img src="{{ asset('assets/media/illustrations/sketchy-1/2.png') }}" alt="" class="mw-400px">
                            <div class="pt-10 pb-10">
                                <h2 class="fs-2 fw-bold text-gray-600">Belum Ada Atlet</h2>
                                <p class="text-gray-400 fs-6 fw-semibold">
                                    Belum ada atlet yang terdaftar untuk cabang olahraga ini.
                                </p>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Tab Pane Pelatih -->
                <div class="tab-pane fade" id="kt_tab_pane_pelatih" role="tabpanel">
                    @if(($cabor->pelatihs ?? collect())->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-row-dashed table-row-gray-300 gy-7">
                                <thead>
                                    <tr class="fw-semibold fs-6 text-gray-800 border-bottom-2 border-gray-200">
                                        <th class="min-w-50px">No</th>
                                        <th class="min-w-80px">Foto</th>
                                        <th class="min-w-150px">Nama Pelatih</th>
                                        <th class="min-w-150px">Tempat & Tanggal Lahir</th>
                                        <th class="min-w-100px">Jenis Kelamin</th>
                                        <th class="min-w-80px">Usia</th>
                                        <th class="min-w-150px">Prestasi/Sertifikasi</th>
                                        <th class="min-w-120px">Kontak</th>
                                        <th class="min-w-80px text-end">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($cabor->pelatihs as $index => $pelatih)
                                    <tr>
                                        <td>
                                            <span class="text-gray-800 fw-bold">{{ $index + 1 }}</span>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @if($pelatih->foto)
                                                    <div class="symbol symbol-50px">
                                                        <img src="{{ asset('storage/' . $pelatih->foto) }}" 
                                                             alt="Foto {{ $pelatih->nama }}" 
                                                             class="rounded object-fit-cover">
                                                    </div>
                                                @else
                                                    <div class="symbol symbol-50px">
                                                        <div class="symbol-label bg-light-success text-success">
                                                            <i class="ki-duotone ki-teacher fs-2">
                                                                <span class="path1"></span>
                                                                <span class="path2"></span>
                                                            </i>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex flex-column">
                                                <span class="text-gray-800 fw-bold mb-1">{{ $pelatih->nama ?? '-' }}</span>
                                                <span class="text-muted fs-7">{{ $pelatih->alamat_domisili ?? '-' }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="text-gray-800 fw-semibold">
                                                {{ ($pelatih->tempat_lahir ?? '-') . ', ' . (isset($pelatih->tanggal_lahir) ? \Carbon\Carbon::parse($pelatih->tanggal_lahir)->translatedFormat('d F Y') : '-') }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge badge-light-info">{{ ucfirst($pelatih->jenis_kelamin ?? '-') }}</span>
                                        </td>
                                        <td>
                                            <span class="text-gray-800 fw-semibold">
                                                {{ isset($pelatih->tanggal_lahir) ? \Carbon\Carbon::parse($pelatih->tanggal_lahir)->age . ' tahun' : '-' }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="text-gray-600">{{ Str::limit($pelatih->prestasi_terbaru ?? '-', 50) }}</span>
                                        </td>
                                        <td>
                                            <div class="d-flex flex-column">
                                                @if($pelatih->no_telepon)
                                                    <span class="text-gray-800 fs-7 mb-1">
                                                        <i class="ki-duotone ki-phone fs-6 me-1">
                                                            <span class="path1"></span>
                                                            <span class="path2"></span>
                                                        </i>
                                                        {{ $pelatih->no_telepon }}
                                                    </span>
                                                @endif
                                                @if($pelatih->email)
                                                    <span class="text-gray-600 fs-7">
                                                        <i class="ki-duotone ki-sms fs-6 me-1">
                                                            <span class="path1"></span>
                                                            <span class="path2"></span>
                                                        </i>
                                                        {{ $pelatih->email }}
                                                    </span>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="text-end">
                                            <a href="{{ route('admin.konfigurasi.pelatih.show', $pelatih->id ?? '#') }}" 
                                               class="btn btn-sm btn-light-success">
                                                <i class="ki-duotone ki-eye fs-5">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                    <span class="path3"></span>
                                                </i>
                                                Lihat
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="d-flex flex-column flex-center text-center p-10">
                            <img src="{{ asset('assets/media/illustrations/sketchy-1/2.png') }}" alt="" class="mw-400px">
                            <div class="pt-10 pb-10">
                                <h2 class="fs-2 fw-bold text-gray-600">Belum Ada Pelatih</h2>
                                <p class="text-gray-400 fs-6 fw-semibold">
                                    Belum ada pelatih yang terdaftar untuk cabang olahraga ini.
                                </p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
$(document).ready(function() {
    // Initialize Bootstrap tabs
    var triggerTabList = [].slice.call(document.querySelectorAll('#myTab a'))
    triggerTabList.forEach(function (triggerEl) {
        var tabTrigger = new bootstrap.Tab(triggerEl)

        triggerEl.addEventListener('click', function (event) {
            event.preventDefault()
            tabTrigger.show()
        })
    })
});
</script>
@endsection