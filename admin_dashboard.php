<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once 'config.php';
require_once 'admin_auth.php';

// Database connection
try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "<!-- Database connected successfully -->";
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Handle operations
$message = '';
$message_type = '';
$active_tab = 'products'; // Default tab


// Handle product operations
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    if ($_POST['action'] === 'add_product') {
        try {
            $stmt = $pdo->prepare("
                INSERT INTO products (name, description, composition, benefits, dosage, available_sizes, category, price, image_url, featured, status) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
            ");
            $stmt->execute([
                $_POST['name'],
                $_POST['description'],
                $_POST['composition'] ?? '',
                $_POST['benefits'] ?? '',
                $_POST['dosage'] ?? '',
                $_POST['available_sizes'] ?? '',
                $_POST['category'],
                $_POST['price'],
                $_POST['image_url'] ?? '',
                isset($_POST['featured']) ? 1 : 0,
                $_POST['status'] ?? 'active'
            ]);
            $message = 'Product added successfully!';
            $message_type = 'success';
        } catch (PDOException $e) {
            $message = 'Error adding product: ' . $e->getMessage();
            $message_type = 'error';
        }
    }
    
    // Update product
    elseif ($_POST['action'] === 'update_product') {
        try {
            $stmt = $pdo->prepare("
                UPDATE products 
                SET name = ?, description = ?, composition = ?, benefits = ?, dosage = ?, available_sizes = ?, category = ?, price = ?, image_url = ?, featured = ?, status = ?
                WHERE id = ?
            ");
            $stmt->execute([
                $_POST['name'],
                $_POST['description'],
                $_POST['composition'] ?? '',
                $_POST['benefits'] ?? '',
                $_POST['dosage'] ?? '',
                $_POST['available_sizes'] ?? '',
                $_POST['category'],
                $_POST['price'],
                $_POST['image_url'] ?? '',
                isset($_POST['featured']) ? 1 : 0,
                $_POST['status'] ?? 'active',
                $_POST['id']
            ]);
            $message = 'Product updated successfully!';
            $message_type = 'success';
        } catch (PDOException $e) {
            $message = 'Error updating product: ' . $e->getMessage();
            $message_type = 'error';
        }
    }
    
    // Delete product
    elseif ($_POST['action'] === 'delete_product') {
        try {
            $stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
            $stmt->execute([$_POST['id']]);
            $message = 'Product deleted successfully!';
            $message_type = 'success';
        } catch (PDOException $e) {
            $message = 'Error deleting product: ' . $e->getMessage();
            $message_type = 'error';
        }
    }
    
    // Handle category operations
    elseif ($_POST['action'] === 'add_category') {
        $active_tab = 'categories';
        try {
            $stmt = $pdo->prepare("
                INSERT INTO categories (name, description, icon, image_url, status) 
                VALUES (?, ?, ?, ?, ?)
            ");
            $stmt->execute([
                $_POST['name'],
                $_POST['description'],
                $_POST['icon'] ?? '',
                $_POST['image_url'] ?? '',
                $_POST['status'] ?? 'active'
            ]);
            $message = 'Category added successfully!';
            $message_type = 'success';
        } catch (PDOException $e) {
            $message = 'Error adding category: ' . $e->getMessage();
            $message_type = 'error';
        }
    }
    
    // Update category
    elseif ($_POST['action'] === 'update_category') {
        $active_tab = 'categories';
        try {
            $stmt = $pdo->prepare("
                UPDATE categories 
                SET name = ?, description = ?, icon = ?, image_url = ?, status = ?
                WHERE id = ?
            ");
            $stmt->execute([
                $_POST['name'],
                $_POST['description'],
                $_POST['icon'] ?? '',
                $_POST['image_url'] ?? '',
                $_POST['status'] ?? 'active',
                $_POST['id']
            ]);
            $message = 'Category updated successfully!';
            $message_type = 'success';
        } catch (PDOException $e) {
            $message = 'Error updating category: ' . $e->getMessage();
            $message_type = 'error';
        }
    }
    
    // Delete category
    elseif ($_POST['action'] === 'delete_category') {
        $active_tab = 'categories';
        try {
            $stmt = $pdo->prepare("DELETE FROM categories WHERE id = ?");
            $stmt->execute([$_POST['id']]);
            $message = 'Category deleted successfully!';
            $message_type = 'success';
        } catch (PDOException $e) {
            $message = 'Error deleting category: ' . $e->getMessage();
            $message_type = 'error';
        }
    }
    
    // Handle Gallery Operations
    elseif ($_POST['action'] === 'add_gallery_image') {
        $active_tab = 'gallery';
        try {
            $stmt = $pdo->prepare("INSERT INTO gallery (title, type, image_url) VALUES (?, ?, ?)");
            $stmt->execute([
                $_POST['title'],
                $_POST['type'],
                $_POST['image_url']
            ]);
            $message = 'Gallery image added successfully!';
            $message_type = 'success';
        } catch (PDOException $e) {
            $message = 'Error adding gallery image: ' . $e->getMessage();
            $message_type = 'error';
        }
    }
    elseif ($_POST['action'] === 'delete_gallery_image') {
        $active_tab = 'gallery';
        try {
            $stmt = $pdo->prepare("DELETE FROM gallery WHERE id = ?");
            $stmt->execute([$_POST['id']]);
            $message = 'Gallery image deleted successfully!';
            $message_type = 'success';
        } catch (PDOException $e) {
            $message = 'Error deleting gallery image: ' . $e->getMessage();
            $message_type = 'error';
        }
    }
    
    // Handle Blog Post Operations
    elseif ($_POST['action'] === 'add_blog_post') {
        $active_tab = 'blog';
        try {
            $stmt = $pdo->prepare("INSERT INTO blog_posts (title, excerpt, content, category, image_url, author, status) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([
                $_POST['title'],
                $_POST['excerpt'],
                $_POST['content'],
                $_POST['category'],
                $_POST['image_url'] ?? null,
                $_POST['author'] ?? null,
                $_POST['status']
            ]);
            $message = 'Blog post added successfully!';
            $message_type = 'success';
        } catch (PDOException $e) {
            $message = 'Error adding blog post: ' . $e->getMessage();
            $message_type = 'error';
        }
    }
    elseif ($_POST['action'] === 'update_blog_post') {
        $active_tab = 'blog';
        try {
            $stmt = $pdo->prepare("UPDATE blog_posts SET title = ?, excerpt = ?, content = ?, category = ?, image_url = ?, author = ?, status = ? WHERE id = ?");
            $stmt->execute([
                $_POST['title'],
                $_POST['excerpt'],
                $_POST['content'],
                $_POST['category'],
                $_POST['image_url'] ?? null,
                $_POST['author'] ?? null,
                $_POST['status'],
                $_POST['id']
            ]);
            $message = 'Blog post updated successfully!';
            $message_type = 'success';
        } catch (PDOException $e) {
            $message = 'Error updating blog post: ' . $e->getMessage();
            $message_type = 'error';
        }
    }
    elseif ($_POST['action'] === 'delete_blog_post') {
        $active_tab = 'blog';
        try {
            $stmt = $pdo->prepare("DELETE FROM blog_posts WHERE id = ?");
            $stmt->execute([$_POST['id']]);
            $message = 'Blog post deleted successfully!';
            $message_type = 'success';
        } catch (PDOException $e) {
            $message = 'Error deleting blog post: ' . $e->getMessage();
            $message_type = 'error';
        }
    }
}

// Fetch all products
try {
    $stmt = $pdo->query("SELECT * FROM products ORDER BY id DESC");
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo "<!-- Found " . count($products) . " products -->";
} catch (PDOException $e) {
    die("Error fetching products: " . $e->getMessage());
}

// Fetch all categories
try {
    $stmt = $pdo->query("SELECT * FROM categories ORDER BY name ASC");
    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo "<!-- Found " . count($categories) . " categories -->";
} catch (PDOException $e) {
    die("Error fetching categories: " . $e->getMessage());
}

// Fetch all gallery items
try {
    $stmt = $pdo->query("SELECT * FROM gallery ORDER BY created_at DESC");
    $gallery_items = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo "<!-- Found " . count($gallery_items) . " gallery items -->";
} catch (PDOException $e) {
    die("Error fetching gallery items: " . $e->getMessage());
}

// Fetch all blog posts
try {
    $stmt = $pdo->query("SELECT * FROM blog_posts ORDER BY created_at DESC");
    $blog_posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo "<!-- Found " . count($blog_posts) . " blog posts -->";
} catch (PDOException $e) {
    die("Error fetching blog posts: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - <?php echo htmlspecialchars($company_info['name']); ?></title>
    <link rel="stylesheet" href="styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        .admin-dashboard {
            background: #f5f5f5;
            min-height: 100vh;
        }
        
        .admin-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px 0;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .admin-header-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .admin-header h1 {
            font-size: 24px;
            margin: 0;
        }
        
        .admin-nav {
            display: flex;
            gap: 20px;
            align-items: center;
        }
        
        .admin-nav a {
            color: white;
            text-decoration: none;
            padding: 8px 16px;
            border-radius: 5px;
            transition: background 0.3s;
        }
        
        .admin-nav a:hover {
            background: rgba(255,255,255,0.2);
        }
        
        .logout-btn {
            background: rgba(255,255,255,0.2);
            border: 1px solid rgba(255,255,255,0.3);
        }
        
        .logout-btn:hover {
            background: rgba(255,255,255,0.3);
        }
        
        .admin-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 40px 20px;
        }
        
        .admin-section {
            background: white;
            border-radius: 10px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            overflow: auto;
        }
        
        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }
        
        .section-header h2 {
            color: #333;
            font-size: 20px;
            margin: 0;
        }
        
        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 500;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }
        
        .btn-success {
            background: #28a745;
            color: white;
        }
        
        .btn-warning {
            background: #ffc107;
            color: #333;
        }
        
        .btn-danger {
            background: #dc3545;
            color: white;
        }
        
        .btn-sm {
            padding: 6px 12px;
            font-size: 12px;
        }
        
        .message {
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        
        .message.success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .message.error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        
        .products-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        
        .products-table th,
        .products-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        
        .products-table th {
            background: #f8f9fa;
            font-weight: 600;
            color: #333;
        }
        
        .products-table tr:hover {
            background: #f8f9fa;
        }
        
        .product-actions {
            display: flex;
            gap: 5px;
        }
        
        .status-badge {
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 500;
        }
        
        .status-badge.active {
            background: #d4edda;
            color: #155724;
        }
        
        .status-badge.inactive {
            background: #f8d7da;
            color: #721c24;
        }
        
        .featured-badge {
            background: #fff3cd;
            color: #856404;
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 500;
        }
        
        /* Blog Posts Table Specific Styles */
        #blog-tab .products-table th:nth-child(1),
        #blog-tab .products-table td:nth-child(1) {
            width: 50px;
            text-align: center;
        }
        
        #blog-tab .products-table th:nth-child(2),
        #blog-tab .products-table td:nth-child(2) {
            width: 30%;
            min-width: 200px;
        }
        
        #blog-tab .products-table th:nth-child(3),
        #blog-tab .products-table td:nth-child(3) {
            width: 15%;
            min-width: 150px;
        }
        
        #blog-tab .products-table th:nth-child(4),
        #blog-tab .products-table td:nth-child(4) {
            width: 15%;
        }
        
        #blog-tab .products-table th:nth-child(5),
        #blog-tab .products-table td:nth-child(5) {
            width: 10%;
            text-align: center;
        }
        
        #blog-tab .products-table th:nth-child(6),
        #blog-tab .products-table td:nth-child(6) {
            width: 12%;
        }
        
        #blog-tab .products-table th:nth-child(7),
        #blog-tab .products-table td:nth-child(7) {
            width: 18%;
            text-align: center;
        }
        
        #blog-tab .status-badge {
            white-space: nowrap;
            display: inline-block;
            padding: 5px 12px;
        }
        
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
        }
        
        .modal-content {
            background: white;
            margin: 5% auto;
            padding: 30px;
            border-radius: 10px;
            width: 90%;
            max-width: 500px;
            max-height: 90vh;
            position: relative;
            overflow-y: auto;
        }
        
        .close {
            position: absolute;
            right: 20px;
            top: 20px;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
            color: #aaa;
        }
        
        .close:hover {
            color: #333;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 500;
        }
        
        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 2px solid #e1e5e9;
            border-radius: 5px;
            font-size: 14px;
        }
        
        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #667eea;
        }
        
        .form-group textarea {
            height: 100px;
            resize: vertical;
            min-height: 80px;
            max-height: 200px;
        }
        
        .checkbox-group {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .checkbox-group input[type="checkbox"] {
            width: auto;
        }
        
        .form-actions {
            display: flex;
            gap: 10px;
            justify-content: flex-end;
            margin-top: 20px;
        }
        
        @media (max-width: 768px) {
            .admin-header-content {
                flex-direction: column;
                gap: 20px;
            }
            
            .admin-nav {
                flex-wrap: wrap;
                justify-content: center;
            }
            
            .products-table {
                font-size: 12px;
            }
            
            .product-actions {
                flex-direction: column;
            }
            
            .modal-content {
                width: 95%;
                max-height: 95vh;
                margin: 2.5% auto;
                padding: 20px;
            }
        }
        
        /* Custom scrollbar for modal */
        .modal-content::-webkit-scrollbar {
            width: 8px;
        }
        
        .modal-content::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }
        
        .modal-content::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 10px;
        }
        
        .modal-content::-webkit-scrollbar-thumb:hover {
            background: #555;
        }
        
        /* Tabs */
        .tabs {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
            border-bottom: 2px solid #e1e5e9;
        }
        
        .tab-button {
            padding: 12px 24px;
            background: none;
            border: none;
            border-bottom: 3px solid transparent;
            cursor: pointer;
            font-size: 16px;
            font-weight: 500;
            color: #666;
            transition: all 0.3s;
            position: relative;
            bottom: -2px;
        }
        
        .tab-button:hover {
            color: #667eea;
        }
        
        .tab-button.active {
            color: #667eea;
            border-bottom-color: #667eea;
        }
        
        .tab-content {
            display: none;
            position: relative;
        }
        
        .tab-content.active {
            display: block;
            margin-bottom: 0;
            padding-bottom: 0;
            position: relative;
        }
        
        /* Image Upload Styles */
        .image-upload-container {
            margin-top: 10px;
        }
        
        .image-upload-area {
            border: 2px dashed #667eea;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            background: #f8f9ff;
            cursor: pointer;
            transition: all 0.3s;
            position: relative;
        }
        
        .image-upload-area:hover {
            border-color: #764ba2;
            background: #f0f2ff;
        }
        
        .image-upload-area.dragover {
            border-color: #764ba2;
            background: #e8ebff;
            transform: scale(1.02);
        }
        
        .upload-icon {
            font-size: 48px;
            color: #667eea;
            margin-bottom: 10px;
        }
        
        .upload-text {
            color: #666;
            font-size: 14px;
        }
        
        .upload-text strong {
            color: #667eea;
        }
        
        .file-input-hidden {
            display: none;
        }
        
        .image-preview-container {
            margin-top: 15px;
            position: relative;
            display: none;
        }
        
        .image-preview-container.show {
            display: block;
        }
        
        .image-preview {
            max-width: 100%;
            max-height: 200px;
            border-radius: 8px;
            border: 2px solid #e1e5e9;
            object-fit: contain;
        }
        
        .image-preview-wrapper {
            position: relative;
            display: inline-block;
        }
        
        .remove-image-btn {
            position: absolute;
            top: -10px;
            right: -10px;
            background: #dc3545;
            color: white;
            border: none;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            cursor: pointer;
            font-size: 18px;
            line-height: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
            transition: all 0.3s;
        }
        
        .remove-image-btn:hover {
            background: #c82333;
            transform: scale(1.1);
        }
        
        .image-filename {
            margin-top: 10px;
            font-size: 13px;
            color: #666;
            word-break: break-all;
        }
    </style>
