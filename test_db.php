<?php
// Enable error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Database configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'rbsbio');
define('DB_USER', 'root');
define('DB_PASS', '');

echo "<h1>Database Test</h1>";

try {
    // Connect to database
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "<p style='color: green;'>✓ Database connection successful</p>";
    
    // Check if products table exists
    $stmt = $pdo->query("SHOW TABLES LIKE 'products'");
    if ($stmt->rowCount() > 0) {
        echo "<p style='color: green;'>✓ Products table exists</p>";
        
        // Count products
        $stmt = $pdo->query("SELECT COUNT(*) as count FROM products");
        $count = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
        echo "<p style='color: blue;'>ℹ Found $count products in database</p>";
        
        // Show sample products
        if ($count > 0) {
            $stmt = $pdo->query("SELECT id, name, category, price FROM products LIMIT 5");
            $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo "<table border='1' style='margin-top: 20px;'>";
            echo "<tr><th>ID</th><th>Name</th><th>Category</th><th>Price</th></tr>";
            foreach ($products as $product) {
                echo "<tr>";
                echo "<td>" . $product['id'] . "</td>";
                echo "<td>" . htmlspecialchars($product['name']) . "</td>";
                echo "<td>" . htmlspecialchars($product['category']) . "</td>";
                echo "<td>₹" . number_format($product['price'], 2) . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        }
    } else {
        echo "<p style='color: red;'>✗ Products table does not exist</p>";
        echo "<p>Please import the database_setup.sql file first</p>";
    }
    
} catch (PDOException $e) {
    echo "<p style='color: red;'>✗ Database connection failed: " . $e->getMessage() . "</p>";
    echo "<p>Please check:</p>";
    echo "<ul>";
    echo "<li>XAMPP MySQL service is running</li>";
    echo "<li>Database 'rbsbio' exists</li>";
    echo "<li>MySQL user 'root' has permissions</li>";
    echo "</ul>";
}

echo "<hr>";
echo "<p><a href='admin_login.php'>Go to Admin Login</a></p>";
echo "<p><a href='index.php'>Go to Website</a></p>";
?>