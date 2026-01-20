<?php
require_once 'config.php';
$page_title = 'Products - ' . $company_info['name'];

// Database connection
try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Get category filter from URL if provided
$category_filter = isset($_GET['category']) ? $_GET['category'] : null;

// Fetch products grouped by category
try {
    if ($category_filter) {
        // Fetch products for specific category
        $stmt = $pdo->prepare("
            SELECT * FROM products 
            WHERE status = 'active' AND category = ?
            ORDER BY featured DESC, name ASC
        ");
        $stmt->execute([$category_filter]);
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Get category info
        $stmt = $pdo->prepare("SELECT * FROM categories WHERE name = ? AND status = 'active'");
        $stmt->execute([$category_filter]);
        $current_category = $stmt->fetch(PDO::FETCH_ASSOC);
    } else {
        // Fetch all active products
        $stmt = $pdo->query("
            SELECT * FROM products 
            WHERE status = 'active'
            ORDER BY category, featured DESC, name ASC
        ");
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // Group products by category
    $product_categories = [];
    foreach ($products as $product) {
        if (!isset($product_categories[$product['category']])) {
            $product_categories[$product['category']] = [
                'name' => $product['category'],
                'products' => []
            ];
        }
        $product_categories[$product['category']]['products'][] = $product;
    }
    
} catch (PDOException $e) {
    die("Error fetching products: " . $e->getMessage());
}

// Fetch all categories for filter
try {
    $stmt = $pdo->query("SELECT * FROM categories WHERE status = 'active' ORDER BY name ASC");
    $all_categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $all_categories = [];
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
    <style>
        /* Rich UI Enhancements for Products Page */
        .page-header {
            text-align: center;
            padding: 60px 20px 40px;
            background: linear-gradient(135deg, #f97316 0%, #fb923c 50%, #3b82f6 100%);
            color: white;
            margin-bottom: 40px;
            border-radius: 0 0 30px 30px;
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.2);
        }
        
        .page-header h1 {
            font-size: 42px;
            font-weight: 700;
            margin-bottom: 15px;
            text-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .page-subtitle {
            font-size: 18px;
            opacity: 0.95;
            max-width: 600px;
            margin: 0 auto;
        }
        
        .breadcrumb {
            padding: 20px 0;
            color: #718096;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .breadcrumb a {
            color: #667eea;
            text-decoration: none;
            transition: color 0.3s;
        }
        
        .breadcrumb a:hover {
            color: #764ba2;
        }
        
        .products-filter-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 25px;
            background: white;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
            margin-bottom: 40px;
        }
        
        .results-count {
            color: #4a5568;
            font-weight: 500;
        }
        
        .filter-select {
            padding: 12px 20px;
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            font-size: 15px;
            color: #2d3748;
            background: white;
            cursor: pointer;
            transition: all 0.3s;
            min-width: 200px;
        }
        
        .filter-select:hover {
            border-color: #667eea;
        }
        
        .filter-select:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }
        
        .category-divider {
            margin: 50px 0 30px;
            padding-bottom: 15px;
            border-bottom: 3px solid #667eea;
        }
        
        .category-divider h2 {
            font-size: 28px;
            color: #2d3748;
            font-weight: 700;
            display: inline-block;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 30px;
            margin-bottom: 50px;
        }
        
        .product-card {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
        }
        
        .product-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(102, 126, 234, 0.2);
        }
        
        .product-image {
            position: relative;
            height: 280px;
            background: linear-gradient(135deg, #f5f7fa 0%, #e9ecef 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }
        
        .product-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }
        
        .product-card:hover .product-image img {
            transform: scale(1.1);
        }
        
        .product-placeholder {
            font-size: 80px;
            opacity: 0.3;
        }
        
        .featured-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            color: white;
            padding: 6px 15px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            box-shadow: 0 4px 10px rgba(245, 87, 108, 0.3);
        }
        
        .product-content {
            padding: 25px;
        }
        
        .product-category {
            color: #667eea;
            font-size: 13px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 10px;
        }
        
        .product-content h3 {
            font-size: 20px;
            color: #2d3748;
            margin-bottom: 12px;
            font-weight: 700;
            line-height: 1.4;
        }
        
        .product-description {
            color: #718096;
            font-size: 14px;
            line-height: 1.6;
            margin-bottom: 15px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        
        .product-price {
            font-size: 24px;
            color: #667eea;
            font-weight: 700;
            margin: 15px 0;
        }
        
        .product-btn {
            width: 100%;
            padding: 14px 25px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-block;
            text-align: center;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        }
        
        .product-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
        }
        
        .product-features {
            margin-top: 50px;
            padding: 60px 0;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            border-radius: 30px;
        }
        
        .product-features h2 {
            text-align: center;
            font-size: 32px;
            color: #2d3748;
            margin-bottom: 50px;
            font-weight: 700;
        }
        
        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 30px;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }
        
        .feature-item {
            text-align: center;
            padding: 30px;
            background: white;
            border-radius: 20px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
            transition: all 0.3s;
        }
        
        .feature-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.12);
        }
        
        .feature-icon {
            font-size: 50px;
            margin-bottom: 20px;
        }
        
        .feature-item h3 {
            font-size: 20px;
            color: #2d3748;
            margin-bottom: 12px;
            font-weight: 600;
        }
        
        .feature-item p {
            color: #718096;
            line-height: 1.6;
        }
        
        .contact-cta {
            margin-top: 60px;
            padding: 60px 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 30px;
            text-align: center;
            color: white;
        }
        
        .cta-content h2 {
            font-size: 32px;
            margin-bottom: 15px;
            font-weight: 700;
        }
        
        .cta-content p {
            font-size: 18px;
            margin-bottom: 30px;
            opacity: 0.95;
        }
        
        .cta-buttons {
            display: flex;
            gap: 20px;
            justify-content: center;
            flex-wrap: wrap;
        }
        
        .btn-primary, .btn-secondary {
            padding: 15px 35px;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s;
            display: inline-block;
        }
        
        .btn-primary {
            background: white;
            color: #667eea;
            box-shadow: 0 4px 15px rgba(255,255,255,0.3);
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(255,255,255,0.4);
        }
        
        .btn-secondary {
            background: rgba(255,255,255,0.2);
            color: white;
            border: 2px solid white;
        }
        
        .btn-secondary:hover {
            background: rgba(255,255,255,0.3);
            transform: translateY(-2px);
        }
        
        @media (max-width: 768px) {
            .page-header h1 {
                font-size: 32px;
            }
            
            .products-grid {
                grid-template-columns: 1fr;
            }
            
            .products-filter-bar {
                flex-direction: column;
                gap: 15px;
            }
            
            .filter-select {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="app">
        <?php renderHeader('products'); ?>
        
        <main class="main-content">
            <div class="container">
                <!-- Breadcrumb -->
                <div class="breadcrumb">
                    <a href="index.php">Home</a> / 
                    <?php if ($category_filter): ?>
                        <a href="products.php">Products</a> / 
                        <span><?php echo htmlspecialchars($category_filter); ?></span>
                    <?php else: ?>
                        <span>Products</span>
                    <?php endif; ?>
                </div>
                
                <div class="page-header">
                    <h1><?php echo $category_filter ? htmlspecialchars($category_filter) . ' Products' : 'All Products'; ?></h1>
                    <?php if ($category_filter && isset($current_category)): ?>
                        <p class="page-subtitle"><?php echo htmlspecialchars($current_category['description']); ?></p>
                    <?php else: ?>
                        <?php 
                            // Dynamically generate subtitle from categories
                            $cat_names = array_column($all_categories, 'name');
                            $visible_cats = array_slice($cat_names, 0, 3);
                            $cat_list = implode(', ', $visible_cats);
                            if (count($cat_names) > 3) {
                                $cat_list .= ', and other';
                            }
                        ?>
                        <p class="page-subtitle">Comprehensive range of <?php echo htmlspecialchars($cat_list); ?> solutions</p>
                    <?php endif; ?>
                </div>
                
                <!-- Filter and Sort Bar -->
                <div class="products-filter-bar">
                    <div class="filter-left">
                        <p class="results-count">
                            Showing <?php echo count($products); ?> of <?php echo count($products); ?> results
                        </p>
                    </div>
                    <div class="filter-right">
                        <select class="filter-select" onchange="window.location.href='products.php?category=' + this.value">
                            <option value="">All Categories</option>
                            <?php foreach ($all_categories as $cat): ?>
                                <option value="<?php echo htmlspecialchars($cat['name']); ?>" 
                                    <?php echo ($category_filter == $cat['name']) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($cat['name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                
                <?php foreach ($product_categories as $cat_name => $cat_data): ?>
                    <?php if (!$category_filter): ?>
                        <div class="category-divider">
                            <h2><?php echo htmlspecialchars($cat_name); ?></h2>
                        </div>
                    <?php endif; ?>
                    
                    <div class="products-grid">
                        <?php foreach ($cat_data['products'] as $product): ?>
                            <div class="product-card glossy-card">
                                <div class="product-image">
                                    <?php if (!empty($product['image_url'])): ?>
                                        <img src="uploads/<?php echo htmlspecialchars($product['image_url']); ?>" 
                                             alt="<?php echo htmlspecialchars($product['name']); ?>">
                                    <?php else: ?>
                                        <div class="product-placeholder">
                                            <span class="product-emoji">📦</span>
                                        </div>
                                    <?php endif; ?>
                                    <?php if ($product['featured']): ?>
                                        <span class="featured-badge glossy-badge glossy-badge-orange">Featured</span>
                                    <?php endif; ?>
                                </div>
                                <div class="product-content">
                                    <p class="product-category glossy-badge glossy-badge-blue"><?php echo htmlspecialchars($product['category']); ?></p>
                                    <h3><?php echo htmlspecialchars($product['name']); ?></h3>
                                    <p class="product-description"><?php echo htmlspecialchars(substr($product['description'], 0, 100)) . '...'; ?></p>
                                    <?php if ($product['price'] > 0): ?>
                                        <p class="product-price">₹<?php echo number_format($product['price'], 2); ?></p>
                                    <?php endif; ?>
                                    <a href="product_detail.php?id=<?php echo $product['id']; ?>" class="btn product-btn">
                                        View Details
                                    </a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endforeach; ?>
                
            </div>
        </main>
        
        <?php renderFooter(); ?>
    </div>
    
    <script src="script.js"></script>
</body>
</html>