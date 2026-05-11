<?php
require_once __DIR__ . '/backend/auth.php';
$user = get_user();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FoodieHub | Cart</title>
    <meta name="description" content="Your FoodieHub cart with quantity controls, pricing summary, and checkout access.">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="https://unpkg.com/aos@2.3.4/dist/aos.css" />
</head>
<body class="theme-light">
    <div class="page-shell">
        <?php include __DIR__ . '/backend/header_include.php'; ?>

        <main class="section section-alt" data-aos="fade-up">
            <div class="section-heading">
                <span class="eyebrow">Your order</span>
                <h1>Review your cart & update quantities.</h1>
            </div>
            <div class="cart-layout">
                <div class="cart-items" id="cartItems"></div>
                <aside class="cart-summary glass-panel">
                    <div class="summary-block">
                        <h3>Quick summary</h3>
                        <div class="summary-row"><span>Subtotal</span><span id="cartSubtotal">₹0</span></div>
                        <div class="summary-row"><span>Delivery</span><span id="cartDelivery">₹50</span></div>
                        <div class="summary-row"><span>GST</span><span id="cartGst">₹0</span></div>
                        <div class="summary-row total"><span>Total</span><span id="cartTotal">₹0</span></div>
                    </div>
                    <a id="checkoutBtn" class="button button-primary" href="checkout.php">Proceed to checkout</a>
                </aside>
            </div>
        </main>

        <?php include __DIR__ . '/backend/footer_include.php'; ?>
    </div>
    <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
    <script src="assets/js/app.js"></script>
    <script src="assets/js/cart.js"></script>
    <script>AOS.init({duration:800, once:true});</script>
</body>
</html>
