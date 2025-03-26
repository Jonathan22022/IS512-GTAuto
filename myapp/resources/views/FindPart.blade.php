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
