<!--detail-penjual.blade.php-->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Detail Penjual</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-gray-100">
    <nav class="bg-orange-600 p-4 text-white flex justify-between items-center">
        <div>
            <a href="{{ url('/dashboard') }}" class="text-lg font-semibold">
                <img src="{{ asset('Gambar Product/f.png') }}" alt="GT Auto Logo" class="h-10">
            </a>
        </div>
        <div class="flex items-center space-x-4">
            <a href="{{ url('/cart') }}" class="flex items-center hover:underline" id="cartLink">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                <span id="cartCount">0</span>
            </a>
            <a href="{{ url('/findPart') }}" class="hover:underline">Kembali</a>
        </div>
    </nav>

    <!-- Search and Filter Section -->
    <div class="bg-white shadow-sm">
        <div class="max-w-4xl mx-auto p-4">
            <div class="mb-4">
                <input 
                    type="text" 
                    id="productSearch" 
                    placeholder="Cari produk..." 
                    class="w-full p-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
            </div>
            <div class="flex flex-wrap gap-2">
                <select 
                    id="typeFilter" 
                    class="p-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
                    <option value="">Semua Tipe</option>
                    <option value="Engine">Engine</option>
                    <option value="Intake">Intake</option>
                    <option value="Forced induction">Forced Induction</option>
                    <option value="Exhaust">Exhaust</option>
                    <option value="Drivetrain">Drivetrain</option>
                    <option value="Handling">Handling</option>
                </select>
                <button 
                    id="resetFilters" 
                    class="p-2 bg-gray-200 rounded-md hover:bg-gray-300"
                >
                    Reset Filter
                </button>
            </div>
        </div>
    </div>

    <div class="max-w-4xl mx-auto mt-4 p-6 bg-white shadow-md rounded-md">
        <h2 class="text-2xl font-bold mb-4">{{ $username }}</h2>
        <p class="text-gray-600 mb-6"><strong>Alamat:</strong> {{ $alamat }}</p>
        
        <h3 class="text-xl font-semibold mb-4">Produk yang Dijual:</h3>
        <div id="productsContainer" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($products as $product)
            <div 
                class="product-card border rounded-lg p-4 shadow-sm" 
                data-name="{{ strtolower($product['name']) }}" 
                data-type="{{ $product['type'] }}"
                data-id="{{ $product['_id'] }}"
            >
                <img src="{{ asset($product['gambar']) }}" alt="{{ $product['name'] }}" class="w-full h-40 object-cover mb-2">
                <h4 class="font-bold">{{ $product['name'] }}</h4>
                <p class="text-gray-600">Rp {{ number_format($product['price'], 0, ',', '.') }}</p>
                <p class="text-sm text-gray-500">Stok: {{ $product['jumlahBarang'] }}</p>
                <p class="text-sm text-blue-500">{{ $product['type'] }}</p>
                <p class="text-sm mt-2">{{ $product['description'] }}</p>
                
                <!-- Quantity Controls -->
                <div class="flex items-center mt-3">
                    <button 
                        class="decrement-btn bg-gray-200 px-3 py-1 rounded-l-md hover:bg-gray-300"
                        data-id="{{ $product['_id'] }}"
                    >
                        -
                    </button>
                    <input 
                        type="number" 
                        min="1" 
                        max="{{ $product['jumlahBarang'] }}" 
                        value="1" 
                        class="quantity-input w-12 text-center border-t border-b border-gray-300 py-1"
                        data-id="{{ $product['_id'] }}"
                    >
                    <button 
                        class="increment-btn bg-gray-200 px-3 py-1 rounded-r-md hover:bg-gray-300"
                        data-id="{{ $product['_id'] }}"
                    >
                        +
                    </button>
                </div>
                
                <!-- Add to Cart Button -->
                <button 
                    class="add-to-cart-btn mt-2 w-full bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700"
                    data-id="{{ $product['_id'] }}"
                    data-name="{{ $product['name'] }}"
                    data-price="{{ $product['price'] }}"
                    data-stock="{{ $product['jumlahBarang'] }}"
                >
                    Tambah ke Keranjang
                </button>
            </div>
            @endforeach
            
            @if(count($products) == 0)
            <p class="text-gray-500">Penjual ini belum memiliki produk.</p>
            @endif
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // [Previous filter and quantity control code remains the same]

            // Cart functionality - Modified to handle HTML responses
            function updateCartCount() {
                fetch('/cart/count')
                    .then(response => response.text())
                    .then(html => {
                        // Create a temporary element to parse the HTML
                        const temp = document.createElement('div');
                        temp.innerHTML = html;
                        const countElement = temp.querySelector('#cartCount');
                        if (countElement) {
                            document.getElementById('cartCount').textContent = countElement.textContent;
                        }
                    })
                    .catch(error => console.error('Error:', error));
            }

            // Initialize cart count
            updateCartCount();

            document.querySelectorAll('.add-to-cart-btn').forEach(btn => {
                btn.addEventListener('click', async function() {
                    const productId = this.getAttribute('data-id');
                    const productName = this.getAttribute('data-name');
                    const quantityInput = document.querySelector(`.quantity-input[data-id="${productId}"]`);
                    const quantity = parseInt(quantityInput.value);

                    try {
                        const formData = new FormData();
                        formData.append('product_id', productId);
                        formData.append('quantity', quantity);
                        formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);

                        const response = await fetch('/cart', {
                            method: 'POST',
                            body: formData
                        });

                        if (!response.ok) {
                            const errorText = await response.text();
                            throw new Error(errorText || 'Gagal menambahkan ke keranjang');
                        }

                        // Update cart count after successful addition
                        updateCartCount();

                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: `${productName} ditambahkan ke keranjang`,
                            showConfirmButton: false,
                            timer: 1500
                        });
                    } catch (error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: error.message,
                        });
                        console.error('Error:', error);
                    }
                });
            });
        });
    </script>
</body>
</html>
