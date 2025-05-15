<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use App\Models\Cart;
use MongoDB\BSON\ObjectId;

class CartController extends Controller
{
    public function index()
    {
        if (!Session::has('user')) {
            return redirect('/login')->with('error', 'Silakan login terlebih dahulu');
        }

        $user = Session::get('user');
        
        try {
            $userId = new ObjectId($user['_id']);
            
            // Get cart items
            $carts = DB::connection('mongodb')
                ->getMongoDB()
                ->selectCollection('carts')
                ->find(['user_id' => $userId])
                ->toArray();

            // Calculate total
            $total = array_reduce($carts, function($sum, $item) {
                return $sum + ($item['price'] * $item['quantity']);
            }, 0);

            // Get seller information if cart not empty
            $seller = null;
            if (count($carts) > 0) {
                $firstProduct = DB::connection('mongodb')
                    ->getMongoDB()
                    ->selectCollection('products')
                    ->findOne(['_id' => new ObjectId($carts[0]['product_id'])]);

                if ($firstProduct) {
                    $seller = DB::connection('mongodb')
                        ->getMongoDB()
                        ->selectCollection('users')
                        ->findOne(['_id' => $firstProduct['user_id']]);
                }
            }

            // Get active payment methods
            $activeCreditCards = DB::connection('mongodb')
                ->getMongoDB()
                ->selectCollection('creditcards')
                ->find([
                    'user_id' => $userId,
                    'isActive' => true
                ])
                ->toArray();

            $activeEwallets = DB::connection('mongodb')
                ->getMongoDB()
                ->selectCollection('ewallets')
                ->find([
                    'user_id' => $userId,
                    'isActive' => true
                ])
                ->toArray();

            // Add type to each payment method
            $activeCreditCards = array_map(function($card) {
                $card['type'] = 'creditcard';
                return $card;
            }, $activeCreditCards);

            $activeEwallets = array_map(function($wallet) {
                $wallet['type'] = 'ewallet';
                return $wallet;
            }, $activeEwallets);

            $activePayments = array_merge($activeCreditCards, $activeEwallets);

            return view('cart.index', [
                'carts' => $carts,
                'seller' => $seller,
                'total' => $total,
                'activePayments' => $activePayments
            ]);

        } catch (\Exception $e) {
            \Log::error('CartController error: ' . $e->getMessage());
            return redirect('/')->with('error', 'Terjadi kesalahan saat memuat keranjang belanja');
        }
    }

