# FoodieHub

FoodieHub is a premium responsive food ordering website built using PHP, MySQL, HTML5, CSS3, and JavaScript. The project includes a modern customer experience, user authentication, a shopping cart using `localStorage`, checkout flow, user dashboard, and admin panel.

## Features

- Landing page with animated hero and category cards
- Search-driven restaurant listing and filterable menu
- Responsive shopping cart with persistent `localStorage`
- Checkout form with payment options and order summary
- User authentication with secure password hashing
- User dashboard for profile and order history
- Admin panel for managing food items, categories, orders, and users
- Premium glassmorphism UI style, dark mode, and animated interactions

## Folder structure

```text
/foodiehub
  /assets
    /css
    /js
    /images
  /admin
  /backend
  /database
  index.php
  login.php
  register.php
  cart.php
  checkout.php
  dashboard.php
  restaurants.php
  menu.php
  logout.php
```

## Setup Instructions

1. Copy the `foodiehub` folder into your XAMPP `htdocs` directory.
2. Start Apache and MySQL from the XAMPP control panel.
3. Create a new database named `db_name`.
4. Import `database/db_name.sql` using phpMyAdmin or MySQL CLI.
5. Open `http://localhost/foodiehub` in your browser.


## Notes

- The cart is persisted in browser `localStorage`.
- The checkout page requires login before placing an order.
- The admin panel uses separate authentication and a responsive sidebar.
