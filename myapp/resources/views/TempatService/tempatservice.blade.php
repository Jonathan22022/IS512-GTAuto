<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Tempat Service</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script>
        function confirmDelete(serviceId) {
            if (confirm("Apakah Anda yakin ingin menghapus tempat service ini?")) {
                document.getElementById('delete-form-' + serviceId).submit();
            }
        }
    </script>
</head>
<body class="bg-gray-100 p-6">
    <h1 class="text-3xl font-bold text-gray-800 mb-4">Daftar Tempat Service</h1>

    @if(!empty($tempatService) && count($tempatService) > 0)
    <table class="table-auto w-full border-collapse border border-gray-200">
        <thead>
            <tr class="bg-gray-300">
                <th class="border px-4 py-2">Nama</th>
                <th class="border px-4 py-2">Pemilik</th>
                <th class="border px-4 py-2">Gambar</th>
                <th class="border px-4 py-2">Jasa</th>
                <th class="border px-4 py-2">Jam Operasional</th>
                <th class="border px-4 py-2">Hari Operasional</th>
                <th class="border px-4 py-2">Harga</th>
                <th class="border px-4 py-2">Deskripsi</th>
                <th class="border px-4 py-2">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tempatService as $service)
                <tr>
                    <td class="border px-4 py-2">{{ $service['name'] }}</td>
                    <td class="border px-4 py-2">{{ $service['pemilik'] }}</td>
                    <td class="border px-4 py-2">
                        <img src="{{ asset($service['gambar']) }}" alt="Gambar Tempat Service" class="w-16 h-16">
                    </td>
                    <td class="border px-4 py-2">{{ $service['jasa'] }}</td>       
                    <td class="border px-4 py-2">{{ $service['jam'] }}</td>
                    <td class="border px-4 py-2">{{ $service['hari'] }}</td>
                    <td class="border px-4 py-2">Rp{{ number_format($service['price'], 0, ',', '.') }}</td>
                    <td class="border px-4 py-2">{{ $service['description'] }}</td>
                    <td class="border px-4 py-2 flex space-x-2">
                        <a href="{{ url('/edit-tempat-service/' . $service['_id']) }}" class="bg-blue-500 text-white px-4 py-2 rounded">Edit</a>
                        <form id="delete-form-{{ $service['_id'] }}" action="{{ url('/delete-tempat-service/' . $service['_id']) }}" method="POST" class="inline">
                            @csrf
                            <button type="button" onclick="confirmDelete('{{ $service['_id'] }}')" class="bg-red-500 text-white px-4 py-2 rounded">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    @else
        <p class="text-gray-600">Tidak ada tempat service yang tersedia.</p>
    @endif
    
    <a href="{{ url('/add-tempat-service') }}" class="bg-green-500 text-white px-4 py-2 rounded mb-4 inline-block">Tambah Tempat Service</a>
</body>
</html>
