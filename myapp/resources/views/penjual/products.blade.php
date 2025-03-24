<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produk Penjual</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script>
        function confirmDelete(productId) {
            if (confirm("Apakah Anda yakin ingin menghapus produk ini?")) {
                document.getElementById('delete-form-' + productId).submit();
            }
        }
    </script>
</head>
<body class="bg-gray-100 p-6">

    <h1 class="text-3xl font-bold text-gray-800 mb-4">Daftar Produk Penjual</h1>

    @if(!empty($products) && count($products) > 0)
    <table class="table-auto w-full border-collapse border border-gray-200">
        <thead>
            <tr class="bg-gray-300">
                <th class="border px-4 py-2">Nama</th>
                <th class="border px-4 py-2">Jumlah</th>
                <th class="border px-4 py-2">Gambar</th>
                <th class="border px-4 py-2">Harga</th>
                <th class="border px-4 py-2">Deskripsi</th>
                <th class="border px-4 py-2">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
                <tr>
                    <td class="border px-4 py-2">{{ $product['name'] }}</td>
                    <td class="border px-4 py-2">{{ $product['jumlahBarang'] }}</td>
                    <td class="border px-4 py-2">
                        <img src="{{ asset($product['gambar']) }}" alt="Gambar Produk" class="w-16 h-16">
                    </td>
                    <td class="border px-4 py-2">Rp{{ number_format($product['price'], 0, ',', '.') }}</td>
                    <td class="border px-4 py-2">{{ $product['description'] }}</td>
                    <td class="border px-4 py-2 flex space-x-2">
                        <!-- Tombol Edit -->
                        <a href="{{ url('/edit-product/' . $product['_id']) }}" class="bg-blue-500 text-white px-4 py-2 rounded">Edit</a>

                        <!-- Form untuk Delete -->
                        <form id="delete-form-{{ $product['_id'] }}" action="{{ url('/delete-product/' . $product['_id']) }}" method="POST" class="inline">
                            @csrf
                            <button type="button" onclick="confirmDelete('{{ $product['_id'] }}')" class="bg-red-500 text-white px-4 py-2 rounded">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@else
    <p class="text-gray-600">Tidak ada produk yang tersedia.</p>
@endif
<a href="{{ url('/add-product') }}" class="bg-green-500 text-white px-4 py-2 rounded mb-4 inline-block">Tambah Produk</a>

</body>
</html>
