<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

// Tambahkan ini

class LoginController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect('/'); // Redirect ke home jika sudah login
        }
        return view('login.login'); // Pastikan path view benar
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required', // Validasi username
            'password' => 'required',
        ]);

        if (Auth::attempt(['username' => $request->username, 'password' => $request->password])) {
            // Autentikasi berhasil
            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'username' => 'Nama Pengguna dan Kata Sandi tidak sesuai.',
        ]);
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/'); // Redirect ke home setelah logout
    }

    // Menampilkan halaman pengaturan akun
    public function showSettings()
    {
        return view('login.pengaturan_akun');
    }
    // Memproses pembaruan username dan password
    public function update(Request $request)
    {
        $request->validate([
            'old_username' => 'required|string|max:255',
            'old_password' => 'required|string|min:4',
            'username' => 'required|string|max:255|unique:users,username,' . Auth::id(),
            'password' => 'nullable|string|min:4|confirmed',
        ]);

        $user = Auth::user();

        // Memeriksa apakah username dan password lama sesuai
        if ($user->username !== $request->old_username || !Hash::check($request->old_password, $user->password)) {
            return redirect()->route('account.settings')->withErrors([
                'old_username' => 'Username atau password lama tidak sesuai.',
            ]);
        }

        // Memperbarui username
        $user->username = $request->username;

        // Memperbarui password jika diisi
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('account.settings')->with('success', 'Pengaturan akun berhasil diperbarui.');
    }

}
