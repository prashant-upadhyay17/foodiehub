<?php
require_once __DIR__ . '/db.php';

try {
    $pdo->exec('DELETE FROM admins');
    $hash = password_hash('admin123', PASSWORD_DEFAULT);
    $stmt = $pdo->prepare('INSERT INTO admins (name, email, password, created_at) VALUES (?, ?, ?, NOW())');
    $stmt->execute(['Foodie Admin', 'admin@foodiehub.com', $hash]);
    echo "Admin account has been reset successfully.<br>";
    echo "Email: admin@foodiehub.com<br>";
    echo "Password: admin123";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
