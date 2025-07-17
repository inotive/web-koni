<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;
    protected $name;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }


    public function show(){

        if (Auth::check()) {
            return redirect()->route('admin.dashboard.index');
        }

        $data = [
            'title' => 'Login'
        ];
        return view('auth.login', $data);
    }

    public function login(Request $request){
        $input = $request->all();
        $validator = Validator::make($request->all(), [
           'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // $fieldType = filter_var($request->email, FILTER_VALIDATE_EMAIL) ? 'username' : 'name';
        if (auth()->attempt(['email' => $input['email'], 'password' => $input['password']])) {
            return redirect()->route('admin.dashboard.index');
        } else {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors([
                    'message' => 'Username atau Password tidak cocok!',
                ]);
        }
    }

    public function logout(Request $request)
    {
        auth()->logout();

        if ($response = $this->loggedOut($request)) {
            return $response;
        }

        return redirect()->route('login');
    }
}
