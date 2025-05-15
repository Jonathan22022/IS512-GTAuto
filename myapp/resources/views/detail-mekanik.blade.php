<!-- detail-mekanik.blade.php -->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Detail Mekanik</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-b from-purple-300 to-white min-h-screen font-sans">

    <!-- Navbar -->
    <nav class="bg-white shadow-md py-3 px-6 flex justify-between items-center">
        <div class="flex gap-4 items-center">
            <input type="text" placeholder="Search for ..." class="border border-gray-300 px-4 py-2 rounded-lg w-80">
            <ul class="flex gap-6 text-sm text-gray-700">
                <li><a href="#" class="hover:text-purple-700">Mechanics</a></li>
                <li><a href="#" class="hover:text-purple-700">Shops</a></li>
                <li><a href="#" class="hover:text-purple-700">Services</a></li>
            </ul>
        </div>
        <img src="/path-to-your-logo.png" alt="GT Auto" class="h-12">
    </nav>

    <!-- Main Content -->
    <div class="flex flex-col md:flex-row p-8 gap-6 items-start">
        
        <!-- Map Section -->
        <div class="w-full md:w-1/3">
            <img src="/path-to-map.png" alt="Map" class="rounded-lg shadow-lg">
        </div>

        <!-- Info Section -->
        <div class="w-full md:w-2/3 space-y-6">
            <div>
                <h1 class="text-4xl font-bold text-gray-800">Jaya Abadi Auto</h1>
                <p class="text-xl font-semibold text-gray-600">3 km Away</p>
                <button class="mt-3 bg-yellow-400 hover:bg-yellow-500 text-white font-semibold px-6 py-2 rounded-full">
                    GO THERE
                </button>
            </div>

            <!-- Specialization -->
            <div class="bg-gray-900 text-white p-6 rounded-xl shadow-lg">
                <h2 class="text-lg font-bold mb-2">SPESIALISASI: REPARASI DAN PENGANTIAN TRANSMISI DAN DRIVETRAIN MOBIL</h2>
                <p class="text-sm leading-relaxed">
                    Kami menyediakan layanan menyeluruh untuk sistem transmisi dan drivetrain kendaraan Anda,
                    mulai dari pemeriksaan, perawatan rutin, hingga penggantian komponen.
                    Didukung oleh teknisi berpengalaman dan peralatan modern untuk memastikan performa mobil tetap optimal.
                </p>
            </div>

            <!-- Testimonial -->
            <div class="bg-white border rounded-lg shadow-md p-4">
                <p class="text-gray-800 text-lg">
                    <span class="font-semibold text-blue-600">We got trusted by more than <span class="text-blue-500">+300</span> happy customers.</span>
                </p>
                <div class="flex items-center mt-4">
                    <img src="/path-to-user-photo.png" alt="Customer" class="w-10 h-10 rounded-full mr-4">
                    <div>
                        <p class="italic text-gray-700">"i like it, it's very good, i would recommend."</p>
                        <p class="text-sm text-gray-500">Rizky Putra – Customer</p>
                    </div>
                </div>
                <div class="mt-4 text-right">
                    <a href="#" class="text-blue-600 text-sm underline">Read All reviews</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
