<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lpj;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LpjFolderController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'parent_id' => 'nullable|integer|exists:lpj,id',
            'nama_folder' => 'required|string|max:255',
        ], [
            'nama_folder.required' => 'Nama folder wajib diisi.',
        ]);

        $parent = isset($validated['parent_id']) ? Lpj::findOrFail($validated['parent_id']) : null;

        if ($parent && !$parent->is_folder) {
            return back()->with('ERR', 'Folder hanya bisa dibuat di dalam folder.');
        }

        $this->authorizeFolder($parent);

        Lpj::create([
            'parent_id' => $parent?->id,
            'is_folder' => true,
            // Folder di level paling atas hanya ada di menu Bidang Bidang
            'modul' => $parent ? null : 'bidang',
            'icon' => 'fa-solid fa-folder',
            'nama_program' => $validated['nama_folder'],
            'nama_kegiatan' => $validated['nama_folder'],
            'volume' => '',
            'jumlah_harga_satuan' => 0,
            'jumlah_harga' => 0,
        ]);

        return back()->with('OK', 'Folder berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $folder = Lpj::folders()->findOrFail($id);
        $this->authorizeFolder($folder);

        $validated = $request->validate([
            'nama_folder' => 'required|string|max:255',
        ], [
            'nama_folder.required' => 'Nama folder wajib diisi.',
        ]);

        $folder->update([
            'nama_program' => $validated['nama_folder'],
            'nama_kegiatan' => $validated['nama_folder'],
        ]);

        return back()->with('OK', 'Nama folder berhasil diubah.');
    }

    public function destroy($id)
    {
        $folder = Lpj::folders()->findOrFail($id);
        $this->authorizeFolder($folder);

        if ($folder->modul === 'sekretariat') {
            return back()->with('ERR', 'Folder utama Sekretariat tidak bisa dihapus.');
        }

        if ($folder->children()->exists()) {
            return back()->with('ERR', 'Folder masih berisi folder atau LPJ. Kosongkan folder terlebih dahulu.');
        }

        $folder->delete();

        return back()->with('OK', 'Folder berhasil dihapus.');
    }

    private function authorizeFolder(?Lpj $folder): void
    {
        $root = $folder?->rootAncestor();
        $permission = $root && $root->modul === 'sekretariat' ? 'laporan-lpj-sekretariat' : 'laporan-lpj-bidang';

        abort_unless(Auth::user()->can($permission), 403);
    }
}
