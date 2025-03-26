<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Product;
use App\Models\Job;
use App\Models\User;
use App\Models\Cart;
use App\Models\TempatService;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TempatServiceController;

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
            'password' => bcrypt($request->input('password')),
            'nomor_hp' => $request->input('nomor_hp'),
            'alamat' => $request->input('alamat'),
            'role' => 'user',
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

        if ($user['role'] === 'admin') {
            return redirect('/admin');
        } elseif ($user['role'] === 'penjual') {
            return redirect('/penjual/products');
        } elseif ($user['role'] === 'mekanik') {
            return redirect('/mekanik/mekanik');
        } elseif ($user['role'] === 'service') {
            return redirect('/TempatService/tempatservice');
        }else {
            return redirect('/dashboard'); 
        }
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

Route::get('/profile', function(){ return view('profile'); });
Route::get('/setting', function(){ return view('settings'); });
Route::get('/findMechanic', function(){ return view('FindMechanic'); });
Route::get('/findMaintenanceCentre', function(){ return view('FindMaintenanceCentre'); });

Route::get('/findPart', function(){ 
    $users = DB::connection('mongodb')->getMongoDB()->selectCollection('users')
        ->find(['role' => 'penjual'])
        ->toArray();
    return view('FindPart', compact('users')); 
});

Route::get('/detail-penjual', function (Request $request) {
    $username = $request->query('username');
    
    // Find the user by username
    $user = DB::connection('mongodb')->getMongoDB()->selectCollection('users')
        ->findOne(['username' => $username]);
    
    if (!$user) {
        return redirect('/findPart')->with('error', 'Penjual tidak ditemukan');
    }
    
    // Get products for this seller
    $products = DB::connection('mongodb')->getMongoDB()->selectCollection('products')
        ->find(['user_id' => $user['_id']])
        ->toArray();
    
    return view('detail-penjual', [
        'username' => $username,
        'alamat' => $user['alamat'],
        'products' => $products
    ]);
});

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
Route::get('/cart/count', [CartController::class, 'getCartCount'])->name('cart.count');
Route::patch('/cart/{id}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/{id}', [CartController::class, 'destroy'])->name('cart.destroy');

Route::get('/admin', function () {
    if (!Session::has('user') || Session::get('user')['role'] !== 'admin') {
        return redirect('/login')->with('error', 'Akses ditolak!');
    }
    return view('admin.admin');
});

Route::get('/TempatService/tempatservice', function () {
    if (!Session::has('user') || Session::get('user')['role'] !== 'service') {
        return redirect('/login')->with('error', 'Akses ditolak! Halaman ini hanya untuk tempat service.');
    }

    return view('TempatService.tempatservice'); 
});
Route::get('/TempatService/tempatservice', [TempatServiceController::class, 'index'])->name('TempatService.tempatservice');
Route::get('/edit-tempat-service/{id}', [TempatServiceController::class, 'edit'])->name('TempatService.edittempatservice');
Route::post('/delete-tempat-service/{id}', [TempatServiceController::class, 'destroy'])->name('delete.tempatservice');
Route::get('/add-tempat-service', [TempatServiceController::class, 'create'])->name('TempatService.addtempatservice');
Route::post('/add-tempat-service', [TempatServiceController::class, 'store'])->name('TempatService.addtempatservice');
Route::post('/update-tempat-service/{id}', [TempatServiceController::class, 'update'])->name('TempatService.Updatetempatservice');

Route::get('/penjual/products', function () {
    if (!Session::has('user') || Session::get('user')['role'] !== 'penjual') {
        return redirect('/login')->with('error', 'Akses ditolak! Halaman ini hanya untuk penjual.');
    }

    return view('penjual.products'); 
});

Route::get('/penjual/products', [ProductController::class, 'index'])->name('penjual.products');
Route::get('/edit-product/{id}', [ProductController::class, 'edit'])->name('penjual.EditProduct');
Route::post('/delete-product/{id}', [ProductController::class, 'destroy'])->name('delete.product');
Route::get('/add-product', [ProductController::class, 'create'])->name('penjual.AddProduct');
Route::post('/add-product', [ProductController::class, 'store'])->name('penjual.AddProduct');
Route::post('/update-product/{id}', [ProductController::class, 'update'])->name('penjual.UpdateProduct');

Route::get('/mekanik/mekanik', function () {
    if (!Session::has('user') || Session::get('user')['role'] !== 'mekanik') {
        return redirect('/login')->with('error', 'Akses ditolak! Halaman ini hanya untuk mekanik.');
    }

    return view('mekanik.mekanik'); 
});

Route::get('/mekanik/mekanik', [JobController::class, 'index'])->name('mekanik.mekanik');
Route::get('/add-job', [JobController::class, 'create'])->name('mekanik.AddJasa');
Route::post('/add-job', [JobController::class, 'store'])->name('mekanik.AddJasa');
Route::post('/delete-job/{id}', [JobController::class, 'destroy'])->name('delete.job');
Route::get('/edit-job/{id}', [JobController::class, 'edit'])->name('mekanik.EditJasa');
Route::post('/update-job/{id}', [JobController::class, 'update'])->name('mekanik.UpdateJasa');

Route::get('/admin', [AdminController::class, 'index'])->name('admin.admin');

Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
});

Route::post('/forgot-password', function (Request $request) {
    $email = $request->input('email');
    $user = DB::connection('mongodb')->getMongoDB()->selectCollection('users')->findOne(['email' => $email]);

    if (!$user) {
        return redirect('/forgot-password')->with('error', 'Email tidak ditemukan!');
    }

    $token = Str::random(60);

    DB::connection('mongodb')->getMongoDB()->selectCollection('password_reset_tokens')->insertOne([
        'email' => $email,
        'token' => $token,
        'created_at' => now()
    ]);

    Mail::raw("Klik link berikut untuk reset password: " . url('/reset-password?token=' . $token), function ($message) use ($email) {
        $message->to($email)->subject('Reset Password');
    });

    return redirect('/forgot-password')->with('success', 'Link reset password telah dikirim ke email Anda.');
});

Route::get('/reset-password', function (Request $request) {
    return view('auth.reset-password', ['token' => $request->query('token')]);
});

Route::post('/reset-password', function (Request $request) {
    $token = $request->input('token');
    $passwordReset = DB::connection('mongodb')->getMongoDB()->selectCollection('password_reset_tokens')->findOne(['token' => $token]);

    if (!$passwordReset) {
        return redirect('/reset-password')->with('error', 'Token tidak valid atau sudah kadaluarsa!');
    }

    DB::connection('mongodb')->getMongoDB()->selectCollection('users')->updateOne(
        ['email' => $passwordReset['email']],
        ['$set' => ['password' => Hash::make($request->input('password'))]]
    );

    DB::connection('mongodb')->getMongoDB()->selectCollection('password_reset_tokens')->deleteOne(['token' => $token]);

    return redirect('/login')->with('success', 'Password berhasil diperbarui!');
});

Route::post('/logout', function () {
    Session::forget('user');
    return redirect('/login')->with('success', 'Anda telah logout');
});
