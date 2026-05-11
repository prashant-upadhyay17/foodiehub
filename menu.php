<?php
require_once __DIR__ . '/backend/auth.php';
require_once __DIR__ . '/backend/functions.php';
$user = get_user();
$categoryFilter = $_GET['category'] ?? null;
$categories = get_categories();
$menuItems = get_menu_items($categoryFilter);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FoodieHub | Menu</title>
    <meta name="description" content="Discover the FoodieHub menu, browse by category, and add meals to your cart with modern responsive design.">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="https://unpkg.com/aos@2.3.4/dist/aos.css" />
</head>
<body class="theme-light">
    <div class="page-shell">
        <?php include __DIR__ . '/backend/header_include.php'; ?>

        <main>
            <section class="section section-intro" data-aos="fade-up">
                <div class="section-heading">
                    <span class="eyebrow">Our menu</span>
                    <h1>Choose from delicious meals and add them to your cart.</h1>
                </div>
            </section>
            <section class="section section-filter" data-aos="fade-up" data-aos-delay="100">
                <div class="category-tabs">
                    <a class="pill <?= !$categoryFilter ? 'active' : ''; ?>" href="menu.php">All</a>
                    <?php foreach ($categories as $category): ?>
                        <a class="pill <?= $categoryFilter == $category['id'] ? 'active' : ''; ?>" href="menu.php?category=<?= escape($category['id']); ?>"><?= escape($category['name']); ?></a>
                    <?php endforeach; ?>
                </div>
            </section>
            <section class="section section-alt">
                <div class="grid grid-3 gap-xl">
                    <?php foreach ($menuItems as $item): ?>
                    <article class="menu-card" data-aos="fade-up" data-aos-delay="<?= ($item['id'] * 50); ?>">
                        <div class="menu-card-top">
                            <img src="<?= escape($item['image']); ?>" alt="<?= escape($item['name']); ?>" loading="lazy" />
                            <span class="menu-category"><?= escape($item['category_name']); ?></span>
                        </div>
                        <div class="menu-card-body">
                            <h3><?= escape($item['name']); ?></h3>
                            <p><?= escape($item['description']); ?></p>
                            <div class="menu-card-meta">
                                <span>₹<?= number_format($item['price']); ?></span>
                                <span>⭐ <?= escape($item['rating']); ?></span>
                            </div>
                            <button class="button button-primary add-cart" data-food='<?= json_encode(["id"=>$item['id'],"name"=>$item['name'],"price"=>$item['price'],"image"=>$item['image']]); ?>'>Add to cart</button>
                        </div>
                    </article>
                    <?php endforeach; ?>
                </div>
            </section>
        </main>

        <?php include __DIR__ . '/backend/footer_include.php'; ?>
    </div>
    <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
    <script src="assets/js/app.js"></script>
    <script>AOS.init({duration:800, once:true});</script>
</body>
</html>
