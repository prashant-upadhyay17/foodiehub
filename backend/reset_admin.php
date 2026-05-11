<?php
require_once __DIR__ . '/db.php';

try {
    $pdo->exec('DELETE FROM admins');
    $hash = password_hash('default_pass', PASSWORD_DEFAULT);
    $stmt = $pdo->prepare('INSERT INTO admins (name, email, password, created_at) VALUES (?, ?, ?, NOW())');
    $stmt->execute(['Foodie Admin', 'default_eamil', $hash]);
    echo "Admin account has been reset successfully.<br>";
    echo "Email: default_email<br>";
    echo "Password: default_pass";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
