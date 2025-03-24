<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Jasa Mekanik</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 p-6">
    <h1 class="text-3xl font-bold text-gray-800 mb-4">Edit Jasa Mekanik</h1>

    @if ($errors->any())
        <div class="bg-red-500 text-white p-3 mb-4 rounded">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    
    <form action="{{ url('/update-job/' . $job['_id']) }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded shadow-md">
        @csrf

        <label class="block text-gray-700">Nama Jasa</label>
        <input type="text" name="name" value="{{ $job['name'] }}" class="w-full p-2 border border-gray-300 rounded mb-4" required>

        <label class="block text-gray-700">Hari</label>
        <select name="hari" class="w-full p-2 border border-gray-300 rounded mb-4" required>
            <option value="Senin" {{ $job['hari'] == 'Senin' ? 'selected' : '' }}>Senin</option>
            <option value="Selasa" {{ $job['hari'] == 'Selasa' ? 'selected' : '' }}>Selasa</option>
            <option value="Rabu" {{ $job['hari'] == 'Rabu' ? 'selected' : '' }}>Rabu</option>
            <option value="Kamis" {{ $job['hari'] == 'Kamis' ? 'selected' : '' }}>Kamis</option>
            <option value="Jumat" {{ $job['hari'] == 'Jumat' ? 'selected' : '' }}>Jumat</option>
            <option value="Sabtu" {{ $job['hari'] == 'Sabtu' ? 'selected' : '' }}>Sabtu</option>
            <option value="Minggu" {{ $job['hari'] == 'Minggu' ? 'selected' : '' }}>Minggu</option>
        </select>

        <label class="block text-gray-700">Jam</label>
        <input type="text" name="jam" value="{{ $job['jam'] }}" class="w-full p-2 border border-gray-300 rounded mb-4" required>

        <label class="block text-gray-700">Harga</label>
        <input type="number" name="price" value="{{ $job['price'] }}" class="w-full p-2 border border-gray-300 rounded mb-4" required>

        <label class="block text-gray-700">Deskripsi</label>
        <textarea name="description" class="w-full p-2 border border-gray-300 rounded mb-4" required>{{ $job['description'] }}</textarea>

        <label class="block text-gray-700">Gambar</label>
        <input type="file" name="gambar" class="w-full p-2 border border-gray-300 rounded mb-4">
        <p class="text-gray-500 text-sm">Biarkan kosong jika tidak ingin mengubah gambar.</p>

        <img src="{{ asset($job['gambar']) }}" alt="Gambar Jasa" class="w-32 h-32 mb-4">

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Simpan Perubahan</button>
    </form>
</body>
</html>
