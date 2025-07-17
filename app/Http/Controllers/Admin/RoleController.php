<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\PermissionRegistrar;

class RoleController extends Controller
{
    protected $role;
    protected $user;

    public function __construct(Role $role, User $user)
    {
        $this->role = $role;
        $this->user = $user;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $db = Role::with('assignedUsers')->latest()->get();
        $view = [
            'title' => 'Manajemen Role',
            'data' => $db,
        ];

        return view('admin.role.index', $view);
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
        $userTersedia = Role::where('name', $request->name)->first();

        if ($userTersedia !== null) {
            return redirect()->back()->with('ERR', 'Role Sudah Ada!');
        }

        Role::create([
            'name' => $request->name,
            'guard_name' => 'web',
        ]);

        return redirect()
            ->back()
            ->with('OK', 'Berhasil Tambah Data Role!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        $permissions = Permission::all();
        // dd($permissions);
        return view('admin.role.setting', compact('permissions', 'role'));
    }
    public function shows(Role $role)
    {
        $user = Auth::user();

        // if (!$user->hasPermissionTo('read-roles')) {
        //     abort(403, 'Unallowed.');
        // }

        $db = $this->role
            ->with('permissions')
            ->withCount(['permissions', 'users as model_has_role_count'])
            ->where('id', $role->id)
            ->first();

        // $dataPermission = DB::table('permissions')
        //     ->select('group', DB::raw('GROUP_CONCAT(name) as names'), DB::raw('GROUP_CONCAT(display_name) as displays'), DB::raw('GROUP_CONCAT(id) as id'), DB::raw('COUNT(*) as permission_count'))
        //     ->groupBy('group')
        //     ->orderByDesc('permission_count')
        //     ->get();

        $dataPermission = $role::all();
        dd($dataPermission);

        $view = [
            'data' => $db,
            'dataPermission' => $dataPermission,
        ];

        return view('admin.role.setting', $view);
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
    public function update(Request $request, Role $role)
    {
        $userTersedia = Role::where('name', $request->name)
            ->where('id', '!=', $role->id)
            ->first();

        if ($userTersedia !== null) {
            return redirect()
                ->back()
                ->with('ERR', 'Nama Role Telah Tepakai!');
        }
        $role->update([
            'name' => $request->name,
            'guard_name' => 'web',
        ]);

        return redirect()
            ->back()
            ->with('OK', 'Berhasil Ubah Data Role!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        if ($role->assignedUsers()->count() > 0) {
            return redirect()
                ->back()
                ->with('ERR', 'Role masih digunakan oleh user dan tidak bisa dihapus.');
        }

        $role->delete();

        return redirect()
            ->back()
            ->with('OK', 'Berhasil Hapus Data Role!');
    }

    public function updatePermissions(Request $request)
    {
        $user = Auth::user();

        // if (!$user->hasPermissionTo('edit-roles')) {
        //     abort(403, 'Unallowed.');
        // }
        if ($request->ajax()) {
            $roleId = $request->input('roleId');
            $selectedPermissions = array_filter(
                array_map('intval', explode(',', $request->input('permissions'))),
                fn($id) => $id > 0
            );
            $role = Role::findOrFail($roleId);

            if ($role) {
                $role->permissions()->sync($selectedPermissions);
                app()[PermissionRegistrar::class]->forgetCachedPermissions();
                return response()->json(['message' => 'Hak akses berhasil diperbarui']);
            } else {
                return response()->json(['message' => 'Hak akses gagal diperbarui'], 404);
            }
        } else {
            abort(404);
        }
    }
}
