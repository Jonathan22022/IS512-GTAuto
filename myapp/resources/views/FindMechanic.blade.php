<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Cari Mekanik</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-gradient-to-b from-purple-300 to-white min-h-screen font-sans">
    <!-- Header -->
    <div class="flex items-center justify-between px-8 py-4 bg-white shadow-md">
        <div class="text-3xl font-bold text-purple-800">
            <span class="text-black">GT</span><span class="text-purple-600">AUTO</span>
            <span class="text-sm block text-gray-500">CAR MAINTENANCE & SERVICE</span>
        </div>
        <input type="text" placeholder="Search for ..." class="border rounded-full px-4 py-2 w-1/3">
        <div class="space-x-4">
            <select class="border px-2 py-1 rounded-md text-gray-700">
                <option>Mechanics</option>
            </select>
            <select class="border px-2 py-1 rounded-md text-gray-700">
                <option>Shops</option>
            </select>
            <select class="border px-2 py-1 rounded-md text-gray-700">
                <option>Services</option>
            </select>
        </div>
    </div>

    <div class="flex">
        <!-- Mekanik List -->
        <div class="w-3/4 p-6 grid grid-cols-2 gap-4">
            <!-- Card Mekanik (Example) -->
            <div class="flex items-center space-x-4 border rounded-lg shadow p-4 bg-white">
                <img src="https://via.placeholder.com/64" alt="Icon" class="rounded">
                <div class="flex-grow">
                    <div class="font-semibold">Jaya Abadi Auto</div>
                    <div class="text-green-500 text-sm">3 KM AWAY</div>
                    <div class="text-gray-600 text-sm">Spesialisasi Transmisi Kendaraan</div>
                    <div class="text-yellow-500">★★★★★</div>
                    <div class="text-xs text-blue-600">183 reviews</div>
                </div>
                <div class="space-y-2">
                    <button class="bg-orange-400 text-white px-3 py-1 rounded">Mark Location</button>
                    <button class="bg-gray-100 text-gray-800 px-3 py-1 rounded border">Bookmark</button>
                </div>
            </div>
        </div>

        <!-- Sidebar Gambar Mobil -->
        <div class="w-1/4 p-6">
            <img src="" alt="Car" class="rounded-lg shadow-lg">
        </div>
    </div>
</body>
</html>
