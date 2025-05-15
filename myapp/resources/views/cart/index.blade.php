<!--cart.index.blade.php-->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-100">
    <!-- Navbar -->
    <nav class="bg-blue-600 p-4 text-white flex justify-between items-center">
        <div class="text-lg font-bold">Keranjang Belanja</div>
        <a href="{{ url('/findPart') }}" class="hover:underline">Kembali ke Belanja</a>
    </nav>

    <!-- Main Content -->
    <div class="max-w-4xl mx-auto mt-6 p-6 bg-white shadow-md rounded-md">
        @if(count($carts) > 0)
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white">
                <thead>
                    <tr class="bg-gray-200 text-gray-700">
                        <th class="py-2 px-4 text-left">Produk</th>
                        <th class="py-2 px-4 text-left">Harga</th>
                        <th class="py-2 px-4 text-left">Jumlah</th>
                        <th class="py-2 px-4 text-left">Subtotal</th>
                        <th class="py-2 px-4 text-left">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    @php $total = 0; @endphp
                    @foreach($carts as $cart)
                    @php
                        $subtotal = $cart['price'] * $cart['quantity'];
                        $total += $subtotal;
                    @endphp
                    <tr class="border-b border-gray-200 hover:bg-gray-50">
                        <td class="py-3 px-4 flex items-center">
                            <img src="{{ asset($cart['gambar']) }}" alt="{{ $cart['name'] }}" class="w-16 h-16 object-cover mr-3">
                            <span>{{ $cart['name'] }}</span>
                        </td>
                        <td class="py-3 px-4">Rp {{ number_format($cart['price'], 0, ',', '.') }}</td>
                        <td class="py-3 px-4">
                            <div class="flex items-center">
                                <button 
                                    class="decrement-btn bg-gray-200 px-2 py-1 rounded-l-md hover:bg-gray-300"
                                    data-id="{{ $cart['_id'] }}"
                                >
                                    -
                                </button>
                                <span class="quantity-display px-2 py-1 bg-gray-100">
                                    {{ $cart['quantity'] }}
                                </span>
                                <button 
                                    class="increment-btn bg-gray-200 px-2 py-1 rounded-r-md hover:bg-gray-300"
                                    data-id="{{ $cart['_id'] }}"
                                >
                                    +
                                </button>
                            </div>
                        </td>
                        <td class="py-3 px-4">Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                        <td class="py-3 px-4">
                            <button 
                                class="remove-btn text-red-500 hover:text-red-700"
                                data-id="{{ $cart['_id'] }}"
                            >
                                Hapus
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-6 p-4 bg-gray-50 rounded-md">
            <div class="flex justify-between items-center">
                <h3 class="text-lg font-semibold">Total Pembayaran</h3>
                <span class="text-xl font-bold">Rp {{ number_format($total, 0, ',', '.') }}</span>
            </div>
            
            <div class="mt-4">
                @if(count($carts) > 0)
                    @php
                        // Get first product to find seller info
                        $firstProduct = DB::connection('mongodb')
                            ->getMongoDB()
                            ->selectCollection('products')
                            ->findOne(['_id' => new \MongoDB\BSON\ObjectId($carts[0]['product_id'])]);
                        
                        $seller = DB::connection('mongodb')
                            ->getMongoDB()
                            ->selectCollection('users')
                            ->findOne(['_id' => $firstProduct['user_id']]);
                    @endphp
                    
                    @if($seller)
                    <div class="mb-4 p-3 bg-blue-50 rounded-md">
                        <h4 class="font-medium text-blue-800">Informasi Penjual:</h4>
                        <p class="text-sm mt-1">
                            <span class="font-medium">Nama:</span> {{ $seller['username'] }}<br>
                            <span class="font-medium">No. HP:</span> {{ $seller['nomor_hp'] ?? 'Belum tersedia' }}<br>
                            <span class="font-medium">Alamat:</span> {{ $seller['alamat'] ?? 'Belum tersedia' }}
                        </p>
                        <p class="text-sm text-gray-600 mt-2">
                            * Silakan hubungi penjual di nomor tersebut untuk melanjutkan transaksi pembelian
                        </p>
                    </div>
                    @endif
                @endif
                
                <button 
                    id="checkoutBtn"
                    class="w-full bg-green-600 text-white py-3 rounded-md hover:bg-green-700 font-medium"
                >
                    Lanjutkan Pembayaran
                </button>
            </div>
        </div>
        @else
        <div class="text-center py-10">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
            <h3 class="mt-4 text-lg font-medium text-gray-900">Keranjang belanja kosong</h3>
            <p class="mt-1 text-gray-500">Anda belum menambahkan produk ke keranjang belanja</p>
            <div class="mt-6">
                <a href="{{ url('/findPart') }}" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                    Mulai Belanja
                </a>
            </div>
        </div>
        @endif
    </div>

    <!-- Payment Modal -->
    <div id="paymentModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
    <form method="POST" action="{{ url('/checkout/process') }}" class="bg-white rounded-lg p-6 w-full max-w-md" id="paymentForm">
        @csrf
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-bold">Pembayaran</h3>
            <button type="button" id="closeModal" class="text-gray-500 hover:text-gray-700">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <!-- Pilihan Pengiriman -->
        <div class="mb-6">
            <h4 class="font-semibold mb-2">Pilihan Pengiriman</h4>
            <div class="space-y-2">
                <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50">
                    <input type="radio" name="shipping_method" value="reguler" class="mr-3" checked>
                    <div>
                        <p class="font-medium">Reguler</p>
                        <p class="text-sm text-gray-600">Estimasi 3-5 hari kerja</p>
                        <p class="text-sm font-medium">Rp 15.000</p>
                    </div>
                </label>
                <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50">
                    <input type="radio" name="shipping_method" value="express" class="mr-3">
                    <div>
                        <p class="font-medium">Express</p>
                        <p class="text-sm text-gray-600">Estimasi 1-2 hari kerja</p>
                        <p class="text-sm font-medium">Rp 25.000</p>
                    </div>
                </label>
            </div>
        </div>

        <!-- Metode Pembayaran -->
        <div class="mb-6">
            <h4 class="font-semibold mb-2">Metode Pembayaran</h4>
            @if(isset($activePayments) && count($activePayments) > 0)
                <div class="space-y-3">
                    @foreach($activePayments as $payment)
                        @if($payment['isActive'])
                        <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50">
                            <input type="radio" name="payment_method_id" value="{{ $payment['_id'] }}" class="mr-3" required>
                            <div>
                                @if($payment['type'] === 'creditcard')
                                    <p class="font-medium">Credit Card: {{ $payment['cardName'] }}</p>
                                    <p class="text-sm text-gray-600">**** **** **** {{ substr($payment['cardNumber'], -4) }}</p>
                                @else
                                    <p class="font-medium">E-Wallet: {{ $payment['ewalletName'] }}</p>
                                    <p class="text-sm text-gray-600">{{ $payment['nomor_hp'] }}</p>
                                @endif
                            </div>
                        </label>
                        @endif
                    @endforeach
                </div>
            @else
                <div class="p-3 bg-yellow-50 text-yellow-800 rounded-md">
                    <p>Anda belum memiliki metode pembayaran aktif.</p>
                    <a href="{{ url('/add-payment') }}" class="text-blue-600 hover:underline mt-1 inline-block">
                        Tambah metode pembayaran
                    </a>
                </div>
            @endif
        </div>

        <!-- Ringkasan -->
        <div class="border-t pt-4 mb-4">
            <div class="flex justify-between mb-1">
                <span>Subtotal Produk:</span>
                <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between mb-1">
                <span>Ongkos Kirim:</span>
                <span id="shippingCost">Rp 15.000</span>
            </div>
            <div class="flex justify-between font-bold text-lg mt-2">
                <span>Total Pembayaran:</span>
                <span id="totalPayment">Rp {{ number_format($total + 15000, 0, ',', '.') }}</span>
            </div>
        </div>

        <!-- Total Hidden -->
        <input type="hidden" name="total" id="totalInput" value="{{ $total + 15000 }}">

        <!-- Submit -->
        <button 
            type="submit"
            class="w-full bg-blue-600 text-white py-3 rounded-md hover:bg-blue-700 font-medium mt-4"
            @if(!isset($activePayments) || count($activePayments) === 0) disabled @endif
        >
            Konfirmasi Pembayaran
        </button>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const paymentModal = document.getElementById('paymentModal');
    const checkoutBtn = document.getElementById('checkoutBtn');
    const closeModal = document.getElementById('closeModal');
    const shippingRadios = document.querySelectorAll('input[name="shipping_method"]');
    const shippingCost = document.getElementById('shippingCost');
    const totalPayment = document.getElementById('totalPayment');
    const totalInput = document.getElementById('totalInput');
    const subtotal = {{ $total }};

    if (checkoutBtn) {
        checkoutBtn.addEventListener('click', () => {
            paymentModal.classList.remove('hidden');
        });
    }

    if (closeModal) {
        closeModal.addEventListener('click', () => {
            paymentModal.classList.add('hidden');
        });
    }

    shippingRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            const shippingPrice = this.value === 'express' ? 25000 : 15000;
            shippingCost.textContent = `Rp ${shippingPrice.toLocaleString('id-ID')}`;
            const newTotal = subtotal + shippingPrice;
            totalPayment.textContent = `Rp ${newTotal.toLocaleString('id-ID')}`;
            totalInput.value = newTotal;
        });
    });
});
</script>
</body>
</html>