    public function store(Request $request)
    {
        if (!Session::has('user')) {
            return redirect('/login')->with('error', 'Silakan login terlebih dahulu');
        }

        $user = Session::get('user');
        $productId = $request->input('product_id');
        $quantity = (int)$request->input('quantity');

        // Validate quantity
        if ($quantity < 1) {
            return back()->with('error', 'Quantity minimal 1');
        }

        // Get product
        $product = DB::connection('mongodb')
            ->getMongoDB()
            ->selectCollection('products')
            ->findOne(['_id' => new ObjectId($productId)]);

        if (!$product) {
            return back()->with('error', 'Produk tidak ditemukan');
        }

        // Check stock
        if ($quantity > $product['jumlahBarang']) {
            return back()->with('error', 'Stok tidak mencukupi');
        }

        try {
            // Update or create cart item
            $result = DB::connection('mongodb')
                ->getMongoDB()
                ->selectCollection('carts')
                ->updateOne(
                    [
                        'user_id' => $user['_id'],
                        'product_id' => $productId
                    ],
                    [
                        '$setOnInsert' => [
                            'name' => $product['name'],
                            'price' => $product['price'],
                            'gambar' => $product['gambar'],
                            'created_at' => now(),
                            'updated_at' => now()
                        ],
                        '$inc' => ['quantity' => $quantity]
                    ],
                    ['upsert' => true]
                );

            return back()->with('success', 'Produk berhasil ditambahkan ke keranjang');

        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        if (!Session::has('user')) {
            return back()->with('error', 'Silakan login terlebih dahulu');
        }

        $change = $request->input('change');
        $cart = DB::connection('mongodb')
            ->getMongoDB()
            ->selectCollection('carts')
            ->findOne(['_id' => new \MongoDB\BSON\ObjectId($id)]);

        if (!$cart) {
            return back()->with('error', 'Item keranjang tidak ditemukan');
        }

        $newQuantity = $cart['quantity'] + $change;

        if ($newQuantity < 1) {
            return back()->with('error', 'Quantity tidak boleh kurang dari 1');
        }

        // Check product stock
        $product = DB::connection('mongodb')
            ->getMongoDB()
            ->selectCollection('products')
            ->findOne(['_id' => new \MongoDB\BSON\ObjectId($cart['product_id'])]);

        if ($newQuantity > $product['jumlahBarang']) {
            return back()->with('error', 'Stok tidak mencukupi');
        }

        DB::connection('mongodb')
            ->getMongoDB()
            ->selectCollection('carts')
            ->updateOne(
                ['_id' => new \MongoDB\BSON\ObjectId($id)],
                ['$set' => ['quantity' => $newQuantity]]
            );

        return back()->with('success', 'Keranjang berhasil diperbarui');
    }

    public function destroy($id)
    {
        if (!Session::has('user')) {
            return back()->with('error', 'Silakan login terlebih dahulu');
        }

        DB::connection('mongodb')
            ->getMongoDB()
            ->selectCollection('carts')
            ->deleteOne(['_id' => new \MongoDB\BSON\ObjectId($id)]);

        return back()->with('success', 'Item berhasil dihapus dari keranjang');
    }

    public function getCartCount()
    {
        if (!Session::has('user')) {
            return view('partials.cart-count', ['count' => 0]);
        }

        $user = Session::get('user');
        
        try {
            $aggregation = DB::connection('mongodb')
                ->getMongoDB()
                ->selectCollection('carts')
                ->aggregate([
                    ['$match' => ['user_id' => $user['_id']]],
                    ['$group' => [
                        '_id' => null,
                        'total' => ['$sum' => '$quantity']
                    ]]
                ])
                ->toArray();

            $count = $aggregation[0]['total'] ?? 0;

            return view('partials.cart-count', ['count' => $count]);
        } catch (\Exception $e) {
            return view('partials.cart-count', ['count' => 0]);
        }
    }

    public function processCheckout(Request $request)
    {
        if (!Session::has('user')) {
            return redirect('/login')->with('error', 'Silakan login terlebih dahulu');
        }

        try {
            $user = Session::get('user');
            
            $request->validate([
                'shipping_method' => 'required|in:reguler,express',
                'payment_method_id' => 'required',
            ]);

            // Get cart data
            $carts = DB::connection('mongodb')
                ->getMongoDB()
                ->selectCollection('carts')
                ->find(['user_id' => $user['_id']])
                ->toArray();

            if (empty($carts)) {
                return redirect('/cart')->with('error', 'Keranjang belanja kosong');
            }

            // Calculate product total price
            $subtotal = array_reduce($carts, function($sum, $item) {
                return $sum + ($item['price'] * $item['quantity']);
            }, 0);

            // Calculate shipping based on method
            $shippingCost = $request->shipping_method === 'express' ? 25000 : 15000;
            $total = $subtotal + $shippingCost;

            // Get payment data
            $paymentMethod = DB::connection('mongodb')
                ->getMongoDB()
                ->selectCollection('creditcards')
                ->findOne(['_id' => new \MongoDB\BSON\ObjectId($request->payment_method_id)]);

            // If not found in creditcards, check ewallets
            if (!$paymentMethod) {
                $paymentMethod = DB::connection('mongodb')
                    ->getMongoDB()
                    ->selectCollection('ewallets')
                    ->findOne(['_id' => new \MongoDB\BSON\ObjectId($request->payment_method_id)]);
            }

            if (!$paymentMethod) {
                return back()->with('error', 'Metode pembayaran tidak valid');
            }

            // Save to orders table for each cart item
            foreach ($carts as $cart) {
                // Get product info to get seller's user_id
                $product = DB::connection('mongodb')
                    ->getMongoDB()
                    ->selectCollection('products')
                    ->findOne(['_id' => new \MongoDB\BSON\ObjectId($cart['product_id'])]);

                if (!$product) {
                    continue; // Skip if product not found
                }

                $orderData = [
                    'pembeli_id' => $user['_id'],
                    'user_id' => $product['user_id'], // Seller ID
                    'product_id' => $cart['product_id'],
                    'quantity' => $cart['quantity'],
                    'subtotal' => $cart['price'] * $cart['quantity'],
                    'shipping_method' => $request->shipping_method,
                    'shipping_cost' => $shippingCost,
                    'total' => $total,
                    'payment_id' => $request->payment_method_id,
                    'payment_type' => isset($paymentMethod['cardNumber']) ? 'creditcard' : 'ewallet',
                    'status' => 'diterima penjual',
                    'created_at' => now(),
                    'updated_at' => now()
                ];

                // Save order
                DB::connection('mongodb')
                    ->getMongoDB()
                    ->selectCollection('orders')
                    ->insertOne($orderData);

                // Reduce product stock
                DB::connection('mongodb')
                    ->getMongoDB()
                    ->selectCollection('products')
                    ->updateOne(
                        ['_id' => new \MongoDB\BSON\ObjectId($cart['product_id'])],
                        ['$inc' => ['jumlahBarang' => -$cart['quantity']]]
                    );
            }

            // Clear cart after checkout
            DB::connection('mongodb')
                ->getMongoDB()
                ->selectCollection('carts')
                ->deleteMany(['user_id' => $user['_id']]);

            return redirect('/orders')->with('success', 'Pembayaran berhasil diproses');

        } catch (\Exception $e) {
            \Log::error('Checkout error: '.$e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat memproses pembayaran: '.$e->getMessage());
        }
    }
}
