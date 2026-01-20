<?php
// Run this file in your browser to add the new product fields
// URL: http://localhost/rms/aabt-group-php/run_migration.php

require_once 'config.php';

try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "<h2>Running Product Details Migration...</h2>";
    
    // Check if columns already exist
    $stmt = $pdo->query("SHOW COLUMNS FROM products LIKE 'composition'");
    if ($stmt->rowCount() > 0) {
        echo "<p style='color: orange;'>✓ Columns already exist. Migration not needed.</p>";
    } else {
        // Add new columns
        $pdo->exec("
            ALTER TABLE `products` 
            ADD COLUMN `composition` text DEFAULT NULL AFTER `description`,
            ADD COLUMN `benefits` text DEFAULT NULL AFTER `composition`,
            ADD COLUMN `dosage` varchar(255) DEFAULT NULL AFTER `benefits`,
            ADD COLUMN `available_sizes` varchar(255) DEFAULT NULL AFTER `dosage`
        ");
        
        echo "<p style='color: green;'>✓ Successfully added composition, benefits, dosage, and available_sizes columns!</p>";
    }
    
    // Verify columns were added
    $stmt = $pdo->query("DESCRIBE products");
    $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "<h3>Current Products Table Structure:</h3>";
    echo "<table border='1' cellpadding='5' style='border-collapse: collapse;'>";
    echo "<tr><th>Field</th><th>Type</th><th>Null</th><th>Default</th></tr>";
    foreach ($columns as $col) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($col['Field']) . "</td>";
        echo "<td>" . htmlspecialchars($col['Type']) . "</td>";
        echo "<td>" . htmlspecialchars($col['Null']) . "</td>";
        echo "<td>" . htmlspecialchars($col['Default'] ?? 'NULL') . "</td>";
        echo "</tr>";
    }
    echo "</table>";
    
    echo "<p style='color: green; font-weight: bold;'>Migration completed successfully!</p>";
    echo "<p><a href='admin_dashboard.php'>Go to Admin Dashboard</a></p>";
    
} catch (PDOException $e) {
    echo "<p style='color: red;'>Error: " . htmlspecialchars($e->getMessage()) . "</p>";
}
?>
