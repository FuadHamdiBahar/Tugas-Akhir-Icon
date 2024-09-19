<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function signin()
    {
        return view('signin');
    }

    public function submitSignin(Request $request)
    {
        $data = $request->only('email', 'password');
        if (Auth::attempt($data)) {
            $request->session()->regenerate();
            session([
                'userid' => Auth::user()->id,
                'email' => Auth::user()->email,
                'usertype' => Auth::user()->usertype
            ]);
            return redirect()->route('dashboard');
        } else {
            return redirect()->back()->with('gagal', 'Email atau password salah');
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
