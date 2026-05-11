CREATE DATABASE IF NOT EXISTS foodiehub DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE foodiehub;

DROP TABLE IF EXISTS order_items;
DROP TABLE IF EXISTS orders;
DROP TABLE IF EXISTS restaurants;
DROP TABLE IF EXISTS food_items;
DROP TABLE IF EXISTS categories;
DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS admins;

CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(80) NOT NULL,
    slug VARCHAR(80) NOT NULL UNIQUE,
    description VARCHAR(160) NOT NULL,
    sort_order INT NOT NULL DEFAULT 99
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(120) NOT NULL,
    email VARCHAR(160) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    address TEXT,
    phone VARCHAR(24),
    created_at DATETIME NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(120) NOT NULL,
    email VARCHAR(160) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at DATETIME NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE food_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_id INT NOT NULL,
    name VARCHAR(160) NOT NULL,
    description TEXT NOT NULL,
    price DECIMAL(8,2) NOT NULL,
    rating DECIMAL(2,1) NOT NULL DEFAULT 4.5,
    image VARCHAR(255) NOT NULL,
    created_at DATETIME NOT NULL,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE restaurants (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(140) NOT NULL,
    image VARCHAR(255) NOT NULL,
    rating DECIMAL(2,1) NOT NULL,
    delivery_time INT NOT NULL,
    cuisine VARCHAR(120) NOT NULL,
    offer INT NOT NULL DEFAULT 0,
    status ENUM('Open','Closed') NOT NULL DEFAULT 'Open',
    category_id INT DEFAULT NULL,
    created_at DATETIME NOT NULL,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    total DECIMAL(10,2) NOT NULL,
    delivery_charge DECIMAL(8,2) NOT NULL,
    gst DECIMAL(8,2) NOT NULL,
    address TEXT NOT NULL,
    phone VARCHAR(24) NOT NULL,
    payment_method VARCHAR(32) NOT NULL,
    status VARCHAR(32) NOT NULL,
    created_at DATETIME NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    food_id INT NOT NULL,
    quantity INT NOT NULL,
    price DECIMAL(8,2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (food_id) REFERENCES food_items(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO categories (name, slug, description, sort_order) VALUES
('Pizza','pizza','Thin crust, stone baked, loaded with toppings.','1'),
('Burger','burger','Juicy patties with fresh buns and signature sauces.','2'),
('Biryani','biryani','Aromatic rice dishes layered with rich spices and meat.','3'),
('Chinese','chinese','Stir-fries, noodles, and wok-fresh flavors.','4'),
('Desserts','desserts','Sweet endings including cakes, shakes, and pastries.','5'),
('Drinks','drinks','Refreshing beverages, mocktails, and iced coffees.','6');

INSERT INTO users (name, email, password, address, phone, created_at) VALUES
('Jane Doe','jane@example.com','$2y$10$epSZj.zBB/9kmf.kW5LiNuVNBkiMCe3nrYvrZdFAy2wLHmyfhnKk.','24 Spice Avenue, Mumbai','+91 98765 43210',NOW());

INSERT INTO admins (name, email, password, created_at) VALUES
('Foodie Admin','admin@foodiehub.com','$2y$10$3JuDosDaQODbZQWebE4wzOA4vDNQIOe1kjRYfrfINNAJjXolxuOcO',NOW());

INSERT INTO food_items (category_id, name, description, price, rating, image, created_at) VALUES
(1,'Classic Margherita','Fresh basil, mozzarella, and tomato sauce on thin crust.','399.00','4.8','https://images.unsplash.com/photo-1604908177522-4d3ce1bb6206?auto=format&fit=crop&w=800&q=80',NOW()),
(1,'Pepperoni Feast','Crispy pepperoni with cheddar and tomato glaze.','449.00','4.7','https://images.unsplash.com/photo-1548365328-6ba3000f0f43?auto=format&fit=crop&w=800&q=80',NOW()),
(2,'Smoky Burger','Char-grilled patty with onion jam and melted cheese.','319.00','4.6','https://images.unsplash.com/photo-1550547660-d9450f859349?auto=format&fit=crop&w=800&q=80',NOW()),
(2,'Double Cheese Deluxe','Two patties, double cheese, pickles, and secret sauce.','379.00','4.8','https://images.unsplash.com/photo-1550541563-558e7c293bbf?auto=format&fit=crop&w=800&q=80',NOW()),
(3,'Hyderabadi Biryani','Spiced chicken biryani with saffron rice and raita.','429.00','4.9','https://images.unsplash.com/photo-1604908814297-9f5f554e7a9d?auto=format&fit=crop&w=800&q=80',NOW()),
(3,'Veg Biryani','Fragrant basmati rice with mixed vegetables and herbs.','349.00','4.5','https://images.unsplash.com/photo-1604908177554-0d8bc649c2d3?auto=format&fit=crop&w=800&q=80',NOW()),
(4,'Chili Chicken','Crispy chicken tossed in spicy schezwan sauce.','359.00','4.7','https://images.unsplash.com/photo-1541525162707-5c9d9df750c5?auto=format&fit=crop&w=800&q=80',NOW()),
(4,'Veg Noodles','Wok-tossed noodles with seasonal vegetables and tangy sauce.','299.00','4.6','https://images.unsplash.com/photo-1546069901-ba9599a7e63c?auto=format&fit=crop&w=800&q=80',NOW()),
(5,'Chocolate Lava Cake','Molten chocolate cake served warm with vanilla ice cream.','249.00','4.9','https://images.unsplash.com/photo-1542718618-01a344f0ec34?auto=format&fit=crop&w=800&q=80',NOW()),
(5,'Rainbow Cheesecake','Creamy cheesecake decorated with vibrant berries.','279.00','4.7','https://images.unsplash.com/photo-1551024601-bec78aea704b?auto=format&fit=crop&w=800&q=80',NOW()),
(6,'Iced Berry Mojito','Fresh mint and berry fusion with sparkling soda.','179.00','4.8','https://images.unsplash.com/photo-1528825871115-3581a5387919?auto=format&fit=crop&w=800&q=80',NOW()),
(6,'Cold Brew Shake','Rich coffee blended with vanilla and cream.','199.00','4.7','https://images.unsplash.com/photo-1543163521-1bf539c551e0?auto=format&fit=crop&w=800&q=80',NOW());

INSERT INTO restaurants (name, image, rating, delivery_time, cuisine, offer, status, category_id, created_at) VALUES
('Amber Slice','https://images.unsplash.com/photo-1540189549336-e6e99c3679fe?auto=format&fit=crop&w=800&q=80','4.9',29,'Italian','20','Open',1,NOW()),
('Urban Grill','https://images.unsplash.com/photo-1476224203421-9ac39bcb3327?auto=format&fit=crop&w=800&q=80','4.7',32,'American','15','Open',2,NOW()),
('Spice Route','https://images.unsplash.com/photo-1603133872870-74f0491af29a?auto=format&fit=crop&w=800&q=80','4.8',35,'Indian','25','Open',3,NOW()),
('Wok Way','https://images.unsplash.com/photo-1504674900247-0877df9cc836?auto=format&fit=crop&w=800&q=80','4.6',27,'Chinese','18','Open',4,NOW()),
('Sugar Bloom','https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?auto=format&fit=crop&w=800&q=80','4.9',24,'Desserts','22','Open',5,NOW()),
('Fizz Lounge','https://images.unsplash.com/photo-1505253216577-2a859b6af8b3?auto=format&fit=crop&w=800&q=80','4.5',20,'Drinks','10','Open',6,NOW());

INSERT INTO orders (user_id, total, delivery_charge, gst, address, phone, payment_method, status, created_at) VALUES
(1, 879.00, 50.00, 42.00, '24 Spice Avenue, Mumbai, 400050', '+91 98765 43210', 'COD', 'Delivered', NOW());

INSERT INTO order_items (order_id, food_id, quantity, price) VALUES
(1, 1, 1, 399.00),
(1, 9, 1, 249.00),
(1, 12, 1, 179.00);
