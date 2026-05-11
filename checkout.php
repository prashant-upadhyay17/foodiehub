<?php
require_once __DIR__ . '/backend/auth.php';
require_once __DIR__ . '/backend/functions.php';
require_user();
$user = get_user();
$successMessage = '';
$errorMessage = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cartJson = $_POST['cart_data'] ?? '';
    $address = trim($_POST['address'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $payment = $_POST['payment_method'] ?? 'COD';

    if (!$cartJson || !$address || !$phone) {
        $errorMessage = 'Please complete your cart and shipping details.';
    } else {
        $cartItems = json_decode($cartJson, true);
        if (!$cartItems || !is_array($cartItems)) {
            $errorMessage = 'Invalid cart data. Please refresh and try again.';
        } else {
            $subtotal = 0;
            foreach ($cartItems as $item) {
                $subtotal += ($item['price'] * $item['quantity']);
            }
            $delivery = 50;
            $gst = round($subtotal * 0.05);
            $total = $subtotal + $delivery + $gst;

            $stmt = $pdo->prepare('INSERT INTO orders (user_id, total, delivery_charge, gst, address, phone, payment_method, status, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())');
            $stmt->execute([$_SESSION['user_id'], $total, $delivery, $gst, $address, $phone, $payment, 'Confirmed']);
            $orderId = $pdo->lastInsertId();

            $insertItem = $pdo->prepare('INSERT INTO order_items (order_id, food_id, quantity, price) VALUES (?, ?, ?, ?)');
            foreach ($cartItems as $item) {
                $insertItem->execute([$orderId, $item['id'], $item['quantity'], $item['price']]);
            }

            $successMessage = 'Your order is confirmed! Thank you for choosing FoodieHub.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FoodieHub | Checkout</title>
    <meta name="description" content="Checkout at FoodieHub with shipping details, payment options, and a modern order summary.">
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body class="theme-light">
    <div class="page-shell">
        <?php include __DIR__ . '/backend/header_include.php'; ?>


        <main class="section section-alt">
            <div class="checkout-layout">
                <div class="checkout-form glass-panel">
                    <div class="section-heading">
                        <span class="eyebrow">Secure checkout</span>
                        <h1>Complete your order details.</h1>
                    </div>
                    <?php if ($errorMessage): ?>
                        <div class="alert alert-error"><?= escape($errorMessage); ?></div>
                    <?php endif; ?>
                    <?php if ($successMessage): ?>
                        <div class="alert alert-success"><?= escape($successMessage); ?></div>
                    <?php endif; ?>
                    <form id="checkoutForm" method="post" novalidate>
                        <label>Name</label>
                        <input type="text" name="name" value="<?= escape($user['name']); ?>" readonly />
                        <label>Phone</label>
                        <input type="tel" name="phone" id="phone" placeholder="Enter mobile number" required />
                        <label>Delivery address</label>
                        <textarea name="address" id="address" placeholder="House, street, city, pincode" required><?= escape($user['address'] ?? ''); ?></textarea>
                        <label>Payment method</label>
                        <div class="radio-grid">
                            <label><input type="radio" name="payment_method" value="COD" checked /> Cash on Delivery</label>
                            <label><input type="radio" name="payment_method" value="UPI" /> UPI</label>
                            <label><input type="radio" name="payment_method" value="Card" /> Card</label>
                        </div>
                        <input type="hidden" name="cart_data" id="cartData" />
                        <button class="button button-primary" type="submit">Place order</button>
                    </form>
                </div>
                <aside class="order-summary glass-panel" id="orderSummary">
                    <h2>Order summary</h2>
                    <div id="summaryItems"></div>
                    <div class="summary-row"><span>Subtotal</span><span id="summarySubtotal">₹0</span></div>
                    <div class="summary-row"><span>Delivery</span><span>₹50</span></div>
                    <div class="summary-row"><span>GST (5%)</span><span id="summaryGst">₹0</span></div>
                    <div class="summary-row total"><span>Total</span><span id="summaryTotal">₹0</span></div>
                </aside>
            </div>
        </main>

        <footer class="site-footer compact">
            <p>© 2026 FoodieHub. Safe checkout with modern payment options.</p>
        </footer>
    </div>
    <script src="assets/js/app.js"></script>
    <script src="assets/js/checkout.js"></script>

    <?php if ($successMessage): ?>
    <script>localStorage.removeItem('foodiehub_cart');</script>
    <?php endif; ?>
</body>
</html>
