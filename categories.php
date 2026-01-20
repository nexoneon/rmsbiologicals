<?php
require_once 'config.php';
$page_title = 'Categories - ' . $company_info['name'];

// Database connection
try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Fetch categories with product counts
try {
    $stmt = $pdo->query("
        SELECT 
            c.*,
            COUNT(p.id) as product_count
        FROM categories c
        LEFT JOIN products p ON c.name = p.category AND p.status = 'active'
        WHERE c.status = 'active'
        GROUP BY c.id
        ORDER BY c.name ASC
    ");
    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error fetching categories: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($page_title); ?></title>
    <link rel="stylesheet" href="styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="app">
        <?php renderHeader('categories'); ?>
        
        <main class="main-content">
            <div class="page-header">
                <div class="container">
                    <h1>Product Categories</h1>
                    <p class="page-subtitle">Explore our comprehensive range of specialized product categories</p>
                </div>
            </div>
            <div class="container">
                
                <div class="categories-grid">
                    <?php foreach ($categories as $category): ?>
                        <div class="category-card glossy-card">
                            <div class="category-icon">
                                <?php if (!empty($category['image_url'])): ?>
                                    <img src="uploads/<?php echo htmlspecialchars($category['image_url']); ?>" alt="<?php echo htmlspecialchars($category['name']); ?>" style="width: 100%; height: 100%; object-fit: contain;">
                                <?php else: ?>
                                    <span><?php echo $category['icon']; ?></span>
                                <?php endif; ?>
                            </div>
                            <div class="category-content">
                                <h3><?php echo htmlspecialchars($category['name']); ?></h3>
                                <p><?php echo htmlspecialchars($category['description']); ?></p>
                                <div class="category-stats">
                                    <span class="product-count glossy-badge glossy-badge-blue"><?php echo $category['product_count']; ?> Products</span>
                                </div>
                                <div class="category-actions">
                                    <a href="products.php#<?php echo strtolower(str_replace(' ', '-', $category['name'])); ?>" class="btn btn-primary">
                                        View Products
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                
                <section class="category-features">
                    <h2>Why Choose Our Categories?</h2>
                    <div class="features-grid">
                        <div class="feature-item">
                            <div class="feature-icon">🔬</div>
                            <h3>Scientifically Formulated</h3>
                            <p>Each category is developed through extensive research and testing</p>
                        </div>
                        
                        <div class="feature-item">
                            <div class="feature-icon">🎯</div>
                            <h3>Targeted Solutions</h3>
                            <p>Specialized products for specific needs and applications</p>
                        </div>
                        
                        <div class="feature-item">
                            <div class="feature-icon">🌱</div>
                            <h3>Eco-Friendly</h3>
                            <p>Sustainable and environmentally responsible formulations</p>
                        </div>
                        
                        <div class="feature-item">
                            <div class="feature-icon">📊</div>
                            <h3>Proven Results</h3>
                            <p>Track record of success across various industries</p>
                        </div>
                    </div>
                </section>
                
                <section class="contact-cta">
                    <div class="cta-content">
                        <h2>Need Help with Category Selection?</h2>
                        <p>Our experts can help you choose the right category and products for your specific requirements.</p>
                        <div class="cta-buttons">
                            <a href="contact.php" class="btn btn-primary">Consult Our Experts</a>
                            <a href="products.php" class="btn btn-secondary">Browse All Products</a>
                        </div>
                    </div>
                </section>
            </div>
        </main>
        
        <?php renderFooter(); ?>
    </div>
    
    <script src="script.js"></script>
    <script>
        function showCategoryDetails(categoryId) {
            const categoryData = <?php echo json_encode($categories); ?>;
            const category = categoryData.find(c => c.id === categoryId);
            
            if (category) {
                showNotification(`Category: ${category.name} - ${category.description}`);
            }
        }
    </script>
</body>
</html>