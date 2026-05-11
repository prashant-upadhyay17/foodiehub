<?php
require_once __DIR__ . '/auth.php';
$user = get_user();
?>
<script>
    (function() {
        const theme = localStorage.getItem('foodiehub-theme') || 'theme-light';
        document.body.classList.remove('theme-light', 'theme-dark');
        document.body.classList.add(theme);
    })();
</script>
<header class="site-header">
    <div class="brand">
        <a href="index.php">FoodieHub</a>
        <span class="tagline">Fast, fresh, flavourful.</span>
    </div>
    <nav class="main-nav">
        <a href="index.php">Home</a>
        <a href="restaurants.php">Restaurants</a>
        <a href="menu.php">Menu</a>
        <a href="contact.php">Contact</a>
    </nav>
    <div class="header-actions">
        <button id="themeToggle" class="icon-button" aria-label="Toggle dark mode">🌙</button>
        <a class="button button-secondary" href="cart.php">Cart</a>
        <?php if ($user): ?>
            <a class="button button-primary" href="dashboard.php">Hi, <?= escape($user['name']); ?></a>
        <?php else: ?>
            <a class="button button-primary" href="login.php">Login</a>
        <?php endif; ?>
    </div>
</header>
