<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Pengguna</title>
</head>
<body>
    <h2>Formulir Registrasi</h2>

    <?php if(session('success')): ?>
        <p style="color: green;"><?php echo e(session('success')); ?></p>
    <?php endif; ?>

    <?php if(session('error')): ?>
        <p style="color: red;"><?php echo e(session('error')); ?></p>
    <?php endif; ?>

    <form action="<?php echo e(url('/register')); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <label>Username:</label>
        <input type="text" name="username" required><br><br>

        <label>Email:</label>
        <input type="email" name="email" required><br><br>

        <label>Password:</label>
        <input type="password" name="password" required><br><br>

        <label>Nomor HP:</label>
        <input type="text" name="nomor_hp" required><br><br>

        <label>Alamat:</label>
        <textarea name="alamat" required></textarea><br><br>

        <button type="submit">Register</button>
    </form>
    <a href="<?php echo e(url('/login')); ?>">
        <button>Login</button>
    </a>
</body>
</html>
<?php /**PATH C:\Users\ASUS\Desktop\myapp\resources\views/a.blade.php ENDPATH**/ ?>