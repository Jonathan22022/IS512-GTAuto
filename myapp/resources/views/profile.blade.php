<!--Masih error-->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
    <div class="max-w-4xl mx-auto mt-4">
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    </div>
@endif

@if(session('error'))
    <div class="max-w-4xl mx-auto mt-4">
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    </div>
@endif
    <div class="max-w-4xl mx-auto mt-10 p-6 bg-white shadow-md rounded-md">
        <img src="{{ session('user')['avatar']}}"/>
        <h2 class="text-2xl font-semibold">Selamat Datang, {{ session('user')['username'] }}</h2>
        <p class="mt-2">Email: {{ session('user')['email'] }}</p>
        <p>Nomor HP: {{ session('user')['nomor_hp'] }}</p>
        <p>Alamat: {{ session('user')['alamat'] }}</p>
        <div class="mt-4 border-t pt-4">
    <h3 class="text-lg font-semibold">Membership Status</h3>
    @if(session('user')['memberShip'] !== 'none')
        <div class="mt-2 p-3 bg-green-100 border border-green-200 rounded">
            <p class="font-medium">Anda memiliki membership:</p>
            <p class="text-lg text-orange-600 font-bold">
                {{ session('user')['memberShip'] === 'loyal' ? 'Loyal Members' : 'GT AUTO Plus' }}
                ({{ session('user')['membership_duration'] === 'monthly' ? 'Bulanan' : 'Tahunan' }})
            </p>
            <p class="mt-1">Berlaku hingga: {{ \Carbon\Carbon::parse(session('user')['membership_expiry'])->format('d F Y') }}</p>
            
            @if(session('user')['memberShip'] === 'plus')
                <p class="mt-2 text-sm">✅ Akses penuh ke semua fitur premium</p>
                <p class="mt-1 text-sm">✅ Referral Bonuses</p>
                <p class="mt-1 text-sm">✅ Networking Opportunities</p>
            @else
                <p class="mt-2 text-sm">✅ Monthly Free Discounts</p>
                <p class="mt-1 text-sm">✅ Queue Fast Pass</p>
                <p class="mt-1 text-sm">✅ Giveaway Rewards</p>
            @endif
        </div>
    @else
        <div class="mt-2 p-3 bg-blue-50 border border-blue-200 rounded">
            <p>Anda belum memiliki membership.</p>
            <a href="{{ url('/Membership') }}" class="mt-2 inline-block bg-orange-600 text-white px-4 py-2 rounded hover:bg-orange-700">
                Dapatkan Membership Sekarang
            </a>
        </div>
    @endif
</div>
        <div class="mt-4 border-t pt-4">
            <div class="flex justify-between items-center">
                <h3 class="text-lg font-semibold">Payment Methods</h3>
                <a href="{{ url('/add-payment') }}" class="text-blue-600 hover:text-blue-800">
                    <i class="fas fa-plus-circle"></i> Tambah Payment
                </a>
            </div>
            
            @if(isset($payments) && count($payments) > 0)
            <div class="mt-4 space-y-3">
                @foreach($payments as $payment)
                <div class="p-3 border rounded-lg flex justify-between items-center 
                    {{ $payment['isActive'] ? 'bg-blue-50 border-blue-200' : '' }}">
                    <div>
                        @if($payment['type'] === 'creditcard')
                            <p class="font-medium">Credit Card: {{ $payment['cardName'] }}</p>
                            <p class="text-sm">**** **** **** {{ substr($payment['cardNumber'], -4) }}</p>
                        @else
                            <p class="font-medium">E-Wallet: {{ $payment['ewalletName'] }}</p>
                            <p class="text-sm">{{ $payment['nomor_hp'] }}</p>
                        @endif
                        <p class="text-sm">Rp {{ number_format($payment['amount'], 0, ',', '.') }}</p>
                        @if($payment['isActive'])
                            <span class="text-green-500 text-sm">(Active)</span>
                        @endif
                    </div>
                    <div class="flex space-x-2">
                        @if($payment['isActive'])
                            <form action="{{ url('/payment/set-inactive') }}" method="POST" class="set-inactive-form">
                                @csrf
                                <input type="hidden" name="payment_id" value="{{ $payment['_id'] }}">
                                <input type="hidden" name="payment_type" value="{{ $payment['type'] }}">
                                <button type="submit" class="text-yellow-600 hover:text-yellow-800">
                                    <i class="fas fa-times-circle"></i> Set Inactive
                                </button>
                            </form>
                        @else
                            <form action="{{ url('/payment/set-active') }}" method="POST">
                                @csrf
                                <input type="hidden" name="payment_id" value="{{ $payment['_id'] }}">
                                <input type="hidden" name="payment_type" value="{{ $payment['type'] }}">
                                <button type="submit" class="text-blue-600 hover:text-blue-800">
                                    <i class="fas fa-check-circle"></i> Set Active
                                </button>
                            </form>
                        @endif
                        <form action="{{ url('/payment/delete') }}" method="POST" class="delete-form">
                            @csrf
                            <input type="hidden" name="payment_id" value="{{ $payment['_id'] }}">
                            <input type="hidden" name="payment_type" value="{{ $payment['type'] }}">
                            <button type="submit" class="text-red-600 hover:text-red-800">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>
            @else
                <p class="mt-4 text-gray-500">Belum ada metode pembayaran</p>
            @endif
        </div>

        <form action="{{ url('/logout') }}" method="POST" class="mt-6">
            @csrf
            <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-700">
                <i class="fas fa-sign-out-alt"></i> Logout
            </button>
        </form>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('overlay');
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        }
        document.addEventListener('DOMContentLoaded', function() {
            // Confirm before setting inactive
            document.querySelectorAll('.set-inactive-form').forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Set Payment Inactive?',
                        text: "This payment method will no longer be used as default",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, set inactive'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });

            // Confirm before deleting
            document.querySelectorAll('.delete-form').forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Delete Payment Method?',
                        text: "You won't be able to revert this!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        });
    </script>
</body>
</html>
