<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    // 1. Tampilkan Halaman Login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // 2. Proses Login
    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Kunci Rate Limiter (Anti Brute Force)
        // Kuncinya berdasarkan IP Address user
        $throttleKey = Str::lower($request->input('email')) . '|' . $request->ip();

        // Cek apakah user sudah terlalu banyak mencoba (Max 5 kali)
        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            return back()->withErrors([
                'email' => 'Terlalu banyak percobaan. Coba lagi dalam ' . $seconds . ' detik.',
            ]);
        }

        // Cek Credentials (Email & Password)
        // $request->boolean('remember') akan otomatis ambil value checkbox "Ingat Saya"
        if (Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            
            // Kalau sukses, bersihkan hitungan gagal
            RateLimiter::clear($throttleKey);

            // Regenerate session ID (Security standard)
            $request->session()->regenerate();

            // Masuk ke dashboard
            return redirect()->intended(route('dashboard'));
        }

        // Kalau gagal login:
        RateLimiter::hit($throttleKey, 120); // Catat kegagalan, kunci 120 detik (2 menit) jika penuh

        return back()->withErrors([
            'email' => 'Email atau password salah!',
        ])->onlyInput('email');
    }

    // 3. Proses Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
