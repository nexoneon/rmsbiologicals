<?php
require_once 'config.php';

// Get product ID from URL
$product_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Database connection
try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Fetch product details
try {
    $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ? AND status = 'active'");
    $stmt->execute([$product_id]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$product) {
        header('Location: products.php');
        exit;
    }
} catch (PDOException $e) {
    die("Error fetching product: " . $e->getMessage());
}

$page_title = $product['name'] . ' - ' . $company_info['name'];
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
        <?php renderHeader('products'); ?>
        
        <main class="main-content">
            <div class="product-detail-container">
                <!-- Breadcrumb -->
                <div class="breadcrumb">
                    <a href="index.php">Home</a> / 
                    <a href="products.php?category=<?php echo urlencode($product['category']); ?>"><?php echo htmlspecialchars($product['category']); ?> Products</a> / 
                    <span><?php echo htmlspecialchars($product['name']); ?></span>
                </div>
                
                <!-- Product Detail Grid -->
                <div class="product-detail-grid">
                    <!-- Product Image Section -->
                    <div class="product-image-section">
                        <div class="product-main-image glossy-card">
                            <?php if (!empty($product['image_url'])): ?>
                                <img src="uploads/<?php echo htmlspecialchars($product['image_url']); ?>" 
                                     alt="<?php echo htmlspecialchars($product['name']); ?>">
                                <div class="zoom-icon">🔍</div>
                            <?php else: ?>
                                <div style="padding: 100px; color: #999;">No Image Available</div>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <!-- Product Info Section -->
                    <div class="product-info-section">
                        <h1><?php echo htmlspecialchars($product['name']); ?></h1>
                        <p class="product-subtitle"><?php echo htmlspecialchars($product['description']); ?></p>
                        
                        <?php if (!empty($product['composition'])): ?>
                        <div class="product-section">
                            <h3>Composition:</h3>
                            <div class="composition-text">
                                <?php echo nl2br(htmlspecialchars($product['composition'])); ?>
                            </div>
                        </div>
                        <?php endif; ?>
                        
                        <?php if (!empty($product['benefits'])): ?>
                        <div class="product-section">
                            <h3>Benefits</h3>
                            <ul class="benefits-list">
                                <?php 
                                $benefits = explode("\n", $product['benefits']);
                                foreach ($benefits as $benefit): 
                                    $benefit = trim($benefit);
                                    if (!empty($benefit)):
                                ?>
                                    <li><?php echo htmlspecialchars($benefit); ?></li>
                                <?php 
                                    endif;
                                endforeach; 
                                ?>
                            </ul>
                        </div>
                        <?php endif; ?>
                        
                        <?php if (!empty($product['dosage'])): ?>
                        <div class="product-section">
                            <div class="dosage-info">
                                <strong>Dosage:</strong> 
                                <span><?php echo htmlspecialchars($product['dosage']); ?></span>
                            </div>
                        </div>
                        <?php endif; ?>
                        
                        <?php if (!empty($product['available_sizes'])): ?>
                        <div class="product-section">
                            <div class="sizes-info">
                                <strong>Available Sizes:</strong> 
                                <span><?php echo htmlspecialchars($product['available_sizes']); ?></span>
                            </div>
                        </div>
                        <?php endif; ?>
                        
                        <div class="product-meta">
                            <p class="product-category">
                                Category: <a href="products.php?category=<?php echo urlencode($product['category']); ?>">
                                    <?php echo htmlspecialchars(ucfirst($product['category'])); ?>
                                </a>
                            </p>
                            
                            <?php if ($product['price'] > 0): ?>
                            <div class="product-price">
                                ₹<?php echo number_format($product['price'], 2); ?>
                            </div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="product-actions">
                            <a href="https://wa.me/<?php echo preg_replace('/[^0-9]/', '', $company_info['phone']); ?>?text=I'm interested in <?php echo urlencode($product['name']); ?>" 
                               class="btn btn-primary" style="background: var(--accent-green);" target="_blank">
                                <span>📱</span> Buy via WhatsApp
                            </a>
                            <a href="contact.php?product=<?php echo urlencode($product['name']); ?>" class="btn btn-primary">
                                Send Inquiry
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        
        <?php renderFooter(); ?>
    </div>
    
    <script src="script.js"></script>
</body>
</html>