</head>
<body>
    <div class="admin-dashboard">
        <header class="admin-header">
            <div class="admin-header-content">
                <h1>Admin Dashboard</h1>
                <nav class="admin-nav">
                    <a href="index.php">View Website</a>
                    <a href="admin_logout.php" class="logout-btn">Logout</a>
                </nav>
            </div>
        </header>
        
        <div class="admin-content">
            <?php if (!empty($message)): ?>
                <div class="message <?php echo $message_type; ?>">
                    <?php echo htmlspecialchars($message); ?>
                </div>
            <?php endif; ?>
            
            <div class="admin-section">
                <!-- Tabs Navigation -->
                <div class="tabs">
                    <button class="tab-button <?php echo $active_tab === 'products' ? 'active' : ''; ?>" onclick="switchTab('products')">Products</button>
                    <button class="tab-button <?php echo $active_tab === 'categories' ? 'active' : ''; ?>" onclick="switchTab('categories')">Categories</button>
                    <button class="tab-button <?php echo $active_tab === 'gallery' ? 'active' : ''; ?>" onclick="switchTab('gallery')">Gallery</button>
                    <button class="tab-button <?php echo $active_tab === 'blog' ? 'active' : ''; ?>" onclick="switchTab('blog')">Blog Posts</button>
                </div>
                
                <!-- Products Tab -->
                <div id="products-tab" class="tab-content <?php echo $active_tab === 'products' ? 'active' : ''; ?>">
                    <div class="section-header">
                        <h2>Products Management</h2>
                        <button class="btn btn-primary" onclick="openAddProductModal()">Add New Product</button>
                    </div>
                    
                    <table class="products-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Price</th>
                                <th>Status</th>
                                <th>Featured</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($products as $product): ?>
                                <tr>
                                    <td><?php echo $product['id']; ?></td>
                                    <td><?php echo htmlspecialchars($product['name']); ?></td>
                                    <td><?php echo htmlspecialchars($product['category']); ?></td>
                                    <td>₹<?php echo number_format($product['price'], 2); ?></td>
                                    <td>
                                        <span class="status-badge <?php echo $product['status']; ?>">
                                            <?php echo ucfirst($product['status']); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <?php if ($product['featured']): ?>
                                            <span class="featured-badge">Featured</span>
                                        <?php else: ?>
                                            -
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="product-actions">
                                            <button class="btn btn-warning btn-sm" onclick="openEditProductModal(<?php echo $product['id']; ?>)">Edit</button>
                                            <button class="btn btn-danger btn-sm" onclick="confirmDeleteProduct(<?php echo $product['id']; ?>)">Delete</button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                
                <!-- Categories Tab -->
                <div id="categories-tab" class="tab-content <?php echo $active_tab === 'categories' ? 'active' : ''; ?>">
                    <div class="section-header">
                        <h2>Categories Management</h2>
                        <button class="btn btn-primary" onclick="openAddCategoryModal()">Add New Category</button>
                    </div>
                    
                    <table class="products-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Icon</th>
                                <th>Image</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($categories as $category): ?>
                                <tr>
                                    <td><?php echo $category['id']; ?></td>
                                    <td><?php echo htmlspecialchars($category['name']); ?></td>
                                    <td><?php echo htmlspecialchars(substr($category['description'], 0, 50)) . '...'; ?></td>
                                    <td><?php echo htmlspecialchars($category['icon']); ?></td>
                                    <td><?php echo htmlspecialchars($category['image_url'] ?? '-'); ?></td>
                                    <td>
                                        <span class="status-badge <?php echo $category['status']; ?>">
                                            <?php echo ucfirst($category['status']); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <div class="product-actions">
                                            <button class="btn btn-warning btn-sm" onclick="openEditCategoryModal(<?php echo $category['id']; ?>)">Edit</button>
                                            <button class="btn btn-danger btn-sm" onclick="confirmDeleteCategory(<?php echo $category['id']; ?>)">Delete</button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Gallery Tab -->
                <div id="gallery-tab" class="tab-content <?php echo $active_tab === 'gallery' ? 'active' : ''; ?>">
                    <div class="section-header">
                        <h2>Gallery Management</h2>
                        <button class="btn btn-primary" onclick="openAddGalleryModal()">Add New Image</button>
                    </div>
                    
                    <table class="products-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Image</th>
                                <th>Title</th>
                                <th>Type</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($gallery_items as $item): ?>
                                <tr>
                                    <td><?php echo $item['id']; ?></td>
                                    <td>
                                        <?php if ($item['image_url']): ?>
                                            <img src="uploads/<?php echo htmlspecialchars($item['image_url']); ?>" alt="Gallery Image" style="width: 80px; height: 60px; object-fit: cover; border-radius: 4px;">
                                        <?php else: ?>
                                            -
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo htmlspecialchars($item['title']); ?></td>
                                    <td>
                                        <span class="status-badge active">
                                            <?php echo ucfirst($item['type']); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <div class="product-actions">
                                            <button class="btn btn-danger btn-sm" onclick="confirmDeleteGallery(<?php echo $item['id']; ?>)">Delete</button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            
                <!-- Blog Posts Tab -->
                <div id="blog-tab" class="tab-content <?php echo $active_tab === 'blog' ? 'active' : ''; ?>">
                    <div class="section-header">
                        <h2>Blog Posts Management</h2>
                        <button class="btn btn-primary" onclick="openAddBlogModal()">Add New Blog Post</button>
                    </div>
                    
                    <table class="products-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Title</th>
                                <th>Category</th>
                                <th>Author</th>
                                <th>Status</th>
                                <th>Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($blog_posts as $post): ?>
                                <tr>
                                    <td><?php echo $post['id']; ?></td>
                                    <td><?php echo htmlspecialchars($post['title']); ?></td>
                                    <td>
                                        <span class="status-badge active">
                                            <?php echo htmlspecialchars($post['category']); ?>
                                        </span>
                                    </td>
                                    <td><?php echo htmlspecialchars($post['author'] ?? 'N/A'); ?></td>
                                    <td>
                                        <span class="status-badge <?php echo $post['status'] === 'published' ? 'active' : 'inactive'; ?>">
                                            <?php echo ucfirst($post['status']); ?>
                                        </span>
                                    </td>
                                    <td><?php echo date('M d, Y', strtotime($post['created_at'])); ?></td>
                                    <td>
                                        <div class="product-actions">
                                            <button class="btn btn-warning btn-sm" onclick='openEditBlogModal(<?php echo json_encode($post); ?>)'>Edit</button>
                                            <button class="btn btn-danger btn-sm" onclick="confirmDeleteBlog(<?php echo $post['id']; ?>)">Delete</button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    
    <!-- Add Product Modal -->
    <div id="addModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('addModal')">&times;</span>
            <h2>Add New Product</h2>
            <form method="POST" action="">
                <input type="hidden" name="action" value="add_product">
                
                <div class="form-group">
                    <label for="add_name">Product Name</label>
                    <input type="text" id="add_name" name="name" required>
                </div>
                
                <div class="form-group">
                    <label for="add_description">Description</label>
                    <textarea id="add_description" name="description" required></textarea>
                </div>
                
                <div class="form-group">
                    <label for="add_composition">Composition</label>
                    <textarea id="add_composition" name="composition" placeholder="e.g., Bacillus Strains, Pediococcus"></textarea>
                </div>
                
                <div class="form-group">
                    <label for="add_benefits">Benefits (one per line)</label>
                    <textarea id="add_benefits" name="benefits" placeholder="e.g., Inhibits toxic gases&#10;Develops healthy plankton&#10;Provides healthy environment"></textarea>
                </div>
                
                <div class="form-group">
                    <label for="add_dosage">Dosage</label>
                    <input type="text" id="add_dosage" name="dosage" placeholder="e.g., 5 gms per Kg feed">
                </div>
                
                <div class="form-group">
                    <label for="add_available_sizes">Available Sizes</label>
                    <input type="text" id="add_available_sizes" name="available_sizes" placeholder="e.g., 1kg, 5kg, 25kg">
                </div>
                
                <div class="form-group">
                    <label for="add_category">Category</label>
                    <select id="add_category" name="category" required>
                        <option value="">Select Category</option>
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?php echo htmlspecialchars($cat['name']); ?>">
                                <?php echo htmlspecialchars($cat['name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="add_price">Price (₹)</label>
                    <input type="number" id="add_price" name="price" step="0.01" min="0" required>
                </div>
                
                <div class="form-group">
                    <label for="add_product_image">Product Image</label>
                    <input type="hidden" id="add_product_image_url" name="image_url">
                    
                    <div class="image-upload-container">
                        <div class="image-upload-area" id="add_product_upload_area" onclick="document.getElementById('add_product_image_file').click()">
                            <div class="upload-icon">📷</div>
                            <div class="upload-text">
                                <strong>Click to upload</strong> or drag and drop<br>
                                <small>PNG, JPG, GIF, WebP (Max 5MB)</small>
                            </div>
                        </div>
                        <input type="file" id="add_product_image_file" class="file-input-hidden" accept="image/*" onchange="handleImageUpload(this, 'add_product')">
                        
                        <div class="image-preview-container" id="add_product_preview_container">
                            <div class="image-preview-wrapper">
                                <img id="add_product_preview" class="image-preview" src="" alt="Preview">
                                <button type="button" class="remove-image-btn" onclick="removeImage('add_product')">&times;</button>
                            </div>
                            <div class="image-filename" id="add_product_filename"></div>
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <div class="checkbox-group">
                        <input type="checkbox" id="add_featured" name="featured">
                        <label for="add_featured">Featured Product</label>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="add_status">Status</label>
                    <select id="add_status" name="status" required>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>
                
                <div class="form-actions">
                    <button type="button" class="btn btn-secondary" onclick="closeModal('addModal')">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add Product</button>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Edit Product Modal -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('editModal')">&times;</span>
            <h2>Edit Product</h2>
            <form method="POST" action="">
                <input type="hidden" name="action" value="update_product">
                <input type="hidden" id="edit_id" name="id">
                
                <div class="form-group">
                    <label for="edit_name">Product Name</label>
                    <input type="text" id="edit_name" name="name" required>
                </div>
                
                <div class="form-group">
                    <label for="edit_description">Description</label>
                    <textarea id="edit_description" name="description" required></textarea>
                </div>
                
                <div class="form-group">
                    <label for="edit_composition">Composition</label>
                    <textarea id="edit_composition" name="composition" placeholder="e.g., Bacillus Strains, Pediococcus"></textarea>
                </div>
                
                <div class="form-group">
                    <label for="edit_benefits">Benefits (one per line)</label>
                    <textarea id="edit_benefits" name="benefits" placeholder="e.g., Inhibits toxic gases&#10;Develops healthy plankton&#10;Provides healthy environment"></textarea>
                </div>
                
                <div class="form-group">
                    <label for="edit_dosage">Dosage</label>
                    <input type="text" id="edit_dosage" name="dosage" placeholder="e.g., 5 gms per Kg feed">
                </div>
                
                <div class="form-group">
                    <label for="edit_available_sizes">Available Sizes</label>
                    <input type="text" id="edit_available_sizes" name="available_sizes" placeholder="e.g., 1kg, 5kg, 25kg">
                </div>
                
                <div class="form-group">
                    <label for="edit_category">Category</label>
                    <select id="edit_category" name="category" required>
                        <option value="">Select Category</option>
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?php echo htmlspecialchars($cat['name']); ?>">
                                <?php echo htmlspecialchars($cat['name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="edit_price">Price (₹)</label>
                    <input type="number" id="edit_price" name="price" step="0.01" min="0" required>
                </div>
                
                <div class="form-group">
                    <label for="edit_product_image">Product Image</label>
                    <input type="hidden" id="edit_product_image_url" name="image_url">
                    
                    <div class="image-upload-container">
                        <div class="image-upload-area" id="edit_product_upload_area" onclick="document.getElementById('edit_product_image_file').click()">
                            <div class="upload-icon">📷</div>
                            <div class="upload-text">
                                <strong>Click to upload</strong> or drag and drop<br>
                                <small>PNG, JPG, GIF, WebP (Max 5MB)</small>
                            </div>
                        </div>
                        <input type="file" id="edit_product_image_file" class="file-input-hidden" accept="image/*" onchange="handleImageUpload(this, 'edit_product')">
                        
                        <div class="image-preview-container" id="edit_product_preview_container">
                            <div class="image-preview-wrapper">
                                <img id="edit_product_preview" class="image-preview" src="" alt="Preview">
                                <button type="button" class="remove-image-btn" onclick="removeImage('edit_product')">&times;</button>
                            </div>
                            <div class="image-filename" id="edit_product_filename"></div>
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <div class="checkbox-group">
                        <input type="checkbox" id="edit_featured" name="featured">
                        <label for="edit_featured">Featured Product</label>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="edit_status">Status</label>
                    <select id="edit_status" name="status" required>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>
                
                <div class="form-actions">
                    <button type="button" class="btn btn-secondary" onclick="closeModal('editModal')">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Product</button>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('deleteModal')">&times;</span>
            <h2>Confirm Delete</h2>
            <p>Are you sure you want to delete this product? This action cannot be undone.</p>
            <form method="POST" action="">
                <input type="hidden" name="action" value="delete_product">
                <input type="hidden" id="delete_id" name="id">
                
                <div class="form-actions">
                    <button type="button" class="btn btn-secondary" onclick="closeModal('deleteModal')">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete Product</button>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Add Category Modal -->
    <div id="addCategoryModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('addCategoryModal')">&times;</span>
            <h2>Add New Category</h2>
            <form method="POST" action="">
                <input type="hidden" name="action" value="add_category">
                
                <div class="form-group">
                    <label for="add_cat_name">Category Name</label>
                    <input type="text" id="add_cat_name" name="name" required>
                </div>
                
                <div class="form-group">
                    <label for="add_cat_description">Description</label>
                    <textarea id="add_cat_description" name="description" required></textarea>
                </div>
                
                <div class="form-group">
                    <label for="add_cat_icon">Icon</label>
                    <input type="text" id="add_cat_icon" name="icon" placeholder="e.g., icon-shrimp">
                </div>
                
                <div class="form-group">
                    <label for="add_cat_image">Category Image</label>
                    <input type="hidden" id="add_cat_image_url" name="image_url">
                    
                    <div class="image-upload-container">
                        <div class="image-upload-area" id="add_cat_upload_area" onclick="document.getElementById('add_cat_image_file').click()">
                            <div class="upload-icon">📷</div>
                            <div class="upload-text">
                                <strong>Click to upload</strong> or drag and drop<br>
                                <small>PNG, JPG, GIF, WebP (Max 5MB)</small>
                            </div>
                        </div>
                        <input type="file" id="add_cat_image_file" class="file-input-hidden" accept="image/*" onchange="handleImageUpload(this, 'add_cat')">
                        
                        <div class="image-preview-container" id="add_cat_preview_container">
                            <div class="image-preview-wrapper">
                                <img id="add_cat_preview" class="image-preview" src="" alt="Preview">
                                <button type="button" class="remove-image-btn" onclick="removeImage('add_cat')">&times;</button>
                            </div>
                            <div class="image-filename" id="add_cat_filename"></div>
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="add_cat_status">Status</label>
                    <select id="add_cat_status" name="status" required>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>
                
                <div class="form-actions">
                    <button type="button" class="btn btn-secondary" onclick="closeModal('addCategoryModal')">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add Category</button>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Add Gallery Modal -->
    <div id="addGalleryModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('addGalleryModal')">&times;</span>
            <h2>Add New Gallery Image</h2>
            <form method="POST" action="">
                <input type="hidden" name="action" value="add_gallery_image">
                
                <div class="form-group">
                    <label for="gallery_title">Title (Optional)</label>
                    <input type="text" id="gallery_title" name="title">
                </div>
                
                <div class="form-group">
                    <label for="gallery_type">Type</label>
                    <select id="gallery_type" name="type" required>
                        <option value="products">Products</option>
                        <option value="facility">Facility</option>
                        <option value="events">Events</option>
                        <option value="team">Team</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="gallery_image">Image</label>
                    <input type="hidden" id="add_gallery_image_url" name="image_url" required>
                    
                    <div class="image-upload-container">
                        <div class="image-upload-area" id="add_gallery_upload_area" onclick="document.getElementById('add_gallery_image_file').click()">
                            <div class="upload-icon">📷</div>
                            <div class="upload-text">
                                <strong>Click to upload</strong> or drag and drop<br>
                                <small>PNG, JPG, GIF, WebP (Max 5MB)</small>
                            </div>
                        </div>
                        <input type="file" id="add_gallery_image_file" class="file-input-hidden" accept="image/*" onchange="handleImageUpload(this, 'add_gallery')">
                        
                        <div class="image-preview-container" id="add_gallery_preview_container">
                            <div class="image-preview-wrapper">
                                <img id="add_gallery_preview" class="image-preview" src="" alt="Preview">
                                <button type="button" class="remove-image-btn" onclick="removeImage('add_gallery')">&times;</button>
                            </div>
                            <div class="image-filename" id="add_gallery_filename"></div>
                        </div>
                    </div>
                </div>
                
                <div class="form-actions">
                    <button type="button" class="btn btn-secondary" onclick="closeModal('addGalleryModal')">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add Image</button>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Add Blog Post Modal -->
    <div id="addBlogModal" class="modal">
        <div class="modal-content" style="max-width: 800px;">
            <span class="close" onclick="closeModal('addBlogModal')">&times;</span>
            <h2>Add New Blog Post</h2>
            <form method="POST" action="">
                <input type="hidden" name="action" value="add_blog_post">
                
                <div class="form-group">
                    <label for="add_blog_title">Title *</label>
                    <input type="text" id="add_blog_title" name="title" required>
                </div>
                
                <div class="form-group">
                    <label for="add_blog_excerpt">Excerpt</label>
                    <textarea id="add_blog_excerpt" name="excerpt" rows="2" placeholder="Short summary of the blog post"></textarea>
                </div>
                
                <div class="form-group">
                    <label for="add_blog_content">Content *</label>
                    <textarea id="add_blog_content" name="content" rows="8" required></textarea>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="add_blog_category">Category *</label>
                        <select id="add_blog_category" name="category" required>
                            <option value="">Select Category</option>
                            <?php foreach ($categories as $cat): ?>
                                <option value="<?php echo htmlspecialchars($cat['name']); ?>">
                                    <?php echo htmlspecialchars($cat['name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="add_blog_author">Author</label>
                        <input type="text" id="add_blog_author" name="author" placeholder="Author name">
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="add_blog_status">Status *</label>
                        <select id="add_blog_status" name="status" required>
                            <option value="draft">Draft</option>
                            <option value="published">Published</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="add_blog_image_url">Image URL</label>
                        <input type="text" id="add_blog_image_url" name="image_url" placeholder="Optional image URL">
                    </div>
                </div>
                
                <div class="form-actions">
                    <button type="button" class="btn btn-secondary" onclick="closeModal('addBlogModal')">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add Blog Post</button>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Edit Blog Post Modal -->
    <div id="editBlogModal" class="modal">
        <div class="modal-content" style="max-width: 800px;">
            <span class="close" onclick="closeModal('editBlogModal')">&times;</span>
            <h2>Edit Blog Post</h2>
            <form method="POST" action="">
                <input type="hidden" name="action" value="update_blog_post">
                <input type="hidden" id="edit_blog_id" name="id">
                
                <div class="form-group">
                    <label for="edit_blog_title">Title *</label>
                    <input type="text" id="edit_blog_title" name="title" required>
                </div>
                
                <div class="form-group">
                    <label for="edit_blog_excerpt">Excerpt</label>
                    <textarea id="edit_blog_excerpt" name="excerpt" rows="2"></textarea>
                </div>
                
                <div class="form-group">
                    <label for="edit_blog_content">Content *</label>
                    <textarea id="edit_blog_content" name="content" rows="8" required></textarea>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="edit_blog_category">Category *</label>
                        <select id="edit_blog_category" name="category" required>
                            <option value="">Select Category</option>
                            <?php foreach ($categories as $cat): ?>
                                <option value="<?php echo htmlspecialchars($cat['name']); ?>">
                                    <?php echo htmlspecialchars($cat['name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="edit_blog_author">Author</label>
                        <input type="text" id="edit_blog_author" name="author">
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="edit_blog_status">Status *</label>
                        <select id="edit_blog_status" name="status" required>
                            <option value="draft">Draft</option>
                            <option value="published">Published</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="edit_blog_image_url">Image URL</label>
                        <input type="text" id="edit_blog_image_url" name="image_url">
                    </div>
                </div>
                
                <div class="form-actions">
                    <button type="button" class="btn btn-secondary" onclick="closeModal('editBlogModal')">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Blog Post</button>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Edit Category Modal -->
    <div id="editCategoryModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('editCategoryModal')">&times;</span>
            <h2>Edit Category</h2>
            <form method="POST" action="">
                <input type="hidden" name="action" value="update_category">
                <input type="hidden" id="edit_cat_id" name="id">
                
                <div class="form-group">
                    <label for="edit_cat_name">Category Name</label>
                    <input type="text" id="edit_cat_name" name="name" required>
                </div>
                
                <div class="form-group">
                    <label for="edit_cat_description">Description</label>
                    <textarea id="edit_cat_description" name="description" required></textarea>
                </div>
                
                <div class="form-group">
                    <label for="edit_cat_icon">Icon</label>
                    <input type="text" id="edit_cat_icon" name="icon" placeholder="e.g., icon-shrimp">
                </div>
                
                <div class="form-group">
                    <label for="edit_cat_image">Category Image</label>
                    <input type="hidden" id="edit_cat_image_url" name="image_url">
                    
                    <div class="image-upload-container">
                        <div class="image-upload-area" id="edit_cat_upload_area" onclick="document.getElementById('edit_cat_image_file').click()">
                            <div class="upload-icon">📷</div>
                            <div class="upload-text">
                                <strong>Click to upload</strong> or drag and drop<br>
                                <small>PNG, JPG, GIF, WebP (Max 5MB)</small>
                            </div>
                        </div>
                        <input type="file" id="edit_cat_image_file" class="file-input-hidden" accept="image/*" onchange="handleImageUpload(this, 'edit_cat')">
                        
                        <div class="image-preview-container" id="edit_cat_preview_container">
                            <div class="image-preview-wrapper">
                                <img id="edit_cat_preview" class="image-preview" src="" alt="Preview">
                                <button type="button" class="remove-image-btn" onclick="removeImage('edit_cat')">&times;</button>
                            </div>
                            <div class="image-filename" id="edit_cat_filename"></div>
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="edit_cat_status">Status</label>
                    <select id="edit_cat_status" name="status" required>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>
                
                <div class="form-actions">
                    <button type="button" class="btn btn-secondary" onclick="closeModal('editCategoryModal')">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Category</button>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Delete Category Modal -->
    <div id="deleteCategoryModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('deleteCategoryModal')">&times;</span>
            <h2>Confirm Delete</h2>
            <p>Are you sure you want to delete this category? This action cannot be undone.</p>
            <form method="POST" action="">
                <input type="hidden" name="action" value="delete_category">
                <input type="hidden" id="delete_cat_id" name="id">
                
                <div class="form-actions">
                    <button type="button" class="btn btn-secondary" onclick="closeModal('deleteCategoryModal')">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete Category</button>
                </div>
            </form>
        </div>
    </div>
    
    <script>
        // Product and category data for editing
        const products = <?php echo json_encode($products); ?>;
        const categories = <?php echo json_encode($categories); ?>;
        
        // Tab switching
        function switchTab(tabName) {
            // Hide all tabs
            document.querySelectorAll('.tab-content').forEach(tab => {
                tab.classList.remove('active');
            });
            
            // Remove active class from all buttons
            document.querySelectorAll('.tab-button').forEach(btn => {
                btn.classList.remove('active');
            });
            
            // Show selected tab
            document.getElementById(tabName + '-tab').classList.add('active');
            
            // Add active class to clicked button
            event.target.classList.add('active');
        }
        
        // Product functions
        function openAddProductModal() {
            // Reset the form
            document.getElementById('addModal').querySelector('form').reset();
            // Reset image upload area
            removeImage('add_product');
            document.getElementById('addModal').style.display = 'block';
        }
        
        function openEditProductModal(productId) {
            const product = products.find(p => p.id == productId);
            if (product) {
                document.getElementById('edit_id').value = product.id;
                document.getElementById('edit_name').value = product.name;
                document.getElementById('edit_description').value = product.description;
                document.getElementById('edit_composition').value = product.composition || '';
                document.getElementById('edit_benefits').value = product.benefits || '';
                document.getElementById('edit_dosage').value = product.dosage || '';
                document.getElementById('edit_available_sizes').value = product.available_sizes || '';
                document.getElementById('edit_category').value = product.category;
                document.getElementById('edit_price').value = product.price;
                document.getElementById('edit_product_image_url').value = product.image_url || '';
                document.getElementById('edit_featured').checked = product.featured == 1;
                document.getElementById('edit_status').value = product.status;
                
                // Show existing image preview if available
                if (product.image_url) {
                    const uploadArea = document.getElementById('edit_product_upload_area');
                    uploadArea.style.display = 'none';
                    showImagePreview('edit_product', 'uploads/' + product.image_url, product.image_url);
                } else {
                    // Reset if no image
                    removeImage('edit_product');
                }
                
                document.getElementById('editModal').style.display = 'block';
            }
        }
        
        function confirmDeleteProduct(productId) {
            document.getElementById('delete_id').value = productId;
            document.getElementById('deleteModal').style.display = 'block';
        }
        
        // Category functions
        function openAddCategoryModal() {
            // Reset the form
            document.getElementById('addCategoryModal').querySelector('form').reset();
            // Reset image upload area
            removeImage('add_cat');
            document.getElementById('addCategoryModal').style.display = 'block';
        }
        
        function openEditCategoryModal(categoryId) {
            const category = categories.find(c => c.id == categoryId);
            if (category) {
                document.getElementById('edit_cat_id').value = category.id;
                document.getElementById('edit_cat_name').value = category.name;
                document.getElementById('edit_cat_description').value = category.description;
                document.getElementById('edit_cat_icon').value = category.icon || '';
                document.getElementById('edit_cat_image_url').value = category.image_url || '';
                document.getElementById('edit_cat_status').value = category.status;
                
                // Show existing image preview if available
                if (category.image_url) {
                    const uploadArea = document.getElementById('edit_cat_upload_area');
                    uploadArea.style.display = 'none';
                    showImagePreview('edit_cat', 'uploads/' + category.image_url, category.image_url);
                } else {
                    // Reset if no image
                    removeImage('edit_cat');
                }
                
                document.getElementById('editCategoryModal').style.display = 'block';
            }
        }
        
        function confirmDeleteCategory(categoryId) {
            document.getElementById('delete_cat_id').value = categoryId;
            document.getElementById('deleteCategoryModal').style.display = 'block';
        }

        // Gallery functions
        function openAddGalleryModal() {
            // Reset the form
            document.getElementById('addGalleryModal').querySelector('form').reset();
            // Reset image upload area
            removeImage('add_gallery');
            document.getElementById('addGalleryModal').style.display = 'block';
        }

        function confirmDeleteGallery(id) {
            if (confirm('Are you sure you want to delete this gallery image?')) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.innerHTML = `
                    <input type="hidden" name="action" value="delete_gallery_image">
                    <input type="hidden" name="id" value="${id}">
                `;
                document.body.appendChild(form);
                form.submit();
            }
        }
        
        // Blog functions
        function openAddBlogModal() {
            document.getElementById('addBlogModal').querySelector('form').reset();
            document.getElementById('addBlogModal').style.display = 'block';
        }
        
        function openEditBlogModal(post) {
            document.getElementById('edit_blog_id').value = post.id;
            document.getElementById('edit_blog_title').value = post.title;
            document.getElementById('edit_blog_excerpt').value = post.excerpt || '';
            document.getElementById('edit_blog_content').value = post.content;
            document.getElementById('edit_blog_category').value = post.category;
            document.getElementById('edit_blog_author').value = post.author || '';
            document.getElementById('edit_blog_status').value = post.status;
            document.getElementById('edit_blog_image_url').value = post.image_url || '';
            document.getElementById('editBlogModal').style.display = 'block';
        }
        
        function confirmDeleteBlog(id) {
            if (confirm('Are you sure you want to delete this blog post?')) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.innerHTML = `
                    <input type="hidden" name="action" value="delete_blog_post">
                    <input type="hidden" name="id" value="${id}">
                `;
                document.body.appendChild(form);
                form.submit();
            }
        }
        
        // Common modal functions
        function closeModal(modalId) {
            document.getElementById(modalId).style.display = 'none';
        }
        
        // Close modal when clicking outside
        window.onclick = function(event) {
            if (event.target.classList.contains('modal')) {
                event.target.style.display = 'none';
            }
        }
        
        // Image Upload Functions
        function handleImageUpload(input, prefix) {
            const file = input.files[0];
            if (!file) return;
            
            // Validate file type
            const validTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];
            if (!validTypes.includes(file.type)) {
                alert('Please select a valid image file (JPG, PNG, GIF, or WebP)');
                input.value = '';
                return;
            }
            
            // Validate file size (5MB)
            if (file.size > 5 * 1024 * 1024) {
                alert('File size must be less than 5MB');
                input.value = '';
                return;
            }
            
            // Check if required elements exist
            const uploadArea = document.getElementById(prefix + '_upload_area');
            const hiddenInput = document.getElementById(prefix + '_image_url');
            
            if (!uploadArea) {
                console.error('Upload area not found for prefix:', prefix);
                alert('Upload area not found. Please refresh the page.');
                return;
            }
            
            if (!hiddenInput) {
                console.error('Hidden input not found for prefix:', prefix);
                alert('Image input field not found. Please refresh the page.');
                return;
            }
            
            // Upload file via AJAX
            const formData = new FormData();
            formData.append('image', file);
            
            // Show loading state
            uploadArea.innerHTML = '<div class="upload-icon">⏳</div><div class="upload-text">Uploading...</div>';
            
            fetch('upload_image.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Set the hidden input value
                    hiddenInput.value = data.filename;
                    
                    // Show preview
                    showImagePreview(prefix, data.url, file.name);
                    
                    // Hide upload area
                    uploadArea.style.display = 'none';
                } else {
                    alert('Upload failed: ' + data.message);
                    resetUploadArea(prefix);
                }
            })
            .catch(error => {
                console.error('Upload error:', error);
                alert('Upload error: ' + error.message);
                resetUploadArea(prefix);
            });
        }
        
        function showImagePreview(prefix, imageUrl, filename) {
            try {
                const previewContainer = document.getElementById(prefix + '_preview_container');
                const previewImg = document.getElementById(prefix + '_preview');
                const filenameDiv = document.getElementById(prefix + '_filename');
                
                if (previewImg && previewContainer && filenameDiv) {
                    // Handle image load error
                    previewImg.onerror = function() {
                        console.log('Image failed to load:', imageUrl);
                        // Show placeholder or keep current state
                        this.src = 'data:image/svg+xml,%3Csvg xmlns="http://www.w3.org/2000/svg" width="200" height="200"%3E%3Crect fill="%23ddd" width="200" height="200"/%3E%3Ctext x="50%25" y="50%25" text-anchor="middle" dy=".3em" fill="%23999"%3EImage Not Found%3C/text%3E%3C/svg%3E';
                    };
                    
                    previewImg.src = imageUrl;
                    filenameDiv.textContent = filename;
                    previewContainer.classList.add('show');
                }
            } catch (error) {
                console.log('Error showing image preview:', error);
            }
        }
        
        function removeImage(prefix) {
            try {
                // Clear the hidden input
                const hiddenInput = document.getElementById(prefix + '_image_url');
                if (hiddenInput) {
                    hiddenInput.value = '';
                }
                
                // Clear the file input
                const fileInput = document.getElementById(prefix + '_image_file');
                if (fileInput) {
                    fileInput.value = '';
                }
                
                // Hide preview
                const previewContainer = document.getElementById(prefix + '_preview_container');
                if (previewContainer) {
                    previewContainer.classList.remove('show');
                }
                
                // Clear preview image src
                const previewImg = document.getElementById(prefix + '_preview');
                if (previewImg) {
                    previewImg.src = '';
                }
                
                // Reset upload area
                resetUploadArea(prefix);
            } catch (error) {
                console.log('Error removing image:', error);
                // Continue anyway - don't block the user
            }
        }
        
        function resetUploadArea(prefix) {
            try {
                const uploadArea = document.getElementById(prefix + '_upload_area');
                if (uploadArea) {
                    uploadArea.style.display = 'block';
                    uploadArea.innerHTML = `
                        <div class="upload-icon">📷</div>
                        <div class="upload-text">
                            <strong>Click to upload</strong> or drag and drop<br>
                            <small>PNG, JPG, GIF, WebP (Max 5MB)</small>
                        </div>
                    `;
                }
            } catch (error) {
                console.log('Error resetting upload area:', error);
            }
        }
        
        // Drag and drop functionality
        document.addEventListener('DOMContentLoaded', function() {
            const uploadAreas = document.querySelectorAll('.image-upload-area');
            
            uploadAreas.forEach(area => {
                area.addEventListener('dragover', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    this.classList.add('dragover');
                });
                
                area.addEventListener('dragleave', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    this.classList.remove('dragover');
                });
                
                area.addEventListener('drop', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    this.classList.remove('dragover');
                    
                    const files = e.dataTransfer.files;
                    if (files.length > 0) {
                        // Get the prefix from the area id
                        const prefix = this.id.replace('_upload_area', '');
                        const fileInput = document.getElementById(prefix + '_image_file');
                        fileInput.files = files;
                        handleImageUpload(fileInput, prefix);
                    }
                });
            });
        });
    </script>
</body>
</html>