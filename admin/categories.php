<?php
session_start();
require_once '../config.php';
require_once 'database.php';

// Simple authentication
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit();
}

// Handle form submissions
$message = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'add':
                $name = trim($_POST['name']);
                $description = trim($_POST['description']);
                $icon = trim($_POST['icon']);
                $status = $_POST['status'];
                
                if (empty($name) || empty($description)) {
                    $error = 'Name and description are required!';
                } else {
                    if (addCategory($name, $description, $icon, $status)) {
                        $message = 'Category added successfully!';
                    } else {
                        $error = 'Failed to add category!';
                    }
                }
                break;
                
            case 'edit':
                $id = $_POST['id'];
                $name = trim($_POST['name']);
                $description = trim($_POST['description']);
                $icon = trim($_POST['icon']);
                $status = $_POST['status'];
                
                if (empty($name) || empty($description)) {
                    $error = 'Name and description are required!';
                } else {
                    if (updateCategory($id, $name, $description, $icon, $status)) {
                        $message = 'Category updated successfully!';
                    } else {
                        $error = 'Failed to update category!';
                    }
                }
                break;
                
            case 'delete':
                $id = $_POST['id'];
                if (deleteCategory($id)) {
                    $message = 'Category deleted successfully!';
                } else {
                    $error = 'Failed to delete category!';
                }
                break;
        }
    }
}

// Get all categories
$categories = getAllCategories();

// Get category for editing
$editCategory = null;
if (isset($_GET['edit'])) {
    $editCategory = getCategoryById($_GET['edit']);
}
?>

<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Categories - Admin - <?php echo htmlspecialchars($company_info['name']); ?></title>
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
                    <li><a href="index.php" class="nav-link">
                        <span>📊</span> Dashboard
                    </a></li>
                    <li><a href="categories.php" class="nav-link active">
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
                <h1>Manage Categories</h1>
                <p>Add, edit, and delete product categories</p>
            </header>
            
            <?php if ($message): ?>
                <div class="alert alert-success"><?php echo htmlspecialchars($message); ?></div>
            <?php endif; ?>
            
            <?php if ($error): ?>
                <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>
            
            <div class="content-section">
                <div class="section-header">
                    <h2><?php echo $editCategory ? 'Edit Category' : 'Add New Category'; ?></h2>
                </div>
                
                <form method="POST" class="admin-form">
                    <input type="hidden" name="action" value="<?php echo $editCategory ? 'edit' : 'add'; ?>">
                    <?php if ($editCategory): ?>
                        <input type="hidden" name="id" value="<?php echo $editCategory['id']; ?>">
                    <?php endif; ?>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="name">Category Name *</label>
                            <input type="text" id="name" name="name" value="<?php echo $editCategory ? htmlspecialchars($editCategory['name']) : ''; ?>" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="icon">Icon (Emoji)</label>
                            <input type="text" id="icon" name="icon" value="<?php echo $editCategory ? htmlspecialchars($editCategory['icon']) : '📁'; ?>" placeholder="📁">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="description">Description *</label>
                        <textarea id="description" name="description" rows="3" required><?php echo $editCategory ? htmlspecialchars($editCategory['description']) : ''; ?></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select id="status" name="status">
                            <option value="active" <?php echo ($editCategory && $editCategory['status'] === 'active') ? 'selected' : ''; ?>>Active</option>
                            <option value="inactive" <?php echo ($editCategory && $editCategory['status'] === 'inactive') ? 'selected' : ''; ?>>Inactive</option>
                        </select>
                    </div>
                    
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">
                            <?php echo $editCategory ? 'Update Category' : 'Add Category'; ?>
                        </button>
                        <?php if ($editCategory): ?>
                            <a href="categories.php" class="btn btn-secondary">Cancel</a>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
            
            <div class="content-section">
                <div class="section-header">
                    <h2>Categories List</h2>
                    <p>Total: <?php echo count($categories); ?> categories</p>
                </div>
                
                <div class="table-responsive">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Icon</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Status</th>
                                <th>Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($categories as $category): ?>
                                <tr>
                                    <td><?php echo $category['id']; ?></td>
                                    <td><span class="category-icon"><?php echo htmlspecialchars($category['icon']); ?></span></td>
                                    <td><strong><?php echo htmlspecialchars($category['name']); ?></strong></td>
                                    <td><?php echo htmlspecialchars(substr($category['description'], 0, 100)) . (strlen($category['description']) > 100 ? '...' : ''); ?></td>
                                    <td>
                                        <span class="status-badge <?php echo $category['status']; ?>">
                                            <?php echo ucfirst($category['status']); ?>
                                        </span>
                                    </td>
                                    <td><?php echo date('M j, Y', strtotime($category['created_at'])); ?></td>
                                    <td>
                                        <div class="action-buttons">
                                            <a href="?edit=<?php echo $category['id']; ?>" class="btn btn-sm btn-edit">
                                                <span>✏️</span> Edit
                                            </a>
                                            <form method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this category?');">
                                                <input type="hidden" name="action" value="delete">
                                                <input type="hidden" name="id" value="<?php echo $category['id']; ?>">
                                                <button type="submit" class="btn btn-sm btn-delete">
                                                    <span>🗑️</span> Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
    
    <script src="admin.js"></script>
</body>
</html>