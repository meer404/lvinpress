<?php
/**
 * LVINPress Update Script
 * Run this file to add new tables for the advanced features
 * Access: http://localhost/vinnew/install_update.php
 */

require_once 'config/config.php';

$host = DB_HOST;
$user = DB_USER;
$pass = DB_PASS;
$dbName = DB_NAME;
$charset = 'utf8mb4';

try {
    $pdo = new PDO("mysql:host={$host};dbname={$dbName};charset={$charset}", $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);

    echo "<h2 style='font-family:sans-serif;color:#d4af37;'>LVINPress Update</h2>";

    // ============ REACTIONS TABLE ============
    $pdo->exec("CREATE TABLE IF NOT EXISTS `lvp_article_reactions` (
        `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        `article_id` INT UNSIGNED NOT NULL,
        `user_id` INT UNSIGNED DEFAULT NULL,
        `ip_address` VARCHAR(45) NOT NULL,
        `reaction_type` ENUM('like','love','wow','sad','angry') NOT NULL,
        `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
        INDEX `idx_article` (`article_id`),
        INDEX `idx_user` (`user_id`),
        INDEX `idx_ip` (`ip_address`),
        UNIQUE KEY `unique_user_reaction` (`article_id`, `user_id`, `ip_address`),
        FOREIGN KEY (`article_id`) REFERENCES `lvp_articles`(`id`) ON DELETE CASCADE,
        FOREIGN KEY (`user_id`) REFERENCES `lvp_users`(`id`) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
    echo "<p>✅ Reactions table created</p>";

    echo "<br><h3 style='color:#d4af37;font-family:sans-serif;'>✅ Update Complete!</h3>";
    echo "<p style='font-family:sans-serif;'><a href='index.php' style='color:#d4af37;'>Go to Homepage →</a></p>";
    echo "<p style='font-family:sans-serif;color:red;'><b>⚠️ Delete this install_update.php file after running!</b></p>";

} catch (PDOException $e) {
    echo "<h2 style='color:red;font-family:sans-serif;'>Update Error</h2>";
    echo "<pre>" . $e->getMessage() . "</pre>";
}
