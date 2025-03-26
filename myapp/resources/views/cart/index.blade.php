<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-gray-100">
    <nav class="bg-blue-600 p-4 text-white flex justify-between items-center">
        <div class="text-lg font-bold">Keranjang Belanja</div>
        <a href="{{ url('/findPart') }}" class="hover:underline">Kembali ke Belanja</a>
    </nav>

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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Quantity controls
            document.querySelectorAll('.increment-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const cartId = this.getAttribute('data-id');
                    updateCartItem(cartId, 1);
                });
            });

            document.querySelectorAll('.decrement-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const cartId = this.getAttribute('data-id');
                    updateCartItem(cartId, -1);
                });
            });

            // Remove item
            document.querySelectorAll('.remove-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const cartId = this.getAttribute('data-id');
                    removeCartItem(cartId);
                });
            });

            // Checkout button
            document.getElementById('checkoutBtn')?.addEventListener('click', function() {
                Swal.fire({
                    title: 'Konfirmasi Pembelian',
                    text: 'Silakan hubungi penjual untuk menyelesaikan transaksi',
                    icon: 'info',
                    confirmButtonText: 'Mengerti'
                });
            });

            function updateCartItem(cartId, change) {
                fetch(`/cart/${cartId}`, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ change: change })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: data.message || 'Terjadi kesalahan saat memperbarui keranjang',
                        });
                    }
                });
            }

            function removeCartItem(cartId) {
                Swal.fire({
                    title: 'Hapus dari keranjang?',
                    text: "Produk akan dihapus dari keranjang belanja",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, hapus!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch(`/cart/${cartId}`, {
                            method: 'DELETE',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                location.reload();
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal',
                                    text: data.message || 'Terjadi kesalahan saat menghapus item',
                                });
                            }
                        });
                    }
                });
            }
        });
    </script>
</body>
</html>