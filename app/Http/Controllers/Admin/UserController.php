<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Helpers\UploadFile;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    use UploadFile;
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $users = User::orderBy('id', 'desc')->paginate($perPage);
        // dd($users);
        $view = [
            'title' => "Manajemen Pengguna",
            'users' => $users,
            'role' => Role::all()
        ];

        return view('admin.user.index', $view);
    }

    public function create()
    {
        $db = User::latest()->get();

        $view = [
            'title' => "Tambah Pengguna",
            'data' => $db,
            'roles' => Role::all()
        ];

        return view('admin.user.create', $view);
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'username' => 'required',
            // 'name' => 'required',
            'password' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg|max:2048'
        ]);
 
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $usernameTersedia = User::where('username', $request->username)->first();

            
        if ($usernameTersedia !== null) {
            return redirect()
                ->back()
                ->with('ERR', 'Username Telah Tepakai!');
        }

        if ($request->role == null) {
            return redirect()
                ->back()
                ->with('ERR', 'Role Tidak Boleh Kosong!');
        }

        
        $data = [
            'email' => $request->email,
            'username' => $request->username,
            'name' => $request->name,
            'status' => "aktif",
            'password' => bcrypt($request->password)
        ];

        if ($request->file('image') !== null) {
            $gambar = $this->storeFile($request->file('image'), 'profile');
            $data['image'] = $gambar;
        }
      

        $user = User::create($data);
        $user->syncRoles([$request->role]);

        if($request->action) {
            return redirect()
                ->back()
                ->with('OK', 'Berhasil menambahkan pengguna!');
        }
        return redirect()
            ->route('admin.manajemen-pengguna.pengguna.index')
            ->with('OK', 'Berhasil menambahkan pengguna!');
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
    public function edit(User $pengguna)
    {
        // $title = 'Pengguna';
        $view = [
            'data' => User::all(),
            'pengguna' => $pengguna,
            'title' => 'Pengguna',
            'role' => Role::all()
        ];
        // dd($user);
        return view('admin.user.edit', $view);
    }

    public function update(Request $request, User $pengguna)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'username' => 'required',
            // 'name' => 'required',
            // 'password' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg|max:2048'
        ]);
 
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }


        $usernameTersedia = User::where('username', $request->username)->where('id', '!=', $pengguna->id)->first();

          
        if ($usernameTersedia !== null) {
            return redirect()
                ->back()
                ->with('ERR', 'Username Telah Terpakai!');
        }

        if (strlen($request->password) > 1 && strlen($request->password) < 6) {
            return redirect()
                ->back()
                ->with('ERR', 'Password Harus Minimal 6 Karakter!');
        }
        $imageProfile = $pengguna->image; 

        if ($request->hasFile('image')) {
            Storage::disk('public')->delete('profile/' . $pengguna->image); 
            $image = $this->storeFile($request->file('image'), 'profile');
            $imageProfile = $image;
        }

        $data = [
            'username' => $request->username,
            'email' => $request->email,
            // 'name' => $request->name,
            'status' => 'aktif',
        ];
        
        if ($request->password !== null) {
            $data['password'] = bcrypt($request->password);
        }
        
        $data['image'] = $imageProfile; 
        
        $pengguna->fill($data);

       
        $pengguna->update();
        $pengguna->syncRoles($request->role);
        return redirect()
            ->route('admin.manajemen-pengguna.pengguna.index')
            ->with('OK', 'Berhasil Ubah Data!');
    }

    public function destroy(User $pengguna){
        Storage::disk('public')->delete('profile/' . $pengguna->image);

        $pengguna->delete();

        return redirect()
            ->back()
            ->with('OK', 'Data pengguna telah dihapus!');
    }
}
