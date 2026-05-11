<?php
ob_start();
require_once __DIR__ . '/backend/auth.php';
require_once __DIR__ . '/backend/db.php';
require_once __DIR__ . '/backend/functions.php';
$email = '';
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    if ($email && $password) {
        $stmt = $pdo->prepare('SELECT * FROM users WHERE email = ?');
        $stmt->execute([$email]);
        $user = $stmt->fetch();
        if ($user && password_verify($password, $user['password'])) {
            login_user($user);
            header('Location: dashboard.php');
            exit;
        }
        
        $stmtAdmin = $pdo->prepare('SELECT * FROM admins WHERE email = ?');
        $stmtAdmin->execute([$email]);
        $admin = $stmtAdmin->fetch();
        if ($admin && password_verify($password, $admin['password'])) {
            login_admin($admin);
            header('Location: admin/dashboard.php');
            exit;
        }

        $error = 'Invalid login credentials.';
    } else {
        $error = 'Enter email and password.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FoodieHub | Login</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body class="theme-light">
    <script>
        (function() {
            const theme = localStorage.getItem('foodiehub-theme') || 'theme-light';
            document.body.classList.remove('theme-light', 'theme-dark');
            document.body.classList.add(theme);
        })();
    </script>

    <div class="auth-shell">
        <div class="auth-card" data-aos="fade-up">
            <h1>Welcome back</h1>
            <p>Login to continue ordering delicious meals.</p>
            <?php if ($error): ?>
                <div class="alert alert-error"><?= escape($error); ?></div>
            <?php endif; ?>
            <form method="post">
                <label>Email</label>
                <input type="email" name="email" value="<?= escape($email); ?>" required />
                <label>Password</label>
                <input type="password" name="password" required />
                <button class="button button-primary" type="submit">Login</button>
            </form>
            <div style="margin-top: 24px; text-align: center;">
                <a href="index.php" class="button button-tertiary" style="width: 100%;">← Return to home</a>
            </div>
            <p class="auth-meta">Don’t have an account? <a href="register.php">Register now</a></p>
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
