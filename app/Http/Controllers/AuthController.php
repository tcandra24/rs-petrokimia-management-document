<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ], [
            'email.required' => 'email wajib diisi',
            'password.required' => 'Password wajib diisi',
        ]);

        try {
            $credentials = $request->only('email', 'password');
            if (!Auth::attempt($credentials, $request->remember)) {
                throw new \Exception('Login Gagal, Email/Password salah');
            }

            $user = Auth::user();
            if (!$user->hasVerifiedEmail()) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                throw new \Exception('Login Gagal, Email belum terverifikasi');
            }

            $request->session()->regenerate();
            return redirect()->intended()->route('dashboard.index');
        } catch (\Exception $e) {
            return back()->with('errors', $e->getMessage());
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
