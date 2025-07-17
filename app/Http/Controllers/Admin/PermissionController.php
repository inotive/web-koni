<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $db = Permission::latest()->get();
        $view = [
            'title' => 'Permission',
            'data' => $db,
        ];

        return view('admin.permission.index', $view);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $permissionTersedia = Permission::where('name', $request->name)->first();

        if ($permissionTersedia !== null) {
            $notifikasi = array(
                'pesan' => "Nama Permission Sudah Terpakai!",
                'alert' => "error"
            );
            return redirect()->back()->with($notifikasi);
        }
        Permission::create([
            'name' => $request->name,
            'guard_name' => 'web',
            'group' => $request->group,
            'display_name' => $request->display_name,
        ]);

        $notifikasi = array(
            'pesan' => "Berhasil Tambah Data!",
            'alert' => "success"
        );
        return redirect()->route('admin.hak-akses.permission.index')->with($notifikasi);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Permission $permission)
    {
        $permissionTersedia = Permission::where('name', $request->name)
                ->where('id', '!=', $permission->id)
                ->first();

            if ($permissionTersedia !== null) {
                $notifikasi = array(
                    'pesan' => "Nama Permission Sudah Terpakai!",
                    'alert' => "error"
                );
                return redirect()->back()->with($notifikasi);
            }
            $permission->update([
                'name' => $request->name,
                'guard_name' => 'web',
                'group' => $request->group,
                'display_name' => $request->display_name,
            ]);

            $notifikasi = array(
                'pesan' => "Berhasil Ubah Data!",
                'alert' => "success"
            );
            return redirect()->route('admin.hak-akses.permission.index')->with($notifikasi);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Permission $permission)
    {
        $notifikasi = array(
            'pesan' => "Berhasil Hapus Data!",
            'alert' => "success"
        );
        return redirect()->route('admin.hak-akses.permission.index')->with($notifikasi);
    }
}
