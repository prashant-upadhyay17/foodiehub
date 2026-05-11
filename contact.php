<?php
require_once __DIR__ . '/backend/auth.php';
$user = get_user();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FoodieHub | Contact</title>
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="https://unpkg.com/aos@2.3.4/dist/aos.css" />
</head>
<body class="theme-light">
    <div class="page-shell">
        <?php include __DIR__ . '/backend/header_include.php'; ?>


        <main class="section section-alt contact-shell">
            <div class="section-heading" data-aos="fade-up">
                <span class="eyebrow">Get in touch</span>
                <h1>Need help with your order?</h1>
                <p>Reach us today for support, restaurant partnerships, or product feedback.</p>
            </div>
            <div class="contact-grid" data-aos="fade-up" data-aos-delay="100">
                <div class="contact-card glass-panel">
                    <h2>Contact details</h2>
                    <p>Email: support@foodiehub.com</p>
                    <p>Phone: +91 8318453235</p>
                    <p>Address: 88 Food Lane, Mumbai, India</p>
                </div>
                <form class="contact-card glass-panel">
                    <label>Name</label>
                    <input type="text" placeholder="Your name" />
                    <label>Email</label>
                    <input type="email" placeholder="Your email" />
                    <label>Message</label>
                    <textarea placeholder="How can we help you?" rows="5"></textarea>
                    <button class="button button-primary" type="button">Send message</button>
                </form>
            </div>
            <div class="map-card glass-panel" data-aos="fade-up" data-aos-delay="150">
                <h2>Find us on map</h2>
                <iframe title="FoodieHub location" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3769.2345903512974!2d72.82552927416568!3d18.95709418725425!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3be7b61bdc8d851f%3A0xc1f3e8b802654f78!2sGateway%20of%20India!5e0!3m2!1sen!2sin!4v1716425463959!5m2!1sen!2sin" loading="lazy"></iframe>
            </div>
        </main>

        <footer class="site-footer compact">
            <p>© 2026 FoodieHub. Responsive support and contact info.</p>
        </footer>
    </div>
    <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
    <script src="assets/js/app.js"></script>
    <script>AOS.init({duration:800, once:true});</script>

</body>
</html>
