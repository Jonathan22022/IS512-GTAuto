<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    // Menampilkan halaman registrasi
    public function showRegister()
    {
        return view('register');
    }

    // Proses registrasi user ke MongoDB
    public function register(Request $request)
    {
        try {
            $user = [
                'username' => $request->input('username'),
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password')), // Hash password
                'nomor_hp' => $request->input('nomor_hp'),
                'alamat' => $request->input('alamat'),
                'created_at' => now(),
                'updated_at' => now(),
            ];

            DB::connection('mongodb')->collection('users')->insert($user);

            return redirect('/login')->with('success', 'Registrasi berhasil! Silakan login.');
        } catch (\Exception $e) {
            return redirect('/register')->with('error', 'Gagal registrasi: ' . $e->getMessage());
        }
    }

    // Menampilkan halaman login
    public function showLogin()
    {
        return view('login');
    }

    // Proses login
    public function login(Request $request)
    {
        $user = DB::connection('mongodb')->collection('users')
            ->where('email', $request->input('email'))->first();

        if ($user && Hash::check($request->input('password'), $user['password'])) {
            Session::put('user', $user);
            return redirect('/dashboard')->with('success', 'Login berhasil!');
        }

        return redirect('/login')->with('error', 'Email atau password salah.');
    }

    public function logout()
    {
        Session::forget('user');
        return redirect('/login')->with('success', 'Anda telah logout.');
    }
}
