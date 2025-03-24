<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <nav class="bg-blue-600 p-4 text-white flex justify-between items-center">
        <div class="text-lg font-bold">Dashboard</div>
        <ul class="flex space-x-4">
            <li><a href="{{ url('/dashboard') }}" class="hover:underline">Beranda</a></li>
            <li><a href="{{ url('/profile') }}" class="hover:underline">Profil</a></li>
            <li><a href="{{ url('/settings') }}" class="hover:underline">Pengaturan</a></li>
        </ul>
    </nav>
    
    <div class="max-w-6xl mx-auto mt-10 p-6 bg-white shadow-md rounded-md">
        <h2 class="text-2xl font-semibold text-center mb-6">Find Services</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <a href="{{ url('/findMaintenanceCentre') }}" class="block bg-blue-500 text-white p-6 rounded-lg shadow-md hover:bg-blue-700 transition">
                <h3 class="text-lg font-semibold">Find a Maintenance Centre</h3>
                <p class="mt-2">Locate nearby maintenance centres for your vehicle.</p>
            </a>

            <a href="{{ url('/findMechanic') }}" class="block bg-green-500 text-white p-6 rounded-lg shadow-md hover:bg-green-700 transition">
                <h3 class="text-lg font-semibold">Find a Mechanic</h3>
                <p class="mt-2">Find experienced mechanics to fix your car.</p>
            </a>

            <a href="{{ url('/findPart') }}" class="block bg-red-500 text-white p-6 rounded-lg shadow-md hover:bg-red-700 transition">
                <h3 class="text-lg font-semibold">Find a Part</h3>
                <p class="mt-2">Search for spare parts available near you.</p>
            </a>
        </div>
    </div>
</body>
</html>
