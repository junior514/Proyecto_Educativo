<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

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

    public function login(Request $request){

        $credentials = $this->validate(request(), [
            'nroDoc' => 'required|string|max:15',
            'password' => 'required|string'
        ]);

        $remember = $request->filled('remember');

        if (Auth::attempt($credentials, $remember)) {
            if (auth()->user()->estUse == 'ACTIVO') {
                // if (auth()->user()->tipUse == 'LABORATORIO') {
                //     return redirect()->route('laboratorio_covid19.index');
                // }else{
                    return redirect()->route('grupo.index');
                // }

            }else{
                Auth::logout();
                return redirect('/')->with('flash','Su cuenta se encuentra INACTIVA, por favor COMUNIQUESE con el ADMINISTRADOR!');
            }
        }

        if (Auth::guard('web_estudiante')->attempt($credentials, $remember)) {
            return redirect()->route('grupo_estudiante.index');
        }

        if (Auth::guard('web_docente')->attempt($credentials, $remember)) {
            return redirect()->route('grupo_docente.index');
        }

        return back()
            ->withErrors(['nroDoc' => trans('auth.failed')])
            ->withInput(request(['nroDoc']));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('login');
    }
}
