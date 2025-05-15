<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gradient-to-b from-white to-orange-400 min-h-screen font-sans">
    <h4 class="text-sm font-semibold">Welcome to</h4>
    <div class="flex justify-center items-center my-2">
        <img src="{{ asset('Gambar Product/f.png') }}" alt="GT Auto Logo" class="h-10">
    </div>
    <h3 class="text-xl font-bold">The one stop shop for everything Cars.</h3>
    <div class="flex justify-center my-6">
        <img src="{{ asset('Gambar Product/aa.png') }}" alt="Car" class="h-40 object-contain">
    </div>

    <div class="text-center max-w-xl mx-auto px-4 text-gray-700 mb-10">
        <p>Your one-stop shop for premium car parts and top-tier maintenance services. Whether you're upgrading performance, fine-tuning your ride, or keeping it in peak condition, we’ve got you covered.</p>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-3 gap-4 max-w-5xl mx-auto px-4 mb-10">
        <img src="{{ asset('Gambar Product/c.png') }}" class="rounded-xl object-cover h-40 w-full">
        <img src="{{ asset('Gambar Product/a.jpeg') }}" class="rounded-xl object-cover h-40 w-full">
        <img src="{{ asset('Gambar Product/b.jpeg') }}" class="rounded-xl object-cover h-40 w-full">
    </div>
        <div class="max-w-xl mx-auto text-gray-800 text-left">
            <p><span class="font-bold">Expert Maintenance</span> Keep your car running like new with professional services.</p>
            <p><span class="font-bold">Quality Parts</span> Explore our collection of high-performance upgrades.</p>
            <p><span class="font-bold">Custom Styling</span> Personalize your ride with exclusive modifications.</p>
            <p><span class="font-bold">Amazing Deals</span> Save up on our latest and greatest deals.</p>
        </div>

        <div class="mt-6">
            <a href="/whyus" class="bg-gray-700 text-white px-6 py-2 font-semibold italic rounded shadow hover:bg-gray-800">
                WHY US?
            </a>
            <a href="/login" class="bg-gray-700 text-white px-6 py-2 font-semibold italic rounded shadow hover:bg-gray-800 ml-4">
                LOGIN
            </a>
        </div>
</body>
</html>

