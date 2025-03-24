<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 flex justify-center items-center min-h-screen">
    <div class="bg-white p-6 rounded shadow-lg w-96">
        <h2 class="text-xl font-bold mb-4">Reset Password</h2>
        @if(session('error'))
            <p class="text-red-500">{{ session('error') }}</p>
        @endif
        <form action="/reset-password" method="POST">
            @csrf
            <input type="hidden" name="token" value="{{ request()->query('token') }}">
            <input type="password" name="password" placeholder="Masukkan password baru" required class="w-full p-2 border rounded mb-2">
            <button type="submit" class="w-full bg-green-500 text-white p-2 rounded">Reset Password</button>
        </form>
    </div>
</body>
</html>
