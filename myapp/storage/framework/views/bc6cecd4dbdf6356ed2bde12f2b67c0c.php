<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Pengguna</title>
</head>
<body>
    <h2>Formulir Login</h2>

    <?php if(session('error')): ?>
        <p style="color: red;"><?php echo e(session('error')); ?></p>
    <?php endif; ?>

    <form action="<?php echo e(url('/login')); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <label>Email:</label>
        <input type="email" name="email" required><br><br>

        <label>Password:</label>
        <input type="password" name="password" required><br><br>

        <button type="submit">Login</button>
    </form>
</body>
</html>
<?php /**PATH C:\Users\ASUS\Desktop\myapp\resources\views/login.blade.php ENDPATH**/ ?>