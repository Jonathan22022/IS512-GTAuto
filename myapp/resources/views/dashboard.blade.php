<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>
<body>
    <h2>Selamat Datang, {{ session('user')['username'] }}</h2>
    
    <p>Email: {{ session('user')['email'] }}</p>
    <p>Nomor HP: {{ session('user')['nomor_hp'] }}</p>
    <p>Alamat: {{ session('user')['alamat'] }}</p>

    <br>

    <form action="{{ url('/logout') }}" method="POST">
        @csrf
        <button type="submit">Logout</button>
    </form>
</body>
</html>
