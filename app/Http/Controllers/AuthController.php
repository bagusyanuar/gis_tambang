<?php


namespace App\Http\Controllers;


use App\Helper\CustomController;
use Illuminate\Support\Facades\Auth;

class AuthController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('guest')->except('logout');
    }

    public function login()
    {
        if ($this->request->method() === 'POST') {
            $credentials = [
                'username' => $this->postField('username'),
                'password' => $this->postField('password')
            ];
            if ($this->isAuth($credentials)) {
                $roles = \auth()->user()->roles;
                if (in_array('admin', $roles)) {
                    return redirect('/admin');
                } else {
                    return redirect('/member');
                }
            }
            return redirect()->back()->with('failed', 'Periksa Kembali Username dan Password Anda');
        }
        return view('login');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
