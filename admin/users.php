<?php
require_once __DIR__ . '/../backend/auth.php';
require_once __DIR__ . '/../backend/functions.php';
require_admin();
require_once __DIR__ . '/../backend/db.php';
$users = $pdo->query('SELECT id, name, email, phone, created_at FROM users ORDER BY created_at DESC')->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FoodieHub Admin - Users</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body class="theme-light admin-shell">
    <script>
        (function() {
            const theme = localStorage.getItem('foodiehub-theme') || 'theme-light';
            document.body.classList.remove('theme-light', 'theme-dark');
            document.body.classList.add(theme);
        })();
    </script>
    <aside class="admin-sidebar">
        <div class="brand"><a href="dashboard.php">FoodieHub Admin</a></div>
        <nav>
            <a href="dashboard.php">Dashboard</a>
            <a href="foods.php">Food items</a>
            <a href="categories.php">Categories</a>
            <a href="orders.php">Orders</a>
            <a href="users.php" class="active">Users</a>
            <a href="logout.php">Logout</a>
        </nav>
    </aside>
    <main class="admin-main">
        <header class="admin-header" style="display:flex; justify-content:space-between; align-items:center;">
            <div>
                <h1>Users</h1>
                <p>Manage customer accounts and user records.</p>
            </div>
            <div style="display:flex; align-items:center; gap: 10px;">
                <button id="themeToggle" class="icon-button" aria-label="Toggle dark mode">🌙</button>
            </div>
        </header>
        <section class="glass-panel admin-panel">
            <div class="table-scroll">
                <table>
                    <thead><tr><th>ID</th><th>Name</th><th>Email</th><th>Phone</th><th>Created</th></tr></thead>
                    <tbody>
                        <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?= escape($user['id']); ?></td>
                            <td><?= escape($user['name']); ?></td>
                            <td><?= escape($user['email']); ?></td>
                            <td><?= escape($user['phone'] ?: 'N/A'); ?></td>
                            <td><?= date('d M Y', strtotime($user['created_at'])); ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </section>
    </main>
    <script src="../assets/js/app.js"></script>
</body>
</html>
