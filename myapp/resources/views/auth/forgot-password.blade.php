<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 flex justify-center items-center min-h-screen">
    <div class="bg-white p-6 rounded shadow-lg w-96">
        <h2 class="text-xl font-bold mb-4">Lupa Password</h2>
        @if(session('error'))
            <p class="text-red-500">{{ session('error') }}</p>
        @endif
        @if(session('success'))
            <p class="text-green-500">{{ session('success') }}</p>
        @endif
        <form action="/forgot-password" method="POST">
            @csrf
            <input type="email" name="email" placeholder="Masukkan email" required class="w-full p-2 border rounded mb-2">
            <button type="submit" class="w-full bg-blue-500 text-white p-2 rounded">Kirim Link Reset</button>
        </form>
    </div>
</body>
</html>
