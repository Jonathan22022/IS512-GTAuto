<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 p-10">

    <h1 class="text-3xl font-bold text-gray-800 mb-6">Admin Panel</h1>

    <div class="mb-6">
        <form method="GET" action="{{ route('admin.admin') }}">
            <label for="collection" class="block text-sm font-medium text-gray-700">Select Collection</label>
            <select name="collection" id="collection" onchange="this.form.submit()" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                <option value="users" {{ $selectedCollection == 'users' ? 'selected' : '' }}>Users</option>
                <option value="jobs" {{ $selectedCollection == 'jobs' ? 'selected' : '' }}>Jobs</option>
                <option value="products" {{ $selectedCollection == 'products' ? 'selected' : '' }}>Products</option>
                <option value="tempatService" {{ $selectedCollection == 'tempatService' ? 'selected' : '' }}>Tempat Service</option>
            </select>
        </form>
    </div>

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <table class="min-w-full border border-gray-300">
            <thead>
                <tr class="bg-gray-200 text-gray-700">
                    @if($selectedCollection == 'users')
                        <th class="border px-4 py-2">ID</th>
                        <th class="border px-4 py-2">Username</th>
                        <th class="border px-4 py-2">Email</th>
                        <th class="border px-4 py-2">Nomor HP</th>
                        <th class="border px-4 py-2">Alamat</th>
                        <th class="border px-4 py-2">Role</th>
                    @elseif($selectedCollection == 'jobs')
                        <th class="border px-4 py-2">ID</th>
                        <th class="border px-4 py-2">Job Name</th>
                        <th class="border px-4 py-2">Jam</th>
                        <th class="border px-4 py-2">Hari</th>
                        <th class="border px-4 py-2">Description</th>
                        <th class="border px-4 py-2">Gambar</th>
                        <th class="border px-4 py-2">User ID</th>
                    @elseif($selectedCollection == 'tempatService')
                        <th class="border px-4 py-2">Nama</th>
                        <th class="border px-4 py-2">Pemilik</th>
                        <th class="border px-4 py-2">Gambar</th>
                        <th class="border px-4 py-2">Jasa</th>
                        <th class="border px-4 py-2">Jam Operasional</th>
                        <th class="border px-4 py-2">Hari Operasional</th>
                        <th class="border px-4 py-2">Harga</th>
                        <th class="border px-4 py-2">Deskripsi</th>
                    @elseif($selectedCollection == 'products')
                        <th class="border px-4 py-2">ID</th>
                        <th class="border px-4 py-2">Product Name</th>
                        <th class="border px-4 py-2">Price</th>
                        <th class="border px-4 py-2">Description</th>
                        <th class="border px-4 py-2">Gambar</th>
                        <th class="border px-4 py-2">User ID</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach($data as $item)
                    <tr class="bg-white hover:bg-gray-100">
                        @if($selectedCollection == 'users')
                            <td class="border px-4 py-2">{{ $item->_id }}</td>
                            <td class="border px-4 py-2">{{ $item->username }}</td>
                            <td class="border px-4 py-2">{{ $item->email }}</td>
                            <td class="border px-4 py-2">{{ $item->nomor_hp }}</td>
                            <td class="border px-4 py-2">{{ $item->alamat }}</td>
                            <td class="border px-4 py-2">{{ $item->role }}</td>
                        @elseif($selectedCollection == 'jobs')
                            <td class="border px-4 py-2">{{ $item->_id }}</td>
                            <td class="border px-4 py-2">{{ $item->name }}</td>
                            <td class="border px-4 py-2">{{ $item->jam }}</td>
                            <td class="border px-4 py-2">{{ $item->hari }}</td>
                            <td class="border px-4 py-2">{{ $item->description }}</td>
                            <td class="border px-4 py-2">{{ $item->gambar }}</td>
                            <td class="border px-4 py-2">{{ $item->user_id }}</td>
                        @elseif($selectedCollection == 'tempatService')
                            <td class="border px-4 py-2">{{ $item->_id }}</td>
                            <td class="border px-4 py-2">{{ $item->name }}</td>
                            <td class="border px-4 py-2">{{ $item->pemilik }}</td>
                            <td class="border px-4 py-2">{{ $item->jasa }}</td>
                            <td class="border px-4 py-2">{{ $item->jam }}</td>
                            <td class="border px-4 py-2">{{ $item->hari }}</td>
                            <td class="border px-4 py-2">{{ $item->price }}</td>
                            <td class="border px-4 py-2">{{ $item->description }}</td>
                            <td class="border px-4 py-2">{{ $item->user_id }}</td>
                        @elseif($selectedCollection == 'products')
                            <td class="border px-4 py-2">{{ $item->_id }}</td>
                            <td class="border px-4 py-2">{{ $item->name }}</td>
                            <td class="border px-4 py-2">{{ $item->price }}</td>
                            <td class="border px-4 py-2">{{ $item->description }}</td>
                            <td class="border px-4 py-2">{{ $item->gambar }}</td>
                            <td class="border px-4 py-2">{{ $item->user_id }}</td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</body>
</html>