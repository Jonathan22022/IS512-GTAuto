<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use App\Models\TempatService;

class TempatServiceController extends Controller
{
    /**
     * Menampilkan daftar tempat service milik pengguna yang sedang login.
     */
    public function index()
    {
        if (!Session::has('user') || Session::get('user')['role'] !== 'service') {
            return redirect('/login')->with('error', 'Akses ditolak! Halaman ini hanya untuk tempat service.');
        }

        $user = Session::get('user');

        $tempatServicesCursor = DB::connection('mongodb')->getMongoDB()->selectCollection('tempatService')
            ->find(['user_id' => new \MongoDB\BSON\ObjectId($user['_id'])]);

        $tempatServices = iterator_to_array($tempatServicesCursor);

        return view('TempatService.tempatservice', ['tempatService' => $tempatServices]);
    }

    /**
     * Menampilkan halaman tambah tempat service.
     */
    public function create()
    {
        if (!Session::has('user') || Session::get('user')['role'] !== 'service') {
            return redirect('/login')->with('error', 'Akses ditolak! Halaman ini hanya untuk tempat service.');
        }

        return view('TempatService.addtempatservice');
    }

    /**
     * Menyimpan data tempat service baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'pemilik' => 'required|string|max:255',
            'gambar' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'jasa' => 'required|string',
            'jam' => 'required|string|regex:/^\d{2}:\d{2} - \d{2}:\d{2}$/',
            'hari' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu',
            'price' => 'required|numeric|min:0',
            'description' => 'required|string',
        ]);

        $imagePath = $request->file('gambar')->store('uploads', 'public');
        $user = Session::get('user');

        DB::connection('mongodb')->getMongoDB()->selectCollection('tempatService')->insertOne([
            'name' => $request->name,
            'pemilik' => $request->pemilik,
            'gambar' => "/storage/$imagePath",
            'jasa' => $request->jasa,
            'jam' => $request->jam,
            'hari' => $request->hari,
            'price' => $request->price,
            'description' => $request->description,
            'user_id' => $user['_id']
        ]);

        return redirect('/TempatService/tempatservice')->with('success', 'Tempat service berhasil ditambahkan!');
    }

    /**
     * Menampilkan halaman edit tempat service.
     */
    public function edit($id)
    {
        $tempatService = DB::connection('mongodb')->getMongoDB()->selectCollection('tempatService')
            ->findOne(['_id' => new \MongoDB\BSON\ObjectId($id)]);

        return view('TempatService.edittempatservice', ['tempatService' => $tempatService]);
    }

    /**
     * Memperbarui data tempat service.
     */
    public function update(Request $request, $id)
    {
        if (!Session::has('user') || Session::get('user')['role'] !== 'service') {
            return redirect('/login')->with('error', 'Akses ditolak! Halaman ini hanya untuk tempat service.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'pemilik' => 'required|string|max:255',
            'jasa' => 'required|string',
            'jam' => 'required|string|regex:/^\d{2}:\d{2} - \d{2}:\d{2}$/',
            'hari' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu',
            'price' => 'required|numeric|min:0',
            'description' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $tempatService = DB::connection('mongodb')->getMongoDB()->selectCollection('tempatService')
            ->findOne(['_id' => new \MongoDB\BSON\ObjectId($id)]);

        if (!$tempatService) {
            return redirect()->back()->with('error', 'Tempat service tidak ditemukan.');
        }

        $imagePath = $tempatService['gambar'];
        if ($request->hasFile('gambar')) {
            $imagePath = $request->file('gambar')->store('uploads', 'public');
            $imagePath = "/storage/$imagePath";
        }

        DB::connection('mongodb')->getMongoDB()->selectCollection('tempatService')->updateOne(
            ['_id' => new \MongoDB\BSON\ObjectId($id)],
            ['$set' => [
                'name' => $request->name,
                'pemilik' => $request->pemilik,
                'jasa' => $request->jasa,
                'jam' => $request->jam,
                'hari' => $request->hari,
                'price' => $request->price,
                'description' => $request->description,
                'gambar' => $imagePath
            ]]
        );

        return redirect('/TempatService/tempatservice')->with('success', 'Tempat service berhasil diperbarui.');
    }

    /**
     * Menghapus tempat service.
     */
    public function destroy($id)
    {
        DB::connection('mongodb')->getMongoDB()->selectCollection('tempatService')
            ->deleteOne(['_id' => new \MongoDB\BSON\ObjectId($id)]);

        return redirect('/TempatService/tempatservice')->with('success', 'Tempat service berhasil dihapus.');
    }
}
