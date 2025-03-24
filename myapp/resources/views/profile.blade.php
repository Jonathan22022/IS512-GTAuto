<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <nav class="bg-blue-600 p-4 text-white flex justify-between items-center">
        <div class="text-lg font-bold">Dashboard</div>
        <ul class="flex space-x-4">
            <li><a href="{{ url('/dashboard') }}" class="hover:underline">Beranda</a></li>
            <li><a href="{{ url('/profile') }}" class="hover:underline">Profil</a></li>
            <li><a href="#" class="hover:underline">Pengaturan</a></li>
        </ul>
    </nav>
    
    <div class="max-w-4xl mx-auto mt-10 p-6 bg-white shadow-md rounded-md">
        <h2 class="text-2xl font-semibold">Selamat Datang, {{ session('user')['username'] }}</h2>
        <p class="mt-2">Email: {{ session('user')['email'] }}</p>
        <p>Nomor HP: {{ session('user')['nomor_hp'] }}</p>
        <p>Alamat: {{ session('user')['alamat'] }}</p>
        <p>Role: {{ session('user')['role'] }}</p>
        <br>
        <form action="{{ url('/logout') }}" method="POST">
            @csrf
            <button type="submit" class="mt-4 bg-red-500 text-white px-4 py-2 rounded hover:bg-red-700">Logout</button>
        </form>
    </div>
</body>
</html>
