<?php
require_once __DIR__ . '/backend/auth.php';
require_once __DIR__ . '/backend/functions.php';
$user = get_user();
$search = $_GET['search'] ?? '';
$sort = $_GET['sort'] ?? '';
$restaurants = get_restaurants($search, $sort);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FoodieHub | Restaurant Listings</title>
    <meta name="description" content="Browse restaurant partners on FoodieHub and filter by cuisine, rating, delivery time, and offers.">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="https://unpkg.com/aos@2.3.4/dist/aos.css" />
</head>
<body class="theme-light">
    <div class="page-shell">
        <?php include __DIR__ . '/backend/header_include.php'; ?>

        <main>
            <section class="section section-intro" data-aos="fade-up">
                <div class="section-heading">
                    <span class="eyebrow">Restaurant partners</span>
                    <h1>Discover flavorful kitchens near you.</h1>
                </div>
                <form class="filter-panel" method="get" action="restaurants.php" data-aos="fade-up" data-aos-delay="100">
                    <input name="search" value="<?= escape($search); ?>" placeholder="Search by cuisine, restaurant name" />
                    <select name="sort" aria-label="Sort restaurants">
                        <option value="">Sort by</option>
                        <option value="rating" <?= $sort === 'rating' ? 'selected' : ''; ?>>Best rated</option>
                        <option value="delivery" <?= $sort === 'delivery' ? 'selected' : ''; ?>>Fastest delivery</option>
                        <option value="offer" <?= $sort === 'offer' ? 'selected' : ''; ?>>Highest offers</option>
                    </select>
                    <button class="button button-primary" type="submit">Apply</button>
                </form>
            </section>
            <section class="section section-alt">
                <div class="grid grid-3 gap-xl">
                    <?php if ($restaurants): ?>
                        <?php foreach ($restaurants as $restaurant): ?>
                        <article class="restaurant-card" data-aos="fade-up">
                            <img src="<?= escape($restaurant['image']); ?>" alt="<?= escape($restaurant['name']); ?>" loading="lazy" />
                            <div class="restaurant-card-body">
                                <div class="restaurant-row">
                                    <h3><?= escape($restaurant['name']); ?></h3>
                                    <span class="status <?= $restaurant['status'] === 'Open' ? 'status-open' : 'status-closed'; ?>"><?= escape($restaurant['status']); ?></span>
                                </div>
                                <p><?= escape($restaurant['cuisine']); ?></p>
                                <div class="restaurant-meta">
                                    <span>⭐ <?= escape($restaurant['rating']); ?></span>
                                    <span><?= escape($restaurant['delivery_time']); ?> mins</span>
                                    <span><?= escape($restaurant['offer']); ?>% off</span>
                                </div>
                                <div class="restaurant-card-footer">
                                    <a href="menu.php?category=<?= escape($restaurant['category_id'] ?? 0); ?>" class="button button-tertiary">View menu</a>
                                </div>
                            </div>
                        </article>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="empty-state" data-aos="fade-up">
                            <h3>No restaurants found</h3>
                            <p>Try changing filters or searching for another cuisine.</p>
                        </div>
                    <?php endif; ?>
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
