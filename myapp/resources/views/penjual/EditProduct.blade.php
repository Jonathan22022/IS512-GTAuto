<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 p-6">

    <h1 class="text-3xl font-bold text-gray-800 mb-4">Edit Produk</h1>

    <form action="{{ url('/update-product/' . $product['_id']) }}" method="POST" enctype="multipart/form-data">
        @csrf

        <label class="block text-gray-700">Nama Produk</label>
        <input type="text" name="name" value="{{ $product['name'] }}" class="w-full p-2 border border-gray-300 rounded mb-4" required>

        <label class="block text-gray-700">Jumlah Barang</label>
        <input type="number" name="jumlahBarang" value="{{ $product['jumlahBarang'] }}" class="w-full p-2 border border-gray-300 rounded mb-4" required>

        <label class="block text-gray-700">Harga</label>
        <input type="number" name="price" value="{{ $product['price'] }}" class="w-full p-2 border border-gray-300 rounded mb-4" required>

        <label class="block text-gray-700">Deskripsi</label>
        <textarea name="description" class="w-full p-2 border border-gray-300 rounded mb-4" required>{{ $product['description'] }}</textarea>

        <label class="block text-gray-700">Gambar Produk</label>
        <input type="file" name="gambar" class="w-full p-2 border border-gray-300 rounded mb-4">
        <img src="{{ asset($product['gambar']) }}" alt="Gambar Produk" class="w-32 h-32 mb-4">

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Simpan Perubahan</button>
    </form>

</body>
</html>
