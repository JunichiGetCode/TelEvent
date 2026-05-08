<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    // Menampilkan form login
    public function showLogin()
    {
        return view('auth.login');
    }

    // Menangani proses login
    public function login(Request $request)
    {
        // Validasi input email dan password
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        // Cek kredensial login menggunakan Auth::attempt
        if (Auth::attempt($credentials)) {
            // Regenerasi session ID untuk mencegah session fixation
            $request->session()->regenerate();

            // Ambil data user yang sedang login
            $user = auth()->user();

            // Cek apakah user adalah admin berdasarkan email atau role
            if ($user->email === 'admin@login.com' || $user->role === 'admin') {
                // Arahkan admin ke dashboard admin
                return redirect()->route('admin.dashboard');
            }

            // Arahkan user biasa ke dashboard pengguna
            return redirect()->route('user.home');
        }

        // Jika login gagal, tampilkan error
        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    // Menangani logout
    public function logout(Request $request)
    {
        // Logout pengguna
        Auth::logout();

        // Hapus session dan regenerasi token CSRF untuk mencegah serangan
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Arahkan kembali ke halaman utama setelah logout
        return redirect('/');
    }
}
