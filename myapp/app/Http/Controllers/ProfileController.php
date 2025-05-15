<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use MongoDB\BSON\ObjectId;

class ProfileController extends Controller
{
    public function index()
{
    if (!Session::has('user')) {
        return redirect('/login');
    }

    $user = Session::get('user');
    
    $creditCards = DB::connection('mongodb')
        ->getMongoDB()
        ->selectCollection('creditcards')
        ->find(['user_id' => $user['_id']])
        ->toArray();

    $eWallets = DB::connection('mongodb')
        ->getMongoDB()
        ->selectCollection('ewallets')
        ->find(['user_id' => $user['_id']])
        ->toArray();

    // Add type identifier to each payment
    $creditCards = array_map(function($card) {
        $card['type'] = 'creditcard';
        return $card;
    }, $creditCards);

    $eWallets = array_map(function($wallet) {
        $wallet['type'] = 'ewallet';
        return $wallet;
    }, $eWallets);

    $payments = array_merge($creditCards, $eWallets);

    return view('profile', [
        'payments' => $payments,
        'user' => $user
    ]);

    $userId = new \MongoDB\BSON\ObjectId(session('user')['_id']);

// Get active credit cards
$activeCreditCards = DB::connection('mongodb')
    ->getMongoDB()
    ->selectCollection('creditcards')
    ->find([
        'user_id' => $userId,
        'isActive' => true
    ])
    ->toArray();

// Get active ewallets
$activeEwallets = DB::connection('mongodb')
    ->getMongoDB()
    ->selectCollection('ewallets')
    ->find([
        'user_id' => $userId,
        'isActive' => true
    ])
    ->toArray();

// Combine both payment methods
$activePayments = array_merge($activeCreditCards, $activeEwallets);

return view('cart.index', [
    'carts' => $carts,
    'activePayments' => $activePayments,
]);
}
}