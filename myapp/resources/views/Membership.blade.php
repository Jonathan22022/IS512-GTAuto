<!--Membership.blade.php-->
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>GT Auto Membership</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-white text-gray-800">
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
    
  <nav class="bg-orange-600 p-4 text-white flex justify-between items-center">
    <div class="flex items-center space-x-4">
      <!-- Hamburger Button -->
      <button class="focus:outline-none">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
      </button>
      <!-- Logo --><a href="{{ url('/dashboard') }}" class="text-lg font-semibold">
        <img src="{{ asset('Gambar Product/f.png') }}" alt="GT Auto Logo" class="h-10">
</a>
    </div>
  </nav>

  <!-- Header with Logo and Description -->
  <div class="p-6">
    <div class="flex flex-col items-center">
      <img src="{{ asset('Gambar Product/ab.png') }}" alt="GT Auto Header Logo" class="h-14 mb-4">
      <p class="text-center max-w-3xl">
        Upgrade to GT auto+ membership to access a number of special advantages intended to give your car maintenance needs unmatched convenience, savings, and peace of mind. Ideal for drivers who wish to take the finest possible care of their cars without having to deal with any hassles.
      </p>
    </div>
  </div>

  <!-- Pricing Table -->
  <div class="overflow-x-auto px-4 py-6">
    <table class="w-full border border-gray-300 text-sm text-center">
      <thead>
        <tr>
          <th class="py-2 px-4 border">Pricing Table Advantage</th>
          <th class="py-2 px-4 border">Non-Member</th>
          <th class="py-2 px-4 border">Loyal Members</th>
          <th class="py-2 px-4 border">GT AUTO Plus Members</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td class="border py-2">Monthly Free Discounts</td>
          <td class="border">❌</td>
          <td class="border">✅</td>
          <td class="border">✅</td>
        </tr>
        <tr>
          <td class="border py-2">Queue Fast Pass</td>
          <td class="border">❌</td>
          <td class="border">✅</td>
          <td class="border">✅</td>
        </tr>
        <tr>
          <td class="border py-2">Giveaway Rewards</td>
          <td class="border">❌</td>
          <td class="border">✅</td>
          <td class="border">✅</td>
        </tr>
        <tr>
          <td class="border py-2">Referral Bonuses</td>
          <td class="border">❌</td>
          <td class="border">❌</td>
          <td class="border">✅</td>
        </tr>
        <tr>
          <td class="border py-2">VIP Treatment</td>
          <td class="border">❌</td>
          <td class="border">✅</td>
          <td class="border">✅</td>
        </tr>
        <tr>
          <td class="border py-2">Networking Opportunities</td>
          <td class="border">❌</td>
          <td class="border">❌</td>
          <td class="border">✅</td>
        </tr>
        <tr>
          <td class="border py-2 font-semibold">Harga Bulanan</td>
          <td class="border">-</td>
          <td class="border text-white-600 font-bold">
            <button type="button" onclick="checkLogin('loyal-monthly')" class="bg-orange-500 text-white px-4 py-2 rounded hover:bg-green-700">
                Rp. 30.000,00/Mnth	
            </button>
            </td>
          <td class="border text-white-600 font-bold">
            <button type="button" onclick="checkLogin('plus-monthly')" class="bg-orange-500 text-white px-4 py-2 rounded hover:bg-green-700">
                Rp. 45.000,00/Mnth	
            </button></td>
        </tr>
        <tr>
          <td class="border py-2 font-semibold">Harga Tahunan</td>
          <td class="border">-</td>
          <td class="border text-white-600 font-bold">
            <button type="button" onclick="checkLogin('loyal-yearly')" class="bg-orange-500 text-white px-4 py-2 rounded hover:bg-green-700">
                Rp. 300.000,00/Yr
            </button>
        </td>
          <td class="border text-white-600 font-bold">
            <button type="button" onclick="checkLogin('plus-yearly')" class="bg-orange-500 text-white px-4 py-2 rounded hover:bg-green-700">
                Rp. 480.000,00/Yr	
            </button>
        </td>
        </tr>
      </tbody>
    </table>
  </div>

  <!-- Login Modal -->
  <div id="loginModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
    <div class="bg-white p-6 rounded-lg shadow-lg max-w-sm w-full">
      <h3 class="text-xl font-bold mb-4">Login Required</h3>
      <p class="mb-6">You need to login first to purchase a membership. Would you like to login now?</p>
      <div class="flex justify-end space-x-4">
        <button onclick="hideLoginModal()" class="px-4 py-2 border border-gray-300 rounded hover:bg-gray-100">No</button>
        <a href="/login" class="px-4 py-2 bg-orange-600 text-white rounded hover:bg-orange-700">Yes</a>
      </div>
    </div>
  </div>

  <!-- Membership Confirmation Modal -->
  <div id="membershipModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
    <div class="bg-white p-6 rounded-lg shadow-lg max-w-md w-full">
        <h3 class="text-xl font-bold mb-4">Konfirmasi Membership</h3>
        <div id="membershipDetails" class="mb-4">
            <!-- Membership details will be inserted here by JavaScript -->
        </div>

        <div class="mb-4" id="paymentMethodContainer">
            @if(isset($payments) && count($payments) > 0)
                <label class="block mb-2">Pilih Metode Pembayaran:</label>
                <select id="paymentMethod" class="w-full border px-3 py-2 rounded">
                    @foreach($payments as $payment)
                        @if($payment['isActive'])
                            <option value="{{ $payment['_id'] }}">
                                @if($payment['type'] === 'creditcard')
                                    Credit Card: **** **** **** {{ substr($payment['cardNumber'], -4) }}
                                @else
                                    E-Wallet: {{ $payment['ewalletName'] }} ({{ $payment['nomor_hp'] }})
                                @endif
                            </option>
                        @endif
                    @endforeach
                </select>
            @else
                <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4">
                    <p>Anda belum memiliki metode pembayaran.</p>
                    <a href="{{ url('/add-payment') }}" class="text-orange-600 hover:underline mt-2 inline-block">
                        Tambah Metode Pembayaran
                    </a>
                </div>
            @endif
        </div>
        
        <div class="flex justify-end space-x-4">
            <button onclick="hideMembershipModal()" class="px-4 py-2 border border-gray-300 rounded hover:bg-gray-100">Batal</button>
            <button onclick="confirmMembership()" class="px-4 py-2 bg-orange-600 text-white rounded hover:bg-orange-700 {{ !isset($payments) || count($payments) === 0 ? 'opacity-50 cursor-not-allowed' : '' }}" {{ !isset($payments) || count($payments) === 0 ? 'disabled' : '' }}>
                Konfirmasi Pembayaran
            </button>
        </div>
    </div>
  </div>

  <!-- Footer Icon -->
  <div class="flex justify-end px-6 pb-6">
    <img src="https://via.placeholder.com/30.png?text=i" alt="Info Icon" class="h-6 w-6">
  </div>

  <script>
    let selectedPlan = null;

    function checkLogin(planType) {
        // Check if user is logged in
        @if(!session('user'))
            // Show login modal if not logged in
            selectedPlan = planType;
            showLoginModal();
        @else
            // Show membership modal if logged in
            selectedPlan = planType;
            showMembershipModal(planType);
        @endif
    }

    function showMembershipModal(planType) {
        const modal = document.getElementById('membershipModal');
        const details = document.getElementById('membershipDetails');
        
        // Set membership details based on planType
        let planName, price, duration;
        switch(planType) {
            case 'loyal-monthly':
                planName = 'Loyal Members';
                price = 'Rp 30.000';
                duration = 'Bulanan';
                break;
            case 'loyal-yearly':
                planName = 'Loyal Members';
                price = 'Rp 300.000';
                duration = 'Tahunan';
                break;
            case 'plus-monthly':
                planName = 'GT AUTO Plus';
                price = 'Rp 45.000';
                duration = 'Bulanan';
                break;
            case 'plus-yearly':
                planName = 'GT AUTO Plus';
                price = 'Rp 480.000';
                duration = 'Tahunan';
                break;
        }
        
        details.innerHTML = `
            <p><strong>Membership:</strong> ${planName}</p>
            <p><strong>Durasi:</strong> ${duration}</p>
            <p><strong>Harga:</strong> ${price}</p>
        `;
        
        modal.classList.remove('hidden');
    }

    function confirmMembership() {
        @if(!session('user'))
            showLoginModal();
            return;
        @endif

        const paymentMethod = document.getElementById('paymentMethod');
        if (!paymentMethod) {
            alert('Anda belum memiliki metode pembayaran yang aktif.');
            return;
        }

        // Create a form dynamically
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ route("process.membership") }}';
        
        // Add CSRF token
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = '{{ csrf_token() }}';
        form.appendChild(csrfToken);
        
        // Add plan type
        const planInput = document.createElement('input');
        planInput.type = 'hidden';
        planInput.name = 'plan_type';
        planInput.value = selectedPlan;
        form.appendChild(planInput);
        
        // Add payment method
        const paymentInput = document.createElement('input');
        paymentInput.type = 'hidden';
        paymentInput.name = 'payment_method';
        paymentInput.value = paymentMethod.value;
        form.appendChild(paymentInput);
        
        // Submit the form
        document.body.appendChild(form);
        form.submit();
        
        hideMembershipModal();
    }

    function showLoginModal() {
        document.getElementById('loginModal').classList.remove('hidden');
    }

    function hideLoginModal() {
        document.getElementById('loginModal').classList.add('hidden');
    }

    function hideMembershipModal() {
        document.getElementById('membershipModal').classList.add('hidden');
    }
    
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('overlay');
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        }
  </script>
</body>
</html>