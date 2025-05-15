<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Pengguna</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen bg-fixed bg-center bg-cover" style="background-image: url('{{ asset('Gambar Product/p.png') }}');">
    <div class="bg-white/30 backdrop-blur-md border text-white border-white p-8 rounded-lg shadow-md w-full max-w-md">
        <h2 class="text-2xl font-bold text-center mb-6">Formulir Registrasi</h2>

        @if (session('success'))
            <div id="alert-success" class="bg-green-100 text-green-800 px-4 py-2 mb-4 rounded">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div id="alert-error" class="bg-red-100 text-red-800 px-4 py-2 mb-4 rounded">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ url('/register') }}" method="POST">
            @csrf
            <label class="block mb-2">Username:</label>
            <input type="text" name="username" class="w-full border text-black px-3 py-2 rounded mb-4" required>

            <label class="block mb-2">Email:</label>
            <input type="email" name="email" class="w-full border text-black px-3 py-2 rounded mb-4" required>

            <label class="block mb-2">Password:</label>
            <input type="password" name="password" class="w-full border text-black px-3 py-2 rounded mb-4" required>

            <label class="block mb-2">Nomor HP:</label>
            <input type="text" name="nomor_hp" class="w-full border text-black px-3 py-2 rounded mb-4" required>
            
            <input type="hidden" name="alamat" id="alamat">
            <button type="submit" class="w-full bg-orange-600 text-white py-2 rounded hover:bg-orange-700">Register</button>
        </form>

        <p class="mt-4 text-center">Sudah punya akun?
            <a href="{{ url('/login') }}" class="text-orange-600 hover:underline">Login</a>
        </p>
    </div>

    <script>
        setTimeout(() => {
            const success = document.getElementById('alert-success');
            const error = document.getElementById('alert-error');
            if (success) success.style.display = 'none';
            if (error) error.style.display = 'none';
        }, 5000);
        document.addEventListener("DOMContentLoaded", function () {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(async function (position) {
                    let lat = position.coords.latitude;
                    let lng = position.coords.longitude;

                    const response = await fetch(`/reverse-geocode?lat=${lat}&lng=${lng}`);
                    const data = await response.json();

                    if (data.success) {
                        document.getElementById('alamat').value = data.alamat;
                    }
                });
            } else {
                alert("Geolocation tidak didukung browser ini.");
            }
        });
    </script>
</body>
</html>
