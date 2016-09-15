<?php namespace App\Http\Controllers\Auth;

use App\Http\Requests\AuthRequest;
use Auth;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{

    protected $redirectPath = '/home';

    protected $loginPath = '/user/login';

    public function authenticate(AuthRequest $request)
    {
        if (Auth::attempt(['username' => $request->username,
            'password' => $request->password])) {
            return redirect()->intended('home');
        } else{
            
            return redirect('/');
        }
    }

    public function login()
    {
        return view("user.login");
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }

}
