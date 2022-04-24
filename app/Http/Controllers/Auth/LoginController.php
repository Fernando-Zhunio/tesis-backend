<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
// use Illuminate\Support\Facades\Request;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

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

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function authenticated(Request $request, $user)
    {
        if(!$user->hasRole('super-admin') && !$user->hasRole('admin')) {
            return $this->logout($request);
        }
    }

    protected function validateLogin(Request $request)
    {
        $request->validate([
            $this->username() => 'required|string',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();
        if(!$user) {
            throw ValidationException::withMessages([
                'email' => ['El email no existe']
            ]);
        } else {
            if (Hash::check($request->password, $user->password)) {;
                if(!$user->hasRole('super-admin') && !$user->hasRole('admin')) {
                    throw ValidationException::withMessages([
                        'email' => ['Este usuario no tiene permisos para ingresar']
                    ]);
                }
            } else {
                throw ValidationException::withMessages([
                    'password' => ['La contraseña no es correcta']
                ]);
            }
        }
    }
}
