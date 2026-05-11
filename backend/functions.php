<?php
require_once __DIR__ . '/db.php';

function escape($value) {
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

function get_categories() {
    global $pdo;
    $stmt = $pdo->query('SELECT * FROM categories ORDER BY sort_order ASC');
    return $stmt->fetchAll();
}

function get_popular_foods($limit = 8) {
    global $pdo;
    $stmt = $pdo->prepare('SELECT f.*, c.name AS category_name FROM food_items f JOIN categories c ON f.category_id = c.id ORDER BY f.rating DESC, f.id ASC LIMIT ?');
    $stmt->bindValue(1, (int)$limit, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll();
}

function get_restaurants($search = '', $sort = '') {
    global $pdo;
    $query = 'SELECT * FROM restaurants WHERE 1=1';
    $params = [];
    if ($search) {
        $query .= ' AND (name LIKE ? OR cuisine LIKE ?)';
        $params[] = "%$search%";
        $params[] = "%$search%";
    }
    if ($sort === 'rating') {
        $query .= ' ORDER BY rating DESC';
    } elseif ($sort === 'delivery') {
        $query .= ' ORDER BY delivery_time ASC';
    } elseif ($sort === 'offer') {
        $query .= ' ORDER BY offer DESC';
    } else {
        $query .= ' ORDER BY id ASC';
    }
    $stmt = $pdo->prepare($query);
    $stmt->execute($params);
    return $stmt->fetchAll();
}

function get_menu_items($categoryId = null) {
    global $pdo;
    if ($categoryId) {
        $stmt = $pdo->prepare('SELECT f.*, c.name AS category_name FROM food_items f JOIN categories c ON f.category_id = c.id WHERE f.category_id = ? ORDER BY f.name ASC');
        $stmt->execute([$categoryId]);
    } else {
        $stmt = $pdo->query('SELECT f.*, c.name AS category_name FROM food_items f JOIN categories c ON f.category_id = c.id ORDER BY f.name ASC');
    }
    return $stmt->fetchAll();
}

function get_food_item($foodId) {
    global $pdo;
    $stmt = $pdo->prepare('SELECT f.*, c.name AS category_name FROM food_items f JOIN categories c ON f.category_id = c.id WHERE f.id = ?');
    $stmt->execute([$foodId]);
    return $stmt->fetch();
}

function get_order_history($userId) {
    global $pdo;
    $stmt = $pdo->prepare('SELECT * FROM orders WHERE user_id = ? ORDER BY created_at DESC');
    $stmt->execute([$userId]);
    return $stmt->fetchAll();
}

function get_order_items($orderId) {
    global $pdo;
    $stmt = $pdo->prepare('SELECT oi.*, f.name, f.image FROM order_items oi JOIN food_items f ON oi.food_id = f.id WHERE oi.order_id = ?');
    $stmt->execute([$orderId]);
    return $stmt->fetchAll();
}

function get_dashboard_counts() {
    global $pdo;
    $counts = [];
    $tables = ['users', 'food_items', 'orders', 'restaurants'];
    foreach ($tables as $table) {
        $stmt = $pdo->query("SELECT COUNT(*) AS total FROM $table");
        $counts[$table] = $stmt->fetchColumn();
    }
    return $counts;
}

function get_pending_orders() {
    global $pdo;
    $stmt = $pdo->query("SELECT * FROM orders ORDER BY created_at DESC LIMIT 5");
    return $stmt->fetchAll();
}
