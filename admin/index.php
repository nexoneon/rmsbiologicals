<?php
session_start();
require_once '../config.php';
require_once 'database.php';

// Simple authentication (you can enhance this later)
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - <?php echo htmlspecialchars($company_info['name']); ?></title>
    <link rel="stylesheet" href="admin.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="admin-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <h2>Admin Panel</h2>
                <p><?php echo htmlspecialchars($company_info['name']); ?></p>
            </div>
            
            <nav class="sidebar-nav">
                <ul>
                    <li><a href="index.php" class="nav-link active">
                        <span>📊</span> Dashboard
                    </a></li>
                    <li><a href="categories.php" class="nav-link">
                        <span>📁</span> Categories
                    </a></li>
                    <li><a href="products.php" class="nav-link">
                        <span>📦</span> Products
                    </a></li>
                    <li><a href="blog.php" class="nav-link">
                        <span>📝</span> Blog Posts
                    </a></li>
                    <li><a href="contacts.php" class="nav-link">
                        <span>📧</span> Contacts
                    </a></li>
                    <li><a href="testimonials.php" class="nav-link">
                        <span>⭐</span> Testimonials
                    </a></li>
                </ul>
            </nav>
            
            <div class="sidebar-footer">
                <a href="../index.php" class="view-site-btn">
                    <span>🌐</span> View Website
                </a>
                <a href="logout.php" class="logout-btn">
                    <span>🚪</span> Logout
                </a>
            </div>
        </aside>
        
        <!-- Main Content -->
        <main class="main-content">
            <header class="content-header">
                <h1>Dashboard</h1>
                <p>Welcome back, Administrator</p>
            </header>
            
            <div class="dashboard-stats">
                <div class="stat-card">
                    <div class="stat-icon">📁</div>
                    <div class="stat-info">
                        <h3><?php echo count(getAllCategories()); ?></h3>
                        <p>Categories</p>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon">📦</div>
                    <div class="stat-info">
                        <h3>9</h3>
                        <p>Products</p>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon">📝</div>
                    <div class="stat-info">
                        <h3>3</h3>
                        <p>Blog Posts</p>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon">📧</div>
                    <div class="stat-info">
                        <h3>0</h3>
                        <p>New Contacts</p>
                    </div>
                </div>
            </div>
            
            <div class="recent-activity">
                <h2>Recent Activity</h2>
                <div class="activity-list">
                    <div class="activity-item">
                        <span class="activity-time">Today</span>
                        <span class="activity-desc">Database setup completed</span>
                    </div>
                    <div class="activity-item">
                        <span class="activity-time">Today</span>
                        <span class="activity-desc">Admin panel created</span>
                    </div>
                    <div class="activity-item">
                        <span class="activity-time">Today</span>
                        <span class="activity-desc">Categories module added</span>
                    </div>
                </div>
            </div>
        </main>
    </div>
    
    <script src="admin.js"></script>
</body>
</html>