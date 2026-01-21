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
<style>
    /* Critical CSS for Product Detail Layout */
    .product-detail-container {
        max-width: 1200px;
        margin: 40px auto;
        padding: 0 20px;
    }

    .breadcrumb {
        margin-bottom: 30px;
        color: #64748b;
        font-size: 0.95em;
    }

    .breadcrumb a {
        color: #1e3a8a;
        text-decoration: none;
    }

    .product-detail-grid {
        display: grid;
        grid-template-columns: 1fr 1.5fr;
        gap: 50px;
        align-items: start;
    }

    .product-image-section {
        position: sticky;
        top: 100px;
    }

    .product-main-image {
        position: relative;
        overflow: hidden;
        padding: 20px;
        text-align: center;
        background: white;
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 400px;
        border-radius: 16px;
        box-shadow: 0 4px 16px rgba(0,0,0,0.1);
    }

    .product-main-image img {
        max-width: 100%;
        max-height: 500px;
        width: auto;
        display: block;
        margin: 0 auto;
        transition: transform 0.5s ease;
        object-fit: contain;
    }

    .product-main-image:hover img {
        transform: scale(1.05);
    }

    .zoom-icon {
        position: absolute;
        bottom: 20px;
        right: 20px;
        background: white;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        opacity: 0;
        font-size: 18px;
        transition: opacity 0.3s;
    }

    .product-main-image:hover .zoom-icon {
        opacity: 1;
    }

    .product-info-section h1 {
        font-size: 2.5em;
        color: #1e293b;
        margin-bottom: 15px;
        line-height: 1.2;
    }

    .product-subtitle {
        font-size: 1.1em;
        color: #64748b;
        margin-bottom: 30px;
        line-height: 1.6;
    }

    .product-section {
        margin-bottom: 30px;
        padding-bottom: 25px;
        border-bottom: 1px solid #eee;
    }

    .product-section:last-child {
        border-bottom: none;
    }

    .product-section h3 {
        font-size: 1.2em;
        color: #1e3a8a;
        margin-bottom: 15px;
        font-weight: 600;
    }

    .composition-text {
        line-height: 1.8;
        color: #1e293b;
    }

    .benefits-list {
        list-style: none;
        padding: 0;
    }

    .benefits-list li {
        position: relative;
        padding-left: 25px;
        margin-bottom: 12px;
        line-height: 1.5;
        color: #1e293b;
    }

    .benefits-list li::before {
        content: '✓';
        position: absolute;
        left: 0;
        color: #25d366;
        font-weight: bold;
        font-size: 1.1em;
    }

    .dosage-info, .sizes-info {
        font-size: 1.1em;
        color: #1e293b;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .dosage-info strong, .sizes-info strong {
        color: #1e3a8a;
        min-width: 120px;
    }

    .product-meta {
        margin: 30px 0;
        padding: 25px;
        background: #f8f9fa;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 20px;
    }

    .product-category {
        font-size: 1.1em;
        color: #64748b;
        margin: 0;
    }

    .product-category a {
        color: #1e3a8a;
        font-weight: 500;
    }

    .product-price {
        font-size: 2.2em;
        font-weight: 700;
        color: #1e3a8a;
    }

    .product-actions {
        display: flex;
        gap: 20px;
    }

    .product-actions .btn {
        flex: 1;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
    }

    @media (max-width: 900px) {
        .product-detail-grid {
            grid-template-columns: 1fr;
            gap: 40px;
        }
        
        .product-image-section {
            position: static;
            max-width: 600px;
            margin: 0 auto;
        }

        .product-meta {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .product-price {
            margin-top: 10px;
        }
        
        .product-actions {
            flex-direction: column;
        }
    }
</style>
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
