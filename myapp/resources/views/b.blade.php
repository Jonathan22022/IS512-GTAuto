<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About GT Auto</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-orange-500 text-white font-sans">

    <!-- Header -->
    <div class="px-6 py-4">
        <div class="flex justify-between items-center">
            <div class="flex space-x-4">
                <!-- Icon services -->
                <img src="{{ asset('Gambar Product/d.png') }}" class="h-10" alt="">
                <img src="{{ asset('Gambar Product/e.png') }}" class="h-10" alt="">
                <img src="{{ asset('Gambar Product/h.png') }}" class="h-10" alt="">
                <img src="{{ asset('Gambar Product/i.png') }}" class="h-10" alt="">
                <img src="{{ asset('Gambar Product/j.png') }}" class="h-10" alt="">
            </div>
            <h2 class="italic text-white font-bold text-xl">Find Us Nearby!</h2>
        </div>

        <div class="mt-2">
            <img src="{{ asset('Gambar Product/f.png') }}" class="h-14" alt="GT Auto Logo">
            <p class="mt-4 max-w-3xl text-white font-bold">
                GT Auto is your go-to shop for car care, repairs, and upgrades.
                Whether you need a quick car wash, an oil change, a full engine overhaul, or custom bodywork like widebody kits and chassis restoration, we’ve got you covered.
                Our expert team ensures your car looks great and runs smoothly—so you can hit the road with confidence!
            </p>
        </div>
    </div>

    <div class="relative">
        <div class="bg-black transform -skew-y-6 py-16">
            <div class="transform skew-y-6 max-w-4xl mx-auto px-6">
                <p class="text-white text-lg italic rotate-[-6deg] text-right">
                    <span class="font-bold">Car Wash</span> – A thorough exterior and interior cleaning to keep your car looking fresh and spotless. Removes dirt, dust, and grime for a showroom shine.
                </p>
                <div class="flex align-left ">
                    <img src="{{ asset('Gambar Product/k.png') }}" class="h-60 object-contain" alt="Car Cleaning Kit">
                </div>
            </div>
        </div>
        <div class="bg-orange transform -skew-y-6 py-16">
            <div class="transform skew-y-6 max-w-4xl mx-auto px-6">
                <p class="text-black text-lg italic rotate-[-6deg] text-right">
                    <span class="font-bold">Oil Change</span> – Regular oil changes keep your engine running smoothly and efficiently. We replace old oil and filters to extend your car’s life and improve performance.
                </p>
                <div class="flex align-left ">
                    <img src="{{ asset('Gambar Product/l.png') }}" class="h-60 object-contain" alt="Car Cleaning Kit">
                </div>
            </div>
        </div>
        <div class="bg-black transform -skew-y-6 py-16">
            <div class="transform skew-y-6 max-w-4xl mx-auto px-6">
                <p class="text-white text-lg italic rotate-[-6deg] text-right">
                    <span class="font-bold">Engine Overhaul & Repair</span> – Whether it’s fixing minor engine issues or a full rebuild, we diagnose and repair problems to restore power and efficiency.
                </p>
                <div class="flex align-left ">
                    <img src="{{ asset('Gambar Product/m.png') }}" class="h-60 object-contain" alt="Car Cleaning Kit">
                </div>
            </div>
        </div>
        <div class="bg-orange transform -skew-y-6 py-16">
            <div class="transform skew-y-6 max-w-4xl mx-auto px-6">
                <p class="text-black text-lg italic rotate-[-6deg] text-right">
                    <span class="font-bold">Body Rigidity Restoration</span> – Over time, a car’s chassis can weaken. This service reinforces and strengthens the frame to improve handling, stability, and safety.
                </p>
                <div class="flex align-left ">
                    <img src="{{ asset('Gambar Product/n.png') }}" class="h-60 object-contain" alt="Car Cleaning Kit">
                </div>
            </div>
        </div>
        <div class="bg-black transform -skew-y-6 py-16">
            <div class="transform skew-y-6 max-w-4xl mx-auto px-6">
                <p class="text-white text-lg italic rotate-[-6deg] text-right">
                    <span class="font-bold">Widebody Installation</span> – Give your car a bold, aggressive look with a widebody kit. This modification adds wider fenders, improving aerodynamics and allowing for larger wheels.
                </p>
                <div class="flex align-left ">
                    <img src="{{ asset('Gambar Product/o.png') }}" class="h-60 object-contain" alt="Car Cleaning Kit">
                </div>
            </div>
        </div>
        <div class="bg-gradient-to-b from-white to-orange-500 py-24">
            <h2 class="text-center text-orange-700 italic text-3xl font-semibold drop-shadow-md">
                <a href="/">
                    Return
                </a>
            </h2>
            <h2 class="text-center text-orange-700 italic text-3xl font-semibold drop-shadow-md">
                <a href="/Membership">
                    Perks for our GTAUTO Members
                </a>
            </h2>
        </div>
    </div>

</body>
</html>
