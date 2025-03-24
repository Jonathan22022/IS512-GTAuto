<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Tempat Service</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 p-6">

    <h1 class="text-3xl font-bold text-gray-800 mb-4">Edit Tempat Service</h1>

    <form action="{{ url('/update-tempat-service/' . $tempatService['_id']) }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded shadow-md w-full max-w-lg">
        @csrf

        <div class="mb-4">
            <label class="block text-gray-700">Nama Tempat Service</label>
            <input type="text" name="name" value="{{ $tempatService['name'] }}" class="w-full p-2 border border-gray-300 rounded" required>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700">Pemilik</label>
            <input type="text" name="pemilik" value="{{ $tempatService['pemilik'] }}" class="w-full p-2 border border-gray-300 rounded" required>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700">Gambar</label>
            <input type="file" name="gambar" class="w-full p-2 border border-gray-300 rounded">
            <img src="{{ asset($tempatService['gambar']) }}" alt="Gambar Tempat Service" class="w-32 h-32 mb-4">
        </div>

        <div class="mb-4">
            <label class="block text-gray-700">Jasa</label>
            <input type="text" name="jasa" value="{{ $tempatService['jasa'] }}" class="w-full p-2 border border-gray-300 rounded" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">Jam Operasional</label>
            <input type="text" name="jam" value="{{ $tempatService['jam'] }}" class="w-full p-2 border border-gray-300 rounded" required>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700">Hari Operasional</label>
            <select name="hari" class="w-full p-2 border border-gray-300 rounded mb-4" required>
                <option value="Senin" {{ $job['hari'] == 'Senin' ? 'selected' : '' }}>Senin</option>
                <option value="Selasa" {{ $job['hari'] == 'Selasa' ? 'selected' : '' }}>Selasa</option>
                <option value="Rabu" {{ $job['hari'] == 'Rabu' ? 'selected' : '' }}>Rabu</option>
                <option value="Kamis" {{ $job['hari'] == 'Kamis' ? 'selected' : '' }}>Kamis</option>
                <option value="Jumat" {{ $job['hari'] == 'Jumat' ? 'selected' : '' }}>Jumat</option>
                <option value="Sabtu" {{ $job['hari'] == 'Sabtu' ? 'selected' : '' }}>Sabtu</option>
                <option value="Minggu" {{ $job['hari'] == 'Minggu' ? 'selected' : '' }}>Minggu</option>
            </select>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700">Harga</label>
            <input type="number" name="price" value="{{ $tempatService['price'] }}" class="w-full p-2 border border-gray-300 rounded" required>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700">Deskripsi</label>
            <textarea name="description" class="w-full p-2 border border-gray-300 rounded" required>{{ $tempatService['description'] }}</textarea>
        </div>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Simpan Perubahan</button>
    </form>

</body>
</html>
