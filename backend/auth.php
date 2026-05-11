<?php
session_start();
require_once __DIR__ . '/db.php';

function is_user_logged_in() {
    return !empty($_SESSION['user_id']);
}

function is_admin_logged_in() {
    return !empty($_SESSION['admin_id']);
}

function get_user() {
    global $pdo;
    if (!is_user_logged_in()) {
        return null;
    }
    $stmt = $pdo->prepare('SELECT id, name, email, address, phone FROM users WHERE id = ?');
    $stmt->execute([$_SESSION['user_id']]);
    return $stmt->fetch();
}

function get_admin() {
    global $pdo;
    if (!is_admin_logged_in()) {
        return null;
    }
    $stmt = $pdo->prepare('SELECT id, name, email FROM admins WHERE id = ?');
    $stmt->execute([$_SESSION['admin_id']]);
    return $stmt->fetch();
}

function login_user($user) {
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['user_name'] = $user['name'];
}

function login_admin($admin) {
    $_SESSION['admin_id'] = $admin['id'];
    $_SESSION['admin_name'] = $admin['name'];
}

function require_user() {
    if (!is_user_logged_in()) {
        header('Location: login.php');
        exit;
    }
}

function require_admin() {
    if (!is_admin_logged_in()) {
        header('Location: login.php');
        exit;
    }
}

function logout() {
    session_unset();
    session_destroy();
}
