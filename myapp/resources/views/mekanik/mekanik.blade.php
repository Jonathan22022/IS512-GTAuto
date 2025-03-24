<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jasa Mekanik</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script>
        function confirmDelete(jobId) {
            if (confirm("Apakah Anda yakin ingin menghapus jasa ini?")) {
                document.getElementById('delete-form-' + jobId).submit();
            }
        }
    </script>
</head>
<body class="bg-gray-100 p-6">

    <h1 class="text-3xl font-bold text-gray-800 mb-4">Daftar Jasa Mekanik</h1>

    <a href="{{ url('/add-job') }}" class="bg-green-500 text-white px-4 py-2 rounded mb-4 inline-block">Tambah Jasa</a>

    @if(!empty($jobs) && count($jobs) > 0)
    <table class="table-auto w-full border-collapse border border-gray-200 mt-4">
        <thead>
            <tr class="bg-gray-300">
                <th class="border px-4 py-2">Nama Jasa</th>
                <th class="border px-4 py-2">Jam</th>
                <th class="border px-4 py-2">Hari</th>
                <th class="border px-4 py-2">Gambar</th>
                <th class="border px-4 py-2">Harga</th>
                <th class="border px-4 py-2">Deskripsi</th>
                <th class="border px-4 py-2">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($jobs as $job)
                <tr>
                    <td class="border px-4 py-2">{{ $job['name'] }}</td>
                    <td class="border px-4 py-2">{{ $job['jam'] }}</td>
                    <td class="border px-4 py-2">{{ $job['hari'] }}</td>
                    <td class="border px-4 py-2">
                        <img src="{{ asset($job['gambar']) }}" alt="Gambar Jasa" class="w-16 h-16">
                    </td>
                    <td class="border px-4 py-2">Rp{{ number_format($job['price'], 0, ',', '.') }}</td>
                    <td class="border px-4 py-2">{{ $job['description'] }}</td>
                    <td class="border px-4 py-2 flex space-x-2">
                        <!-- Tombol Edit -->
                        <a href="{{ url('/edit-job/' . $job['_id']) }}" class="bg-blue-500 text-white px-4 py-2 rounded">Edit</a>

                        <!-- Form untuk Delete -->
                        <form id="delete-form-{{ $job['_id'] }}" action="{{ url('/delete-job/' . $job['_id']) }}" method="POST" class="inline">
                            @csrf
                            <button type="button" onclick="confirmDelete('{{ $job['_id'] }}')" class="bg-red-500 text-white px-4 py-2 rounded">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@else
    <p class="text-gray-600 mt-4">Tidak ada jasa yang tersedia.</p>
@endif

</body>
</html>
