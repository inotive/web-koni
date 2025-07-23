@extends('layouts.app')

@section('title', 'Detail Cabang Olahraga')
@section('breadcrumb-title', 'Detail Cabang Olahraga')
@section('breadcrumb-items')
    <li><a href="{{ route('admin.konfigurasi.cabang-olahraga.index') }}" class="text-orange hover:underline">Cabang Olahraga</a></li>
    <li>/</li>
    <li class="text-gray-400">Detail</li>
@endsection

@section('content')
<div class="container-fluid-limited mb-6">
    <div class="bg-white p-6 rounded shadow-sm">

        <!-- INFORMASI CABANG OLAHRAGA DALAM TABEL -->
        <div class="overflow-x-auto mb-6">
            <h2 class="text-lg font-semibold mb-4">Informasi Cabang Olahraga</h2>
            <table class="min-w-full divide-y divide-gray-200 text-sm text-left border">
                <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                    <tr>
                        <th class="px-4 py-3">Nama Cabang</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3">Ketua Penanggung Jawab</th>
                        <th class="px-4 py-3">Tanggal Pembentukan</th>
                        <th class="px-4 py-3">Jumlah Atlet</th>
                        <th class="px-4 py-3">Jumlah Pelatih</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr>
                        <td class="px-4 py-2">{{ $item->nama_cabor }}</td>
                        <td class="px-4 py-2">{{ $item->status }}</td>
                        <td class="px-4 py-2">{{ $item->ketua_penanggung_jawab }}</td>
                        <td class="px-4 py-2">{{ $item->tanggal_pembentukan }}</td>
                        <td class="px-4 py-2">{{ $item->jumlah_atlet }}</td>
                        <td class="px-4 py-2">{{ $item->jumlah_pelatih }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- TOMBOL NAVIGASI -->
        <div class="flex justify-end mb-4">
            <div class="inline-flex rounded-md shadow-sm" role="group">
                <button id="tab-atlet"
                    onclick="switchTab('atlet')"
                    class="tab-btn px-4 py-2 text-sm font-medium text-white bg-orange-500 border border-orange-600 rounded-l-md hover:bg-orange-600">
                    Informasi Atlet
                </button>
                <button id="tab-pelatih"
                    onclick="switchTab('pelatih')"
                    class="tab-btn px-4 py-2 text-sm font-medium text-orange-600 bg-white border border-orange-600 rounded-r-md hover:bg-orange-50">
                    Informasi Pelatih
                </button>
            </div>
        </div>

        <!-- TABEL ATLET -->
<div id="content-atlet" class="tab-content block">

   <div class="overflow-x-auto max-w-none bg-white rounded-lg shadow">
    <table class="w-full divide-y divide-gray-200 text-sm text-left border">
        <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
            <tr>
                <th class="px-4 py-3">No</th>
                <th class="px-4 py-3 whitespace-nowrap">Foto Atlet</th>
                <th class="px-4 py-3 whitespace-nowrap">Nama Atlet</th>
                <th class="px-4 py-3 whitespace-nowrap">Tempat & Tanggal Lahir</th>
                <th class="px-4 py-3 whitespace-nowrap">Alamat Domisili</th>
                <th class="px-4 py-3">Kelamin</th>
                <th class="px-4 py-3">Usia</th>
                <th class="px-4 py-3 whitespace-nowrap">Prestasi Terbaru</th>
                <th class="px-4 py-3">No Telepon</th>
                <th class="px-4 py-3">Email</th>
                <th class="px-4 py-3">Aksi</th>
            </tr>
        </thead>

            <tbody class="bg-white divide-y divide-gray-200">
                @php
    $dummyAtlets = [
        [
            'foto' => 'atlet1.jpg',
            'nama' => 'Dimas Pratama',
            'tempat_lahir' => 'Bandung',
            'tanggal_lahir' => '2005-06-21',
            'alamat_domisili' => 'Jl. Merdeka No. 10, Bandung',
            'jenis_kelamin' => 'Laki-laki',
            'prestasi_terbaru' => 'Juara 1 Kejurnas 2023',
            'no_telepon' => '081234567890',
            'email' => 'dimas.pratama@example.com',
        ],
        [
            'foto' => 'atlet2.jpg',
            'nama' => 'Rani Putri',
            'tempat_lahir' => 'Jakarta',
            'tanggal_lahir' => '2007-03-14',
            'alamat_domisili' => 'Jl. Kemang Timur No. 25, Jakarta',
            'jenis_kelamin' => 'Perempuan',
            'prestasi_terbaru' => 'Medali Perak PON 2024',
            'no_telepon' => '082345678901',
            'email' => 'rani.putri@example.com',
        ]
    ];
@endphp

@forelse ($dummyAtlets as $index => $atlet)
<tr>
    <td class="px-4 py-2">{{ $index + 1 }}</td>
    <td class="px-4 py-2">
        <img src="{{ asset('storage/' . $atlet['foto']) }}" alt="Foto" class="h-12 w-12 object-cover rounded-full">
    </td>
    <td class="px-4 py-2">{{ $atlet['nama'] }}</td>
    <td class="px-4 py-2">{{ $atlet['tempat_lahir'] }}, {{ \Carbon\Carbon::parse($atlet['tanggal_lahir'])->translatedFormat('d F Y') }}</td>
    <td class="px-4 py-2">{{ $atlet['alamat_domisili'] }}</td>
    <td class="px-4 py-2">{{ $atlet['jenis_kelamin'] }}</td>
    <td class="px-4 py-2">{{ \Carbon\Carbon::parse($atlet['tanggal_lahir'])->age }} tahun</td>
    <td class="px-4 py-2">{{ $atlet['prestasi_terbaru'] }}</td>
    <td class="px-4 py-2">{{ $atlet['no_telepon'] }}</td>
    <td class="px-4 py-2">{{ $atlet['email'] }}</td>
    <td class="px-4 py-2">
        <a href="#" class="text-blue-600 hover:underline">Lihat Profil</a>
    </td>
</tr>
@empty
<tr>
    <td colspan="11" class="px-4 py-4 italic text-gray-500">Belum ada atlet</td>
</tr>
@endforelse


        <!-- TABEL PELATIH -->
<div id="content-pelatih" class="tab-content mt-8 hidden">

    <div class="overflow-x-auto bg-white rounded-lg shadow">
        <table class="min-w-full divide-y divide-gray-200 text-sm text-left border">
            <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                <tr>
                    <th class="px-4 py-3">No</th>
                    <th class="px-4 py-3">Foto Pelatih</th>
                    <th class="px-4 py-3">Nama Pelatih</th>
                    <th class="px-4 py-3">Tempat & Tanggal Lahir</th>
                    <th class="px-4 py-3">Alamat Domisili</th>
                    <th class="px-4 py-3">Kelamin</th>
                    <th class="px-4 py-3">Usia</th>
                    <th class="px-4 py-3">Prestasi Terbaru</th>
                    <th class="px-4 py-3">No Telepon</th>
                    <th class="px-4 py-3">Email</th>
                    <th class="px-4 py-3">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($item->pelatihs as $index => $pelatih)
                    <tr>
                        <td class="px-4 py-2">{{ $index + 1 }}</td>
                        <td class="px-4 py-2">
                            <img src="{{ asset('storage/' . $pelatih->foto) }}" alt="Foto" class="h-12 w-12 object-cover rounded-full">
                        </td>
                        <td class="px-4 py-2">{{ $pelatih->nama }}</td>
                        <td class="px-4 py-2">{{ $pelatih->tempat_lahir }}, {{ \Carbon\Carbon::parse($pelatih->tanggal_lahir)->translatedFormat('d F Y') }}</td>
                        <td class="px-4 py-2">{{ $pelatih->alamat_domisili }}</td>
                        <td class="px-4 py-2">{{ ucfirst($pelatih->jenis_kelamin) }}</td>
                        <td class="px-4 py-2">{{ \Carbon\Carbon::parse($pelatih->tanggal_lahir)->age }} tahun</td>
                        <td class="px-4 py-2">{{ $pelatih->prestasi_terbaru }}</td>
                        <td class="px-4 py-2">{{ $pelatih->no_telepon }}</td>
                        <td class="px-4 py-2">{{ $pelatih->email }}</td>
                        <td class="px-4 py-2">
                            <a href="{{ route('admin.pelatih.show', $pelatih->id) }}" class="text-blue-600 hover:underline">Lihat Profil</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="11" class="px-4 py-4 italic text-gray-500">Belum ada pelatih</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>


@push('stack-script')
<script>
    function switchTab(tab) {
        const tabs = ['atlet', 'pelatih'];

        tabs.forEach(t => {
            document.getElementById('content-' + t).classList.add('hidden');
            document.getElementById('tab-' + t).classList.remove('bg-orange-500', 'text-white');
            document.getElementById('tab-' + t).classList.add('bg-white', 'text-orange-600');
        });

        document.getElementById('content-' + tab).classList.remove('hidden');
        document.getElementById('tab-' + tab).classList.remove('bg-white', 'text-orange-600');
        document.getElementById('tab-' + tab).classList.add('bg-orange-500', 'text-white');
    }

    // ✅ Tambahkan baris ini
    document.addEventListener('DOMContentLoaded', function () {
        switchTab('atlet');
    });
</script>
@endpush
