<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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

            $email = $data['email'];
            $userRole = DB::select("select * from myapp.user_roles ur where ur.email = '$email'");

            $userType = 'user';
            if (count($userRole) > 0) {
                $userType = $userRole[0]->role;
            }

            session([
                'userid' => Auth::user()->id,
                'email' => Auth::user()->email,
                'usertype' => $userType
            ]);
            return redirect()->route('dashboard');
        } else {
            return redirect()->back()->with('gagal', 'Wrong email or password');
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
