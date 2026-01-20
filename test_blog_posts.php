<?php
require_once 'config.php';

try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "<h2>Testing Blog Posts Table</h2>";
    
    // Check if table exists
    $stmt = $pdo->query("SHOW TABLES LIKE 'blog_posts'");
    $tableExists = $stmt->rowCount() > 0;
    
    if ($tableExists) {
        echo "<p style='color: green;'>✓ Table 'blog_posts' exists</p>";
        
        // Get count
        $stmt = $pdo->query("SELECT COUNT(*) as count FROM blog_posts");
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        echo "<p>Total blog posts: " . $result['count'] . "</p>";
        
        // Get all posts
        $stmt = $pdo->query("SELECT * FROM blog_posts");
        $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        echo "<h3>Blog Posts:</h3>";
        echo "<pre>";
        print_r($posts);
        echo "</pre>";
    } else {
        echo "<p style='color: red;'>✗ Table 'blog_posts' does NOT exist</p>";
        echo "<p>Running migration now...</p>";
        
        // Run migration
        $sql = file_get_contents('create_blog_posts_table.sql');
        $pdo->exec($sql);
        echo "<p style='color: green;'>✓ Migration completed!</p>";
    }
    
} catch (PDOException $e) {
    echo "<p style='color: red;'>Error: " . $e->getMessage() . "</p>";
}
?>
