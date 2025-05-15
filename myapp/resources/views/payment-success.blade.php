<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Pembayaran Berhasil</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        // Redirect ke dashboard setelah 5 detik
        setTimeout(function() {
            window.location.href = '/dashboard';
        }, 5000);
    </script>
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex items-center justify-center">
        <div class="bg-white p-8 rounded-lg shadow-lg max-w-md w-full text-center">
            <div class="mb-6">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-gray-800 mb-2">Pembayaran Berhasil!</h1>
            <p class="text-gray-600 mb-6">Pesanan Anda telah diterima oleh penjual.</p>
            
            <div class="bg-gray-50 p-4 rounded-md mb-6">
                <div class="flex justify-between mb-2">
                    <span class="text-gray-600">Total Pembayaran:</span>
                    <span class="font-semibold">Rp {{ number_format($total, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Status:</span>
                    <span class="font-semibold text-green-600">Diterima Penjual</span>
                </div>
            </div>
            
            <p class="text-gray-500 text-sm">Anda akan dialihkan ke halaman dashboard dalam 5 detik...</p>
            
            <div class="mt-6">
                <a href="/dashboard" class="inline-block px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                    Ke Dashboard Sekarang
                </a>
            </div>
        </div>
    </div>
</body>
</html>