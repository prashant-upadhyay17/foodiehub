<?php
require_once __DIR__ . '/backend/auth.php';
require_once __DIR__ . '/backend/db.php';
require_once __DIR__ . '/backend/functions.php';
$name = '';
$email = '';
$password = '';
$confirm = '';
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm = $_POST['confirm_password'] ?? '';
    if (!$name || !$email || !$password || !$confirm) {
        $error = 'Please fill in all fields.';
    } elseif ($password !== $confirm) {
        $error = 'Passwords do not match.';
    } else {
        $stmt = $pdo->prepare('SELECT id FROM users WHERE email = ?');
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            $error = 'This email is already registered.';
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $insert = $pdo->prepare('INSERT INTO users (name, email, password, address, phone, created_at) VALUES (?, ?, ?, ?, ?, NOW())');
            $insert->execute([$name, $email, $hash, '', '']);
            $userId = $pdo->lastInsertId();
            $_SESSION['user_id'] = $userId;
            $_SESSION['user_name'] = $name;
            header('Location: dashboard.php');
            exit;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FoodieHub | Register</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body class="theme-light">
    <div class="auth-shell">
        <div class="auth-card" data-aos="fade-up">
            <h1>Create account</h1>
            <p>Register to save your orders, address, and checkout faster.</p>
            <?php if ($error): ?>
                <div class="alert alert-error"><?= escape($error); ?></div>
            <?php endif; ?>
            <form method="post">
                <label>Name</label>
                <input type="text" name="name" value="<?= escape($name); ?>" required />
                <label>Email</label>
                <input type="email" name="email" value="<?= escape($email); ?>" required />
                <label>Password</label>
                <input type="password" name="password" required />
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" required />
                <button class="button button-primary" type="submit">Register</button>
            </form>
            <p class="auth-meta">Already registered? <a href="login.php">Login</a></p>
        </div>
    </div>
    <div class="header-actions" style="position: fixed; top: 20px; right: 20px;">
        <button id="themeToggle" class="icon-button" aria-label="Toggle dark mode">🌙</button>
    </div>
    <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
    <script src="assets/js/app.js"></script>
    <script>AOS.init({duration:800, once:true});</script>
</body>
</html>
