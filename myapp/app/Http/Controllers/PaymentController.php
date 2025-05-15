<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use MongoDB\BSON\ObjectId;

class PaymentController extends Controller
{
    public function addPayment(Request $request)
    {
        if (!Session::has('user')) {
            return redirect('/login');
        }

        $user = Session::get('user');
        $data = $request->all();
        $data['user_id'] = $user['_id'];
        $data['amount'] = 5000000;
        $data['isActive'] = true;

        if ($request->payment_type === 'creditcard') {
            // Deactivate all credit cards first
            DB::connection('mongodb')
                ->getMongoDB()
                ->selectCollection('creditcards')
                ->updateMany(
                    ['user_id' => $user['_id']],
                    ['$set' => ['isActive' => false]]
                );

            // Add new credit card
            DB::connection('mongodb')
                ->getMongoDB()
                ->selectCollection('creditcards')
                ->insertOne($data);
        } else {
            // Deactivate all e-wallets first
            DB::connection('mongodb')
                ->getMongoDB()
                ->selectCollection('ewallets')
                ->updateMany(
                    ['user_id' => $user['_id']],
                    ['$set' => ['isActive' => false]]
                );

            // Add new e-wallet
            DB::connection('mongodb')
                ->getMongoDB()
                ->selectCollection('ewallets')
                ->insertOne($data);
        }

        return redirect('/profile')->with('success', 'Payment method added successfully');
    }

    public function setActive(Request $request)
    {
        if (!Session::has('user')) {
            return redirect('/login');
        }

        $user = Session::get('user');
        $paymentId = $request->payment_id;
        $paymentType = $request->payment_type;

        if ($paymentType === 'creditcard') {
            // Deactivate all credit cards
            DB::connection('mongodb')
                ->getMongoDB()
                ->selectCollection('creditcards')
                ->updateMany(
                    ['user_id' => $user['_id']],
                    ['$set' => ['isActive' => false]]
                );

            // Activate selected credit card
            DB::connection('mongodb')
                ->getMongoDB()
                ->selectCollection('creditcards')
                ->updateOne(
                    ['_id' => new ObjectId($paymentId)],
                    ['$set' => ['isActive' => true]]
                );
        } else {
            // Deactivate all e-wallets
            DB::connection('mongodb')
                ->getMongoDB()
                ->selectCollection('ewallets')
                ->updateMany(
                    ['user_id' => $user['_id']],
                    ['$set' => ['isActive' => false]]
                );

            // Activate selected e-wallet
            DB::connection('mongodb')
                ->getMongoDB()
                ->selectCollection('ewallets')
                ->updateOne(
                    ['_id' => new ObjectId($paymentId)],
                    ['$set' => ['isActive' => true]]
                );
        }

        return redirect('/profile')->with('success', 'Payment method activated');
    }

    public function deletePayment(Request $request)
    {
        if (!Session::has('user')) {
            return redirect('/login');
        }

        $paymentId = $request->payment_id;
        $paymentType = $request->payment_type;

        if ($paymentType === 'creditcard') {
            DB::connection('mongodb')
                ->getMongoDB()
                ->selectCollection('creditcards')
                ->deleteOne(['_id' => new ObjectId($paymentId)]);
        } else {
            DB::connection('mongodb')
                ->getMongoDB()
                ->selectCollection('ewallets')
                ->deleteOne(['_id' => new ObjectId($paymentId)]);
        }

        return redirect('/profile')->with('success', 'Payment method deleted');
    }

    public function profile()
    {
        if (!Session::has('user')) {
            return redirect('/login');
        }

        $user = Session::get('user');
        
        // Get credit cards with type identifier
        $creditCards = DB::connection('mongodb')
            ->getMongoDB()
            ->selectCollection('creditcards')
            ->find(['user_id' => $user['_id']])
            ->toArray();

        // Add type identifier
        $creditCards = array_map(function($card) {
            $card['type'] = 'creditcard';
            return $card;
        }, $creditCards);

        // Get e-wallets with type identifier
        $eWallets = DB::connection('mongodb')
            ->getMongoDB()
            ->selectCollection('ewallets')
            ->find(['user_id' => $user['_id']])
            ->toArray();

        // Add type identifier
        $eWallets = array_map(function($wallet) {
            $wallet['type'] = 'ewallet';
            return $wallet;
        }, $eWallets);

        $payments = array_merge($creditCards, $eWallets);

        return view('profile', [
            'payments' => $payments,
            'user' => $user
        ]);
    }

    public function setInactive(Request $request)
{
    $paymentId = $request->input('payment_id');
    $type = $request->input('payment_type');
    
    $collection = $type === 'creditcard' ? 'creditcards' : 'ewallets';
    
    DB::connection('mongodb')
        ->getMongoDB()
        ->selectCollection($collection)
        ->updateOne(
            ['_id' => new \MongoDB\BSON\ObjectId($paymentId)],
            ['$set' => ['isActive' => false]]
        );
    
    return back()->with('success', 'Payment method set to inactive');
}
    public function showProfile()
    {
        $payments = $this->getPayments();
        return view('profile', ['payments' => $payments]);
    }
}