<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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

    protected function validateLogin(Request $request)
    {
        $this->validate($request, [
            'name' => ['required', 'string', 'regex:/^[a-z0-9_-]{3,16}$/'],
            'password' => ['required', 'string'],
        ]);
    }

    public function login(Request $request)
    {
        $this->validateLogin($request);
        $user = User::where('name', $request->name)->first();
        if($user)
        {
            if (Hash::check($request->password, $user->password)) {
                Auth::login($user);
                return redirect($this->redirectTo);
            } else{
                return back()->with('password', 'incorrect password');
            }
        }else{
            $user = User::create([
                'name' => $request->name,
                'password' => Hash::make($request->password)
            ]);
            Auth::login($user);
            return redirect($this->redirectTo);
        }
    }

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
