<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

Route::get('/', function () {
    return view('a');
});

Route::get('/login', function () {
    return view('login');
});

Route::post('/register', function (Request $request) {
    try {
        $user = [
            'username' => $request->input('username'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')), // Enkripsi password
            'nomor_hp' => $request->input('nomor_hp'),
            'alamat' => $request->input('alamat'),
            'created_at' => now(),
            'updated_at' => now(),
        ];

        DB::connection('mongodb')->getMongoDB()->selectCollection('users')->insertOne($user);

        return redirect('/')->with('success', 'Registrasi berhasil!');
    } catch (\Exception $e) {
        return redirect('/')->with('error', 'Gagal registrasi: ' . $e->getMessage());
    }
});

Route::post('/login', function (Request $request) {
    try {
        $user = DB::connection('mongodb')->getMongoDB()->selectCollection('users')->findOne([
            'email' => $request->input('email'),
        ]);

        if (!$user) {
            return redirect('/login')->with('error', 'Email tidak ditemukan');
        }

        if (!password_verify($request->input('password'), $user['password'])) {
            return redirect('/login')->with('error', 'Password salah');
        }

        Session::put('user', $user);

        return redirect('/dashboard');
    } catch (\Exception $e) {
        return redirect('/login')->with('error', 'Gagal login: ' . $e->getMessage());
    }
});

Route::get('/dashboard', function () {
    if (!Session::has('user')) {
        return redirect('/login')->with('error', 'Silakan login terlebih dahulu');
    }

    return view('dashboard');
});

Route::post('/logout', function () {
    Session::forget('user');
    return redirect('/login')->with('success', 'Anda telah logout');
});