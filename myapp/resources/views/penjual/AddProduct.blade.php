<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 p-6">

    <h1 class="text-3xl font-bold text-gray-800 mb-4">Tambah Produk</h1>

    @if(session('success'))
        <p class="bg-green-500 text-white p-2 rounded">{{ session('success') }}</p>
    @endif

    <form action="{{ url('/add-product') }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded shadow-md w-full max-w-lg">
        @csrf

        <div class="mb-4">
            <label class="block text-gray-700">Nama Produk</label>
            <input type="text" name="name" class="w-full p-2 border border-gray-300 rounded" required>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700">Jumlah Barang</label>
            <input type="number" name="jumlahBarang" class="w-full p-2 border border-gray-300 rounded" required>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700">Gambar</label>
            <input type="file" name="gambar" class="w-full p-2 border border-gray-300 rounded" required>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700">Harga</label>
            <input type="number" name="price" class="w-full p-2 border border-gray-300 rounded" required>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700">Deskripsi</label>
            <textarea name="description" class="w-full p-2 border border-gray-300 rounded" required></textarea>
        </div>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Tambah Produk</button>
    </form>

</body>
</html>

