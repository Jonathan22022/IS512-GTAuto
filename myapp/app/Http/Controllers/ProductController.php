<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Menampilkan produk milik penjual yang sedang login
     */
    public function index()
    {
    // Cek apakah user sudah login dan memiliki role penjual
        if (!Session::has('user') || Session::get('user')['role'] !== 'penjual') {
            return redirect('/login')->with('error', 'Akses ditolak! Halaman ini hanya untuk penjual.');
        }

        $user = Session::get('user');

    // Mengambil produk berdasarkan user_id penjual
        $productsCursor = DB::connection('mongodb')->getMongoDB()->selectCollection('products')
            ->find(['user_id' => new \MongoDB\BSON\ObjectId($user['_id'])]);

    // Ubah cursor menjadi array
        $products = iterator_to_array($productsCursor);

        return view('penjual.products', ['products' => $products]);
    
    }

public function edit($id)
{
    $product = DB::connection('mongodb')->getMongoDB()->selectCollection('products')
        ->findOne(['_id' => new \MongoDB\BSON\ObjectId($id)]);

    return view('penjual.EditProduct', ['product' => $product]);
}

public function destroy($id)
{
    DB::connection('mongodb')->getMongoDB()->selectCollection('products')
        ->deleteOne(['_id' => new \MongoDB\BSON\ObjectId($id)]);

    return redirect('/penjual/products')->with('success', 'Produk berhasil dihapus.');
}

public function create()
{
    // Cek apakah user sudah login dan memiliki role penjual
    if (!Session::has('user') || Session::get('user')['role'] !== 'penjual') {
        return redirect('/login')->with('error', 'Akses ditolak! Halaman ini hanya untuk penjual.');
    }

    return view('penjual.addproduct');
}
public function store(Request $request)
{
    // Validasi input
    $request->validate([
        'name' => 'required|string|max:255',
        'jumlahBarang' => 'required|integer|min:1',
        'gambar' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        'price' => 'required|numeric|min:0',
        'description' => 'required|string',
        'type' => 'required|in:Engine,Intake,Forced induction,Exhaust,Drivetrain,Handling',
    ]);

    // Simpan gambar
    $imagePath = $request->file('gambar')->store('uploads', 'public');

    // Ambil user yang sedang login
    $user = Session::get('user');

    // Simpan ke database
    DB::connection('mongodb')->getMongoDB()->selectCollection('products')->insertOne([
        'name' => $request->name,
        'jumlahBarang' => $request->jumlahBarang,
        'gambar' => "/storage/$imagePath",
        'price' => $request->price,
        'description' => $request->description,
        'type' => $request->type, // Simpan type
        'user_id' => $user['_id']
    ]);

    return redirect('/penjual/products')->with('success', 'Produk berhasil ditambahkan!');
}

public function update(Request $request, $id)
{
    // Validasi input
    $request->validate([
        'name' => 'required|string|max:255',
        'jumlahBarang' => 'required|integer|min:1',
        'price' => 'required|numeric|min:0',
        'description' => 'required|string',
        'type' => 'required|in:Engine,Intake,Forced induction,Exhaust,Drivetrain,Handling, Bodykits, Wheels, Livery and Wraps, Aerodynamics, Racing Gear',
        
        'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    // Ambil produk berdasarkan ID
    $product = DB::connection('mongodb')->getMongoDB()->selectCollection('products')->findOne(['_id' => new \MongoDB\BSON\ObjectId($id)]);

    if (!$product) {
        return redirect()->back()->with('error', 'Produk tidak ditemukan.');
    }

    // Simpan gambar jika ada
    $imagePath = $product['gambar'];
    if ($request->hasFile('gambar')) {
        $imagePath = $request->file('gambar')->store('uploads', 'public');
        $imagePath = "/storage/$imagePath";
    }

    // Update produk dalam database
    DB::connection('mongodb')->getMongoDB()->selectCollection('products')->updateOne(
        ['_id' => new \MongoDB\BSON\ObjectId($id)],
        ['$set' => [
            'name' => $request->name,
            'jumlahBarang' => $request->jumlahBarang,
            'price' => $request->price,
            'description' => $request->description,
            'gambar' => $imagePath,
            'type' => $request->type, // Update type
        ]]
    );

    return redirect('/penjual/products')->with('success', 'Produk berhasil diperbarui.');
}}
