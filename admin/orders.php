<?php
require_once __DIR__ . '/../backend/auth.php';
require_once __DIR__ . '/../backend/functions.php';
require_admin();
require_once __DIR__ . '/../backend/db.php';
$orders = $pdo->query('SELECT o.*, u.name AS user_name FROM orders o JOIN users u ON o.user_id = u.id ORDER BY o.created_at DESC')->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FoodieHub Admin - Orders</title>
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
            <a href="orders.php" class="active">Orders</a>
            <a href="users.php">Users</a>
            <a href="logout.php">Logout</a>
        </nav>
    </aside>
    <main class="admin-main">
        <header class="admin-header" style="display:flex; justify-content:space-between; align-items:center;">
            <div>
                <h1>Orders</h1>
                <p>Review customer orders and status.</p>
            </div>
            <div style="display:flex; align-items:center; gap: 10px;">
                <button id="themeToggle" class="icon-button" aria-label="Toggle dark mode">🌙</button>
            </div>
        </header>

        <section class="glass-panel admin-panel">
            <div class="table-scroll">
                <table>
                    <thead><tr><th>ID</th><th>User</th><th>Total</th><th>Status</th><th>Date</th></tr></thead>
                    <tbody>
                        <?php foreach ($orders as $order): ?>
                        <tr>
                            <td><?= escape($order['id']); ?></td>
                            <td><?= escape($order['user_name']); ?></td>
                            <td>₹<?= number_format($order['total'], 2); ?></td>
                            <td><?= escape($order['status']); ?></td>
                            <td><?= date('d M Y', strtotime($order['created_at'])); ?></td>
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
