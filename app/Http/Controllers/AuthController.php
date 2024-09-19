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
                'user_id' => Auth::user()->id,
                'email' => Auth::user()->email
            ]);
            // $request->session()->put('userid', Auth::user()->id);
            // $request->session()->put('email', Auth::user()->email);
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
