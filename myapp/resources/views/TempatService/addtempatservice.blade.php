<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Tempat Service</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 p-6">

    <h1 class="text-3xl font-bold text-gray-800 mb-4">Tambah Tempat Service</h1>

    @if(session('success'))
        <p class="bg-green-500 text-white p-2 rounded">{{ session('success') }}</p>
    @endif

    <form action="{{ url('/add-tempat-service') }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded shadow-md w-full max-w-lg">
        @csrf

        <div class="mb-4">
            <label class="block text-gray-700">Nama Tempat Service</label>
            <input type="text" name="name" class="w-full p-2 border border-gray-300 rounded" required>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700">Pemilik</label>
            <input type="text" name="pemilik" class="w-full p-2 border border-gray-300 rounded" required>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700">Gambar</label>
            <input type="file" name="gambar" class="w-full p-2 border border-gray-300 rounded" required>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700">Jasa</label>
            <input type="text" name="jasa" class="w-full p-2 border border-gray-300 rounded" required>
        </div>

<div class="mb-4">
    <label for="jam_mulai" class="block text-gray-700 font-bold">Jam Mulai:</label>
    <div class="flex space-x-2">
        <select name="jam_mulai" id="jam_mulai" class="p-2 border rounded" required>
            <option value="00">00</option>
            <option value="01">01</option>
            <option value="02">02</option>
            <option value="03">03</option>
            <option value="04">04</option>
            <option value="05">05</option>
            <option value="06">06</option>
            <option value="07">07</option>
            <option value="08">08</option>
            <option value="09">09</option>
            <option value="10">10</option>
            <option value="11">11</option>
            <option value="12">12</option>
            <option value="13">13</option>
            <option value="14">14</option>
            <option value="15">15</option>
            <option value="16">16</option>
            <option value="17">17</option>
            <option value="18">18</option>
            <option value="19">19</option>
            <option value="20">20</option>
            <option value="21">21</option>
            <option value="22">22</option>
            <option value="23">23</option>
        </select>
        <span class="text-xl font-bold">:</span>
        <select name="menit_mulai" id="menit_mulai" class="p-2 border rounded" required>
            <option value="00">00</option>
            <option value="15">15</option>
            <option value="30">30</option>
            <option value="45">45</option>
        </select>
    </div>
</div>

<div class="mb-4">
    <label for="jam_selesai" class="block text-gray-700 font-bold">Jam Selesai:</label>
    <div class="flex space-x-2">
        <select name="jam_selesai" id="jam_selesai" class="p-2 border rounded" required>
            <option value="00">00</option>
            <option value="01">01</option>
            <option value="02">02</option>
            <option value="03">03</option>
            <option value="04">04</option>
            <option value="05">05</option>
            <option value="06">06</option>
            <option value="07">07</option>
            <option value="08">08</option>
            <option value="09">09</option>
            <option value="10">10</option>
            <option value="11">11</option>
            <option value="12">12</option>
            <option value="13">13</option>
            <option value="14">14</option>
            <option value="15">15</option>
            <option value="16">16</option>
            <option value="17">17</option>
            <option value="18">18</option>
            <option value="19">19</option>
            <option value="20">20</option>
            <option value="21">21</option>
            <option value="22">22</option>
            <option value="23">23</option>
        </select>
        <span class="text-xl font-bold">:</span>
        <select name="menit_selesai" id="menit_selesai" class="p-2 border rounded" required>
            <option value="00">00</option>
            <option value="15">15</option>
            <option value="30">30</option>
            <option value="45">45</option>
        </select>
    </div>
</div>

<input type="hidden" name="jam" id="jam">

        <div class="mb-4">
            <label for ="hari" class="block text-gray-700">Hari Operasional</label>
            <select name="hari" id="hari" class="w-full p-2 border rounded" required>
                <option value="">-- Pilih Hari --</option>
                <option value="Senin">Senin</option>
                <option value="Selasa">Selasa</option>
                <option value="Rabu">Rabu</option>
                <option value="Kamis">Kamis</option>
                <option value="Jumat">Jumat</option>
                <option value="Sabtu">Sabtu</option>
                <option value="Minggu">Minggu</option>
            </select>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700">Harga</label>
            <input type="number" name="price" class="w-full p-2 border border-gray-300 rounded" required>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700">Deskripsi</label>
            <textarea name="description" class="w-full p-2 border border-gray-300 rounded" required></textarea>
        </div>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Tambah Tempat Service</button>
    </form>
    <script>
    document.querySelector('form').addEventListener('submit', function() {
        let jamMulai = document.getElementById('jam_mulai').value + ':' + document.getElementById('menit_mulai').value;
        let jamSelesai = document.getElementById('jam_selesai').value + ':' + document.getElementById('menit_selesai').value;
        document.getElementById('jam').value = jamMulai + ' - ' + jamSelesai;
    });
</script>
</body>
</html>
