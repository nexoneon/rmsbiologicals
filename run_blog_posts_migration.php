<?php
require_once 'config.php';

// Database connection
try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected to database successfully.<br>";
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Read SQL file
$sql = file_get_contents('create_blog_posts_table.sql');

try {
    // Execute SQL
    $pdo->exec($sql);
    echo "<h2>Creating Blog Posts Table...</h2>";
    echo "<p style='color: green;'>✓ Database updated successfully! Table 'blog_posts' is ready.</p>";
    
    // Check table structure
    $stmt = $pdo->query("DESCRIBE blog_posts");
    $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "<h3>Blog Posts Table Structure:</h3>";
    echo "<table border='1' cellpadding='5' style='border-collapse: collapse;'>";
    echo "<tr><th>Field</th><th>Type</th><th>Null</th><th>Default</th></tr>";
    foreach ($columns as $col) {
        echo "<tr>";
        echo "<td>" . $col['Field'] . "</td>";
        echo "<td>" . $col['Type'] . "</td>";
        echo "<td>" . $col['Null'] . "</td>";
        echo "<td>" . $col['Default'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
    
    // Show sample data
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM blog_posts");
    $count = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "<p>Sample blog posts inserted: " . $count['count'] . "</p>";
    
} catch (PDOException $e) {
    echo "<p style='color: red;'>Error executing SQL: " . $e->getMessage() . "</p>";
}
?>
