<?php
require_once __DIR__ . '/backend/auth.php';
require_once __DIR__ . '/backend/functions.php';
$user = get_user();
$categories = get_categories();
$popularFoods = get_popular_foods(8);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FoodieHub | Modern Food Delivery</title>
    <meta name="description" content="FoodieHub - premium food ordering platform with modern UI, fast checkout, and responsive design.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/styles.css">
    <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/aos@2.3.4/dist/aos.css" />
</head>
<body class="theme-light">
    <div class="page-shell">
        <?php include __DIR__ . '/backend/header_include.php'; ?>


        <main>
            <section class="hero hero-fullscreen">
                <div class="hero-content" data-aos="fade-up">
                    <span class="eyebrow">Ready to taste something extraordinary?</span>
                    <h1>Order premium meals from the best local kitchens.</h1>
                    <p>FoodieHub brings vibrant menus, tailored offers, and lightning-fast delivery into one beautiful experience.</p>
                    <div class="hero-cta-group">
                        <a class="button button-primary" href="menu.php">Order Now</a>
                        <a class="button button-secondary" href="#categories">Explore Menu</a>
                    </div>
                    <div class="hero-search-card" data-aos="fade-right" data-aos-delay="150">
                        <div class="search-label">Find restaurants, dishes, or cravings</div>
                        <div class="search-field">
                            <input type="search" placeholder="Search pizza, biryani, burgers..." aria-label="Search food" />
                            <button class="button button-tertiary">Search</button>
                        </div>
                        <div class="search-suggestions">
                            <span>Popular:</span> Pizza, Sushi, Bubble Tea, Biryani
                        </div>
                    </div>
                </div>
                <div class="hero-visual" data-aos="zoom-out" data-aos-delay="200">
                    <div class="glass-card card-main">
                        <img src="assets/images/hero-food.svg" alt="Premium meal" />
                    </div>
                    <div class="glass-card card-small card-1">
                        <strong>+25%</strong>
                        <span>New restaurant partners</span>
                    </div>
                    <div class="glass-card card-small card-2">
                        <strong>Fast Delivery</strong>
                        <span>Under 30 mins</span>
                    </div>
                </div>
            </section>

            <section id="categories" class="section section-glow">
                <div class="section-heading" data-aos="fade-up">
                    <span class="eyebrow">Explore categories</span>
                    <h2>Find your favorite cuisine in seconds.</h2>
                </div>
                <div class="grid grid-3 gap-xl">
                    <?php foreach ($categories as $category): ?>
                    <article class="category-card" data-aos="fade-up" data-aos-delay="<?= ($category['id'] * 80); ?>">
                        <?php 
                            $catImg = 'category-' . strtolower($category['slug']) . '.svg';
                            if (strtolower($category['slug']) == 'pizza') $catImg = 'pizza.png';
                            if (strtolower($category['slug']) == 'burger') $catImg = 'burger.png';
                            if (strtolower($category['slug']) == 'biryani') $catImg = 'biryani.jpg';
                            if (strtolower($category['slug']) == 'chinese') $catImg = 'Chinese.jpg';
                            if (strtolower($category['slug']) == 'desserts') $catImg = 'desserts.png';
                            if (strtolower($category['slug']) == 'drinks') $catImg = 'drinks.jpg';
                        ?>
                        <img src="assets/images/<?= $catImg; ?>" alt="<?= escape($category['name']); ?>" />
                        <div>
                            <h3><?= escape($category['name']); ?></h3>
                            <p><?= escape($category['description']); ?></p>
                        </div>
                        <span class="pill">Explore</span>
                    </article>
                    <?php endforeach; ?>
                </div>
            </section>

            <section class="section section-alt">
                <div class="section-heading" data-aos="fade-up">
                    <span class="eyebrow">Popular now</span>
                    <h2>Top trending dishes from our curated kitchens.</h2>
                </div>
                <div class="grid grid-4 gap-xl">
                    <?php foreach ($popularFoods as $food): ?>
                    <article class="food-card" data-aos="fade-up" data-aos-delay="<?= ($food['id'] * 60); ?>">
                        <div class="food-card-top">
                            <img loading="lazy" src="<?= escape($food['image']); ?>" alt="<?= escape($food['name']); ?>" />
                            <button class="icon-button wishlist" aria-label="Add to wishlist">❤</button>
                        </div>
                        <div class="food-card-body">
                            <h3><?= escape($food['name']); ?></h3>
                            <p><?= escape($food['description']); ?></p>
                            <div class="food-meta">
                                <span class="rating">⭐ <?= escape($food['rating']); ?></span>
                                <span class="price">₹<?= number_format($food['price']); ?></span>
                            </div>
                            <button class="button button-tertiary add-cart" data-food='<?= json_encode(["id"=>$food['id'],"name"=>$food['name'],"price"=>$food['price'],"image"=>$food['image']]); ?>'>Add to Cart</button>
                        </div>
                    </article>
                    <?php endforeach; ?>
                </div>
            </section>

            <section class="section section-glow testimonials" data-aos="fade-up">
                <div class="section-heading">
                    <span class="eyebrow">Loved by foodies</span>
                    <h2>See why customers choose FoodieHub daily.</h2>
                </div>
                <div class="grid grid-3 gap-lg">
                    <article class="testimonial-card">
                        <p>FoodieHub made every meal feel premium. The UI is smooth and the checkout is frictionless.</p>
                        <footer>
                            <strong>Riya Sharma</strong>
                            <span>Food blogger</span>
                        </footer>
                    </article>
                    <article class="testimonial-card">
                        <p>The restaurant selection is amazing, and the animations give it a polished app-like feeling.</p>
                        <footer>
                            <strong>Amit Singh</strong>
                            <span>Delivery partner</span>
                        </footer>
                    </article>
                    <article class="testimonial-card">
                        <p>I ordered biryani and desserts in under 3 minutes. The whole site feels like a modern startup product.</p>
                        <footer>
                            <strong>Neha Iyer</strong>
                            <span>Designer</span>
                        </footer>
                    </article>
                </div>
            </section>

            <section id="faq" class="section section-alt faq-section" data-aos="fade-up">
                <div class="grid grid-2 gap-xl">
                    <div>
                        <span class="eyebrow">Need help?</span>
                        <h2>Frequently asked questions</h2>
                        <p>Everything you need to know about ordering, checkout, and how FoodieHub keeps your meal fresh.</p>
                    </div>
                    <div class="accordion">
                        <details open>
                            <summary>How fast is delivery?</summary>
                            <p>Most orders are delivered within 30-40 minutes. Delivery estimates are shown on every restaurant card.</p>
                        </details>
                        <details>
                            <summary>Can I modify my order?</summary>
                            <p>Yes. You can update quantities or remove items in the cart before checkout.</p>
                        </details>
                        <details>
                            <summary>Is there a membership plan?</summary>
                            <p>Coming soon. We are building premium loyalty features for frequent food lovers.</p>
                        </details>
                    </div>
                </div>
            </section>
        </main>

        <?php include __DIR__ . '/backend/footer_include.php'; ?>

    </div>

    <script src="assets/js/app.js"></script>
    <script>
        AOS.init({ duration: 900, once: true });
    </script>
</body>
</html>
