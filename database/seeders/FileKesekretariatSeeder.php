<?php

namespace Database\Seeders;

use App\Models\FileKesekretariat;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class FileKesekretariatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Pastikan folder documents ada
        if (!Storage::disk('public')->exists('documents')) {
            Storage::disk('public')->makeDirectory('documents');
        }

        // Contoh data dummy
        $dummyFiles = [
            [
                'nama_dokumen' => 'Surat Tugas Rapat',
                'dokumen_file' => 'surat_tugas_rapat.pdf',
            ],
            [
                'nama_dokumen' => 'Notulensi Rapat Bulanan',
                'dokumen_file' => 'notulensi_bulanan.docx',
            ],
            [
                'nama_dokumen' => 'Daftar Hadir Kegiatan',
                'dokumen_file' => 'daftar_hadir.xlsx',
            ],
        ];

        foreach ($dummyFiles as $file) {
            // Salin file dummy ke storage jika belum ada
            $path = 'documents/' . $file['dokumen_file'];
            if (!Storage::disk('public')->exists($path)) {
                Storage::disk('public')->put($path, ''); // file kosong
            }

            // Insert ke database
            FileKesekretariat::create([
                'nama_dokumen' => $file['nama_dokumen'],
                'dokumen_file' => $file['dokumen_file'],
            ]);
        }
    }
}