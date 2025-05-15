<!--FindPart.blade.php-->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
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

    <!-- Search Bar -->
    <div class="max-w-6xl mx-auto mt-6 p-4 bg-white shadow-md rounded-md flex justify-end space-x-4">
        <select id="filterType" class="border p-2 rounded-md">
            <option value="username">Username</option>
            <option value="alamat">Alamat</option>
        </select>
        <input type="text" id="searchInput" class="border p-2 rounded-md w-1/3" placeholder="Cari...">
    </div>

    <div class="max-w-6xl mx-auto mt-6 p-6 bg-white shadow-md rounded-md">
    <!-- Grid Container -->
    <div id="userContainer" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">
        @foreach($users as $user)
            @if($user->role === 'penjual')
                <div 
                    class="user-card bg-white shadow-md rounded-lg overflow-hidden p-4 cursor-pointer" 
                    data-username="{{ $user->username }}" 
                    data-alamat="{{ $user->alamat }}" 
                    onclick="redirectToDetail( '{{ $user->username }}', '{{ $user->alamat }}')"
                >
                    <img src="{{ asset('storage/gambar.png') }}" class="w-full h-32 object-cover" alt="Penjual">
                    <h5 class="font-bold text-lg">{{ $user->username }}</h5>
                    <p class="text-sm text-gray-600"><strong>Alamat:</strong> {{ $user->alamat }}</p>
                </div>
            @endif
        @endforeach
    </div>
</div>

    <script>
    function redirectToDetail(username, alamat) {
    let url = `/detail-penjual?username=${encodeURIComponent(username)}`;
    window.location.href = url;
}
        document.getElementById('searchInput').addEventListener('input', function () {
            let filterType = document.getElementById('filterType').value;
            let searchValue = this.value.toLowerCase();
            let userCards = document.querySelectorAll('.user-card');

            userCards.forEach(card => {
                let value = card.getAttribute(`data-${filterType}`).toLowerCase();
                if (value.includes(searchValue)) {
                    card.style.display = "block";
                } else {
                    card.style.display = "none";
                }
            });
        });
    </script>

</body>
</html>

