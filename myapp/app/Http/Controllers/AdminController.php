<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use App\Models\Job;
use App\Models\Product;
use App\Models\User;
use App\Models\TempatService;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        if (!Session::has('user') || Session::get('user')['role'] !== 'admin') {
            return redirect('/login')->with('error', 'Akses ditolak! Halaman ini hanya untuk admin.');
        }

        $selectedCollection = $request->get('collection', 'users'); 

        $collection = DB::connection('mongodb')->getMongoDB()->selectCollection($selectedCollection);
        $cursor = $collection->find();
        $data = iterator_to_array($cursor);

        return view('admin.admin', compact('data', 'selectedCollection'));
    }

}
