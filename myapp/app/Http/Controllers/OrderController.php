<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use MongoDB\BSON\ObjectId;

class OrderController extends Controller
{
    // Menampilkan daftar pesanan
    public function index()
    {
        if (!Session::has('user')) {
            return redirect('/login')->with('error', 'Silakan login terlebih dahulu');
        }

        $user = Session::get('user');
        $userId = new ObjectId($user['_id']);

        try {
            // Ambil data pesanan dari database MongoDB
            $orders = DB::connection('mongodb')
                ->getMongoDB()
                ->selectCollection('orders')
                ->find([
                    '$or' => [
                        ['pembeli_id' => $userId],  // Orders where user is buyer
                        ['user_id' => $userId]      // Orders where user is seller
                    ]
                ])
                ->toArray();

            // Kirim data pesanan ke view
            return view('orders.index', [
                'orders' => $orders,
                'user' => $user
            ]);
        } catch (\Exception $e) {
            return redirect('/dashboard')->with('error', 'Gagal memuat pesanan: ' . $e->getMessage());
        }
    }

    // Menampilkan form pembuatan pesanan baru
    public function create()
    {
        if (!Session::has('user')) {
            return redirect('/login')->with('error', 'Silakan login terlebih dahulu');
        }

        return view('orders.create');
    }

    // Menyimpan pesanan baru
    public function store(Request $request)
    {
        if (!Session::has('user')) {
            return redirect('/login')->with('error', 'Silakan login terlebih dahulu');
        }

        try {
            $user = Session::get('user');
            
            $orderData = [
                'user_id' => new ObjectId($user['_id']),
                'products' => $request->input('products'),
                'total_price' => $request->input('total_price'),
                'status' => 'pending',
                'created_at' => now(),
                'updated_at' => now(),
            ];

            // Simpan data pesanan ke database MongoDB
            DB::connection('mongodb')
                ->getMongoDB()
                ->selectCollection('orders')
                ->insertOne($orderData);

            return redirect('/orders')->with('success', 'Pesanan berhasil dibuat!');
        } catch (\Exception $e) {
            return redirect('/orders/create')->with('error', 'Gagal membuat pesanan: ' . $e->getMessage());
        }
    }

    // Menampilkan detail pesanan
    public function show($id)
    {
        if (!Session::has('user')) {
            return redirect('/login')->with('error', 'Silakan login terlebih dahulu');
        }

        try {
            $order = DB::connection('mongodb')
                ->getMongoDB()
                ->selectCollection('orders')
                ->findOne(['_id' => new ObjectId($id)]);

            if (!$order) {
                return redirect('/orders')->with('error', 'Pesanan tidak ditemukan');
            }

            return view('orders.show', ['order' => $order]);
        } catch (\Exception $e) {
            return redirect('/orders')->with('error', 'Gagal memuat detail pesanan: ' . $e->getMessage());
        }
    }

    // Menampilkan form edit pesanan
    public function edit($id)
    {
        if (!Session::has('user')) {
            return redirect('/login')->with('error', 'Silakan login terlebih dahulu');
        }

        try {
            $order = DB::connection('mongodb')
                ->getMongoDB()
                ->selectCollection('orders')
                ->findOne(['_id' => new ObjectId($id)]);

            if (!$order) {
                return redirect('/orders')->with('error', 'Pesanan tidak ditemukan');
            }

            return view('orders.edit', ['order' => $order]);
        } catch (\Exception $e) {
            return redirect('/orders')->with('error', 'Gagal memuat form edit: ' . $e->getMessage());
        }
    }

    // Mengupdate status pesanan
    public function update(Request $request, $id)
    {
        if (!Session::has('user')) {
            return redirect('/login')->with('error', 'Silakan login terlebih dahulu');
        }

        try {
            $status = $request->input('status');

            // Update status pesanan di database MongoDB
            DB::connection('mongodb')
                ->getMongoDB()
                ->selectCollection('orders')
                ->updateOne(
                    ['_id' => new ObjectId($id)],
                    ['$set' => [
                        'status' => $status, 
                        'updated_at' => now()
                    ]]
                );

            return redirect('/orders')->with('success', 'Status pesanan berhasil diperbarui!');
        } catch (\Exception $e) {
            return redirect('/orders/' . $id . '/edit')->with('error', 'Gagal memperbarui status pesanan: ' . $e->getMessage());
        }
    }

    // Menghapus pesanan
    public function destroy($id)
    {
        if (!Session::has('user')) {
            return redirect('/login')->with('error', 'Silakan login terlebih dahulu');
        }

        try {
            // Hapus pesanan dari database MongoDB
            DB::connection('mongodb')
                ->getMongoDB()
                ->selectCollection('orders')
                ->deleteOne(['_id' => new ObjectId($id)]);

            return redirect('/orders')->with('success', 'Pesanan berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect('/orders')->with('error', 'Gagal menghapus pesanan: ' . $e->getMessage());
        }
    }

    // Menampilkan jumlah pesanan (untuk ditampilkan di navbar misalnya)
    public function orderCount()
    {
        try {
            if (!Session::has('user')) {
                return view('partials.order-count', ['count' => 0]);
            }

            $user = Session::get('user');
            $userId = new ObjectId($user['_id']);

            $count = DB::connection('mongodb')
                ->getMongoDB()
                ->selectCollection('orders')
                ->countDocuments([
                    '$or' => [
                        ['pembeli_id' => $userId],
                        ['user_id' => $userId]
                    ]
                ]);

            return view('partials.order-count', ['count' => $count]);
        } catch (\Exception $e) {
            return view('partials.order-count', ['count' => 0]);
        }
    }
}
