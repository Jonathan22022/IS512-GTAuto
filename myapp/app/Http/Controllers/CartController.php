<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use App\Models\Cart;

class CartController extends Controller
{
    public function index()
{
    if (!Session::has('user')) {
        return redirect('/login')->with('error', 'Silakan login terlebih dahulu');
    }

    $user = Session::get('user');
    $carts = DB::connection('mongodb')
        ->getMongoDB()
        ->selectCollection('carts')
        ->find(['user_id' => $user['_id']])
        ->toArray();

    // Get seller information if cart not empty
    $seller = null;
    if (count($carts) > 0) {
        $firstProduct = DB::connection('mongodb')
            ->getMongoDB()
            ->selectCollection('products')
            ->findOne(['_id' => new \MongoDB\BSON\ObjectId($carts[0]['product_id'])]);

        if ($firstProduct) {
            $seller = DB::connection('mongodb')
                ->getMongoDB()
                ->selectCollection('users')
                ->findOne(['_id' => $firstProduct['user_id']]);
        }
    }

    return view('cart.index', [
        'carts' => $carts,
        'seller' => $seller
    ]);
}

    public function store(Request $request)
{
    if (!Session::has('user')) {
        return response()->json(['error' => 'Unauthorized'], 401);
    }

    $user = Session::get('user');
    $productId = $request->input('product_id');
    $quantity = (int)$request->input('quantity');

    // Validasi quantity
    if ($quantity < 1) {
        return response()->json(['error' => 'Quantity minimal 1'], 400);
    }

    // Get product
    $product = DB::connection('mongodb')
        ->getMongoDB()
        ->selectCollection('products')
        ->findOne(['_id' => new \MongoDB\BSON\ObjectId($productId)]);

    if (!$product) {
        return response()->json(['error' => 'Product not found'], 404);
    }

    // Check stock
    if ($quantity > $product['jumlahBarang']) {
        return response()->json(['error' => 'Stok tidak mencukupi'], 400);
    }

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

    return response()->json(['success' => true, 'inserted' => $result->getUpsertedCount() > 0]);
}

public function getCartCount()
{
    if (!Session::has('user')) {
        return response()->json(['count' => 0]);
    }

    $user = Session::get('user');
    
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

    return response()->json(['count' => $count]);
}

    public function update(Request $request, $id)
    {
        if (!Session::has('user')) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
        }

        $change = $request->input('change');
        $cart = DB::connection('mongodb')
            ->getMongoDB()
            ->selectCollection('carts')
            ->findOne(['_id' => new \MongoDB\BSON\ObjectId($id)]);

        if (!$cart) {
            return response()->json(['success' => false, 'message' => 'Cart item not found'], 404);
        }

        $newQuantity = $cart['quantity'] + $change;

        if ($newQuantity < 1) {
            return response()->json(['success' => false, 'message' => 'Quantity cannot be less than 1']);
        }

        // Check product stock
        $product = DB::connection('mongodb')
            ->getMongoDB()
            ->selectCollection('products')
            ->findOne(['_id' => new \MongoDB\BSON\ObjectId($cart['product_id'])]);

        if ($newQuantity > $product['jumlahBarang']) {
            return response()->json(['success' => false, 'message' => 'Stok tidak mencukupi']);
        }

        DB::connection('mongodb')
            ->getMongoDB()
            ->selectCollection('carts')
            ->updateOne(
                ['_id' => new \MongoDB\BSON\ObjectId($id)],
                ['$set' => ['quantity' => $newQuantity]]
            );

        return response()->json(['success' => true]);
    }

    public function destroy($id)
    {
        if (!Session::has('user')) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
        }

        DB::connection('mongodb')
            ->getMongoDB()
            ->selectCollection('carts')
            ->deleteOne(['_id' => new \MongoDB\BSON\ObjectId($id)]);

        return response()->json(['success' => true]);
    }
}