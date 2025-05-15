<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 bg-fixed bg-center bg-cover" style="background-image: url('{{ asset('Gambar Product/p.png') }}');">
    <!-- Sidebar -->
    <div id="sidebar" class="fixed top-0 left-0 w-64 h-full bg-white shadow-lg transform -translate-x-full transition-transform duration-300 z-50">
        <div class="p-4 border-b">
            <h2 class="text-xl font-bold">Menu</h2>
        </div>
        <ul class="p-4 space-y-4">
            <li><a href="{{ url('/dashboard') }}" class="block text-gray-700 hover:text-orange-600">Home</a></li>
            <li><a href="{{ url('/profile') }}" class="block text-gray-700 hover:text-orange-600">Profile</a></li>
            <li><a href="{{ url('/orders') }}" class="block text-gray-700 hover:text-orange-600">Orderan</a></li>
            <li><a href="{{ url('/Membership') }}" class="block text-gray-700 hover:text-orange-600">Membership</a></li>
            <li><a href="{{ url('/bookmark') }}" class="block text-gray-700 hover:text-orange-600">Bookmark</a></li>
            <li>
                <form action="{{ url('/logout') }}" method="POST" class="mt-6">
                @csrf
                    <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-700">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </button>
                </form>
            </li>
        </ul>
    </div>

    <!-- Overlay when sidebar is open -->
    <div id="overlay" class="fixed inset-0 bg-black bg-opacity-50 hidden z-40" onclick="toggleSidebar()"></div>

    <!-- Navigation -->
    <nav class="bg-orange-600 p-4 text-white flex justify-between items-center relative z-50">
        <div class="flex items-center space-x-4">
            <!-- Hamburger Button -->
            <button onclick="toggleSidebar()" class="focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
            <!-- Logo -->
            <a href="{{ url('/dashboard') }}" class="text-lg font-semibold">
                <img src="{{ asset('Gambar Product/f.png') }}" alt="GT Auto Logo" class="h-10">
            </a>
        </div>
    </nav>

    @if(session('success'))
    <div class="p-4 bg-green-200 text-green-800">
        {{ session('success') }}
    </div>
    <meta http-equiv="refresh" content="5;url=/dashboard">
    @endif

    <!-- Main Content -->
    <div class="max-w-6xl mx-auto mt-10 p-6 bg-white shadow-md rounded-md">
        <h2 class="text-2xl font-semibold text-center mb-6">Find Services</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <a href="{{ url('/whyus') }}" class="block bg-blue-500 text-white p-6 rounded-lg shadow-md hover:bg-blue-700 transition">
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

    <!-- Script to toggle sidebar -->
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('overlay');
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        }
    </script>
</body>
</html>
