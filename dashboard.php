<?php
require_once __DIR__ . '/backend/auth.php';
require_once __DIR__ . '/backend/functions.php';
require_user();
$user = get_user();
$orders = get_order_history($user['id']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FoodieHub | Dashboard</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body class="theme-light">
    <div class="page-shell dashboard-shell">
        <?php include __DIR__ . '/backend/header_include.php'; ?>


        <main class="section section-alt">
            <div class="dashboard-grid">
                <section class="profile-card glass-panel" data-aos="fade-up">
                    <div class="section-heading">
                        <span class="eyebrow">Welcome back</span>
                        <h2><?= escape($user['name']); ?></h2>
                    </div>
                    <p><strong>Email:</strong> <?= escape($user['email']); ?></p>
                    <p><strong>Phone:</strong> <?= escape($user['phone'] ?: 'Not set'); ?></p>
                    <p><strong>Address:</strong> <?= escape($user['address'] ?: 'Not set'); ?></p>
                    <a class="button button-primary" href="checkout.php">Checkout now</a>
                    <a class="button button-secondary" href="logout.php">Logout</a>
                </section>
                <section class="orders-card glass-panel" data-aos="fade-up" data-aos-delay="100">
                    <div class="section-heading">
                        <span class="eyebrow">Order history</span>
                        <h2>Your recent meals</h2>
                    </div>
                    <?php if ($orders): ?>
                        <div class="order-list">
                            <?php foreach ($orders as $order): ?>
                                <article class="order-item">
                                    <div>
                                        <strong>Order #<?= escape($order['id']); ?></strong>
                                        <p><?= date('M d, Y', strtotime($order['created_at'])); ?> · <?= escape($order['status']); ?></p>
                                    </div>
                                    <span>₹<?= number_format($order['total']); ?></span>
                                </article>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <p class="empty-state">No orders yet. Start exploring menus and checkout your first meal.</p>
                    <?php endif; ?>
                </section>
            </div>
        </main>

        <footer class="site-footer compact">
            <p>© 2026 FoodieHub. Track your meals and repeat favorites.</p>
        </footer>
    </div>
    <script src="assets/js/app.js"></script>
    <script>AOS.init({duration:800, once:true});</script>

</body>
</html>
