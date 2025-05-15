<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use App\Models\Job;

class JobController extends Controller
{
    public function index()
    {
        if (!Session::has('user') || Session::get('user')['role'] !== 'mekanik') {
            return redirect('/login')->with('error', 'Akses ditolak! Halaman ini hanya untuk mekanik.');
        }

        $user = Session::get('user');

        $jobsCursor = DB::connection('mongodb')->getMongoDB()->selectCollection('jobs')
            ->find(['user_id' => new \MongoDB\BSON\ObjectId($user['_id'])]);
        $jobs = iterator_to_array($jobsCursor);

        return view('mekanik.mekanik', ['jobs' => $jobs]);
    
    }
    public function create()
{
    if (!Session::has('user') || Session::get('user')['role'] !== 'mekanik') {
        return redirect('/login')->with('error', 'Akses ditolak! Halaman ini hanya untuk mekanik.');
    }

    return view('mekanik.AddJasa');
}

public function store(Request $request)
{
    if (!Session::has('user') || Session::get('user')['role'] !== 'mekanik') {
        return redirect('/login')->with('error', 'Akses ditolak! Halaman ini hanya untuk mekanik.');
    }

    $request->validate([
        'name' => 'required|string|max:255',            
        'hari' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu',
        'jam' => 'required|string|regex:/^\d{2}:\d{2} - \d{2}:\d{2}$/',
        'price' => 'required|numeric',
        'description' => 'required|string',
        'gambar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);
    // Simpan gambar
    $imagePath = $request->file('gambar')->store('uploads', 'public');

    // Ambil user yang sedang login
    $user = Session::get('user');

    DB::connection('mongodb')->getMongoDB()->selectCollection('jobs')->insertOne([
        'name' => $request->name,
        'jam' => $request->jam,
        'hari' => $request->hari,
        'price' => $request->price,
        'description' => $request->description,
        'gambar' => "/storage/$imagePath",
        'user_id' => new \MongoDB\BSON\ObjectId($user['_id']),
    ]);

    return redirect()->route('mekanik.mekanik')->with('success', 'Jasa berhasil ditambahkan.');
}

public function destroy($id)
{
    DB::connection('mongodb')->getMongoDB()->selectCollection('jobs')
        ->deleteOne(['_id' => new \MongoDB\BSON\ObjectId($id)]);

    return redirect('/mekanik/mekanik')->with('success', 'Produk berhasil dihapus.');
}
public function edit($id)
{
    $job = DB::connection('mongodb')->getMongoDB()->selectCollection('jobs')
        ->findOne(['_id' => new \MongoDB\BSON\ObjectId($id)]);

    return view('mekanik.EditJasa', ['job' => $job]);
}
public function update(Request $request, $id)
{
    if (!Session::has('user') || Session::get('user')['role'] !== 'mekanik') {
        return redirect('/login')->with('error', 'Akses ditolak! Halaman ini hanya untuk mekanik.');
    }

    $request->validate([
        'name' => 'required|string|max:255',
        'hari' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu',
        'jam' => 'required|string|regex:/^\d{2}:\d{2} - \d{2}:\d{2}$/',
        'price' => 'required|numeric',
        'description' => 'required|string',
        'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    // Ambil job berdasarkan ID
    $job = DB::connection('mongodb')->getMongoDB()->selectCollection('jobs')->findOne(['_id' => new \MongoDB\BSON\ObjectId($id)]);

    if (!$job) {
        return redirect()->back()->with('error', 'Jasa tidak ditemukan.');
    }

    // Simpan gambar jika ada
    $imagePath = $job['gambar']; // Gunakan gambar lama jika tidak ada yang baru diupload
    if ($request->hasFile('gambar')) {
        $imagePath = $request->file('gambar')->store('uploads', 'public');
        $imagePath = "/storage/$imagePath";
    }

    DB::connection('mongodb')->getMongoDB()->selectCollection('jobs')->updateOne(
        ['_id' => new \MongoDB\BSON\ObjectId($id)],
        ['$set' => [
            'name' => $request->name,
            'hari' => $request->hari,
            'jam' => $request->jam,
            'price' => $request->price,
            'description' => $request->description,
            'gambar' => $imagePath
        ]]
    );

    return redirect()->route('mekanik.mekanik')->with('success', 'Jasa berhasil diperbarui.');
}


}
