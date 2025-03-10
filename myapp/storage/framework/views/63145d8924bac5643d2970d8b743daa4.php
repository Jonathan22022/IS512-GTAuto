<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>
<body>
    <h2>Selamat Datang, <?php echo e(session('user')['username']); ?></h2>
    
    <p>Email: <?php echo e(session('user')['email']); ?></p>
    <p>Nomor HP: <?php echo e(session('user')['nomor_hp']); ?></p>
    <p>Alamat: <?php echo e(session('user')['alamat']); ?></p>

    <br>

    <form action="<?php echo e(url('/logout')); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <button type="submit">Logout</button>
    </form>
</body>
</html>
<?php /**PATH C:\Users\ASUS\Desktop\myapp\resources\views/dashboard.blade.php ENDPATH**/ ?>