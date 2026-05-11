<?php
require_once __DIR__ . '/../backend/auth.php';
require_once __DIR__ . '/../backend/functions.php';
require_admin();
$admin = get_admin();
require_once __DIR__ . '/../backend/db.php';
$categories = get_categories();
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $category = $_POST['category_id'] ?? 1;
    $price = floatval($_POST['price'] ?? 0);
    $rating = floatval($_POST['rating'] ?? 4.5);
    $description = trim($_POST['description'] ?? '');
    $image = trim($_POST['image'] ?? 'assets/images/food-hero.svg');
    if ($name && $price) {
        $stmt = $pdo->prepare('INSERT INTO food_items (category_id, name, description, price, rating, image, created_at) VALUES (?, ?, ?, ?, ?, ?, NOW())');
        $stmt->execute([$category, $name, $description, $price, $rating, $image]);
        $message = 'Food item added successfully.';
    }
}
if (isset($_GET['delete'])) {
    $stmt = $pdo->prepare('DELETE FROM food_items WHERE id = ?');
    $stmt->execute([$_GET['delete']]);
    header('Location: foods.php');
    exit;
}
$foodItems = $pdo->query('SELECT f.*, c.name AS category_name FROM food_items f JOIN categories c ON f.category_id = c.id ORDER BY f.id DESC')->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FoodieHub Admin - Food Items</title>
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
            <a href="foods.php" class="active">Food items</a>
            <a href="categories.php">Categories</a>
            <a href="orders.php">Orders</a>
            <a href="users.php">Users</a>
            <a href="logout.php">Logout</a>
        </nav>
    </aside>
    <main class="admin-main">
        <header class="admin-header" style="display:flex; justify-content:space-between; align-items:center;">
            <div>
                <h1>Food items</h1>
                <p>Create and manage the menu inventory.</p>
            </div>
            <div style="display:flex; align-items:center; gap: 10px;">
                <button id="themeToggle" class="icon-button" aria-label="Toggle dark mode">🌙</button>
            </div>
        </header>

        <?php if ($message): ?>
            <div class="alert alert-success"><?= escape($message); ?></div>
        <?php endif; ?>

        <section class="glass-panel admin-panel">
            <div class="section-heading">
                <span class="eyebrow">Add new item</span>
                <h2>Add food item to menu</h2>
            </div>
            <form class="admin-form" method="post">
                <label>Name</label>
                <input type="text" name="name" required />
                <label>Category</label>
                <select name="category_id">
                    <?php foreach ($categories as $category): ?>
                        <option value="<?= escape($category['id']); ?>"><?= escape($category['name']); ?></option>
                    <?php endforeach; ?>
                </select>
                <label>Price</label>
                <input type="number" step="0.01" name="price" required />
                <label>Rating</label>
                <input type="number" step="0.1" max="5" min="0" name="rating" value="4.5" />
                <label>Image URL</label>
                <input type="text" name="image" placeholder="assets/images/sample.jpg" />
                <label>Description</label>
                <textarea name="description"></textarea>
                <button class="button button-primary" type="submit">Add item</button>
            </form>
        </section>

        <section class="glass-panel admin-panel">
            <div class="section-heading">
                <span class="eyebrow">Food catalog</span>
                <h2>Manage menu items</h2>
            </div>
            <div class="table-scroll">
                <table>
                    <thead>
                        <tr><th>ID</th><th>Name</th><th>Category</th><th>Price</th><th>Rating</th><th>Action</th></tr>
                    </thead>
                    <tbody>
                        <?php foreach ($foodItems as $food): ?>
                        <tr>
                            <td><?= escape($food['id']); ?></td>
                            <td><?= escape($food['name']); ?></td>
                            <td><?= escape($food['category_name']); ?></td>
                            <td>₹<?= number_format($food['price'], 2); ?></td>
                            <td><?= escape($food['rating']); ?></td>
                            <td><a class="link-button" href="foods.php?delete=<?= escape($food['id']); ?>">Delete</a></td>
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
