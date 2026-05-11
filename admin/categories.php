<?php
require_once __DIR__ . '/../backend/auth.php';
require_once __DIR__ . '/../backend/functions.php';
require_admin();
require_once __DIR__ . '/../backend/db.php';
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $slug = trim($_POST['slug'] ?? '');
    $description = trim($_POST['description'] ?? '');
    if ($name && $slug) {
        $stmt = $pdo->prepare('INSERT INTO categories (name, slug, description, sort_order) VALUES (?, ?, ?, ?)');
        $stmt->execute([$name, $slug, $description, 99]);
        $message = 'Category added successfully.';
    }
}
if (isset($_GET['delete'])) {
    $stmt = $pdo->prepare('DELETE FROM categories WHERE id = ?');
    $stmt->execute([$_GET['delete']]);
    header('Location: categories.php');
    exit;
}
$categories = $pdo->query('SELECT * FROM categories ORDER BY sort_order ASC')->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FoodieHub Admin - Categories</title>
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
            <a href="categories.php" class="active">Categories</a>
            <a href="orders.php">Orders</a>
            <a href="users.php">Users</a>
            <a href="logout.php">Logout</a>
        </nav>
    </aside>
    <main class="admin-main">
        <header class="admin-header" style="display:flex; justify-content:space-between; align-items:center;">
            <div>
                <h1>Categories</h1>
                <p>Manage cuisine categories for the menu.</p>
            </div>
            <div style="display:flex; align-items:center; gap: 10px;">
                <button id="themeToggle" class="icon-button" aria-label="Toggle dark mode">🌙</button>
            </div>
        </header>
        <?php if ($message): ?>
            <div class="alert alert-success"><?= escape($message); ?></div>
        <?php endif; ?>
        <section class="glass-panel admin-panel">
            <div class="section-heading"><span class="eyebrow">Add category</span><h2>Food categories</h2></div>
            <form class="admin-form" method="post">
                <label>Name</label>
                <input type="text" name="name" required />
                <label>Slug</label>
                <input type="text" name="slug" required />
                <label>Description</label>
                <textarea name="description"></textarea>
                <button class="button button-primary" type="submit">Add category</button>
            </form>
        </section>
        <section class="glass-panel admin-panel">
            <div class="section-heading"><span class="eyebrow">Category list</span><h2>Active categories</h2></div>
            <div class="table-scroll">
                <table>
                    <thead><tr><th>ID</th><th>Name</th><th>Slug</th><th>Action</th></tr></thead>
                    <tbody>
                        <?php foreach ($categories as $category): ?>
                        <tr>
                            <td><?= escape($category['id']); ?></td>
                            <td><?= escape($category['name']); ?></td>
                            <td><?= escape($category['slug']); ?></td>
                            <td><a class="link-button" href="categories.php?delete=<?= escape($category['id']); ?>">Delete</a></td>
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
