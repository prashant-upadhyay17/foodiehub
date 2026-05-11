<?php
require_once __DIR__ . '/../backend/auth.php';
require_once __DIR__ . '/../backend/functions.php';
require_admin();
$admin = get_admin();
$counts = get_dashboard_counts();
$recentOrders = get_pending_orders();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FoodieHub Admin Dashboard</title>
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
            <a href="dashboard.php" class="active">Dashboard</a>
            <a href="foods.php">Food items</a>
            <a href="categories.php">Categories</a>
            <a href="orders.php">Orders</a>
            <a href="users.php">Users</a>
            <a href="logout.php">Logout</a>
        </nav>
    </aside>
    <main class="admin-main">
        <header class="admin-header" style="display:flex; justify-content:space-between; align-items:center;">
            <div>
                <h1>Dashboard</h1>
                <p>Welcome back, <?= escape($admin['name']); ?></p>
            </div>
            <div style="display:flex; align-items:center; gap: 10px;">
                <button id="themeToggle" class="icon-button" aria-label="Toggle dark mode">🌙</button>
                <a class="button button-secondary" href="logout.php">Logout</a>
            </div>
        </header>
        <section class="grid grid-4 gap-lg admin-stats">
            <article class="stat-card glass-panel">
                <span>Users</span>
                <strong><?= escape($counts['users']); ?></strong>
            </article>
            <article class="stat-card glass-panel">
                <span>Food items</span>
                <strong><?= escape($counts['food_items']); ?></strong>
            </article>
            <article class="stat-card glass-panel">
                <span>Orders</span>
                <strong><?= escape($counts['orders']); ?></strong>
            </article>
            <article class="stat-card glass-panel">
                <span>Restaurants</span>
                <strong><?= escape($counts['restaurants']); ?></strong>
            </article>
        </section>
        <section class="glass-panel admin-panel">
            <div class="section-heading">
                <span class="eyebrow">Recent orders</span>
                <h2>Latest confirmed orders</h2>
            </div>
            <div class="table-scroll">
                <table>
                    <thead>
                        <tr><th>ID</th><th>User</th><th>Total</th><th>Status</th><th>Date</th></tr>
                    </thead>
                    <tbody>
                        <?php foreach ($recentOrders as $order): ?>
                        <tr>
                            <td><?= escape($order['id']); ?></td>
                            <td><?= escape($order['user_id']); ?></td>
                            <td>₹<?= number_format($order['total']); ?></td>
                            <td><?= escape($order['status']); ?></td>
                            <td><?= date('d M', strtotime($order['created_at'])); ?></td>
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
