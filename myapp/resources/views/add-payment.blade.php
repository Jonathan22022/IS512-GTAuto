<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Payment</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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

    <div class="max-w-md mx-auto mt-10 p-6 bg-white shadow-md rounded-md">
        <!-- Success/Error Messages -->
        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif
        
        @if(session('error'))
            <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
                {{ session('error') }}
            </div>
        @endif

        <h2 class="text-xl font-semibold mb-4">Pilih Jenis Pembayaran</h2>
        
        <form id="paymentForm" action="{{ url('/payment/add') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block mb-2">Jenis Pembayaran</label>
                <select name="payment_type" id="paymentType" class="w-full p-2 border rounded" required>
                    <option value="">-- Pilih Jenis --</option>
                    <option value="creditcard">Credit Card</option>
                    <option value="ewallet">E-Wallet</option>
                </select>
            </div>

            <!-- Credit Card Fields -->
            <div id="creditCardFields" class="hidden">
                <div class="mb-4">
                    <label class="block mb-2">Jenis Kartu</label>
                    <select name="cardName" class="w-full p-2 border rounded">
                        <option value="Visa">Visa</option>
                        <option value="Mastercard">Mastercard</option>
                        <option value="JCB">JCB</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block mb-2">Nomor Kartu</label>
                    <input type="text" name="cardNumber" class="w-full p-2 border rounded" placeholder="1234 5678 9012 3456">
                </div>
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block mb-2">Tanggal Kadaluarsa</label>
                        <input type="text" name="expiredDate" class="w-full p-2 border rounded" placeholder="MM/YY">
                    </div>
                    <div>
                        <label class="block mb-2">CVV</label>
                        <input type="text" name="cvv" class="w-full p-2 border rounded" placeholder="123">
                    </div>
                </div>
            </div>

            <!-- E-Wallet Fields -->
            <div id="eWalletFields" class="hidden">
                <div class="mb-4">
                    <label class="block mb-2">Jenis E-Wallet</label>
                    <select name="ewalletName" class="w-full p-2 border rounded">
                        <option value="ShopeePay">ShopeePay</option>
                        <option value="OVO">OVO</option>
                        <option value="DANA">DANA</option>
                        <option value="LinkAja">LinkAja</option>
                        <option value="GoPay">GoPay</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block mb-2">Nomor HP</label>
                    <input type="text" name="nomor_hp" class="w-full p-2 border rounded" value="{{ session('user')['nomor_hp'] }}">
                </div>
            </div>

            <input type="hidden" name="amount" value="5000000">
            <input type="hidden" name="isActive" value="true">

            <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">
                Tambah Payment
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
        document.getElementById('paymentType').addEventListener('change', function() {
            const type = this.value;
            document.getElementById('creditCardFields').classList.add('hidden');
            document.getElementById('eWalletFields').classList.add('hidden');
            
            if (type === 'creditcard') {
                document.getElementById('creditCardFields').classList.remove('hidden');
            } else if (type === 'ewallet') {
                document.getElementById('eWalletFields').classList.remove('hidden');
            }
        });
    </script>
</body>
</html>