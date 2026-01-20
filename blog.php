<?php
require_once 'config.php';
$page_title = 'Blog - ' . $company_info['name'];
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
        <?php renderHeader('blog'); ?>
        
        <main class="main-content">
            <div class="page-header">
                <div class="container">
                    <h1>Our Blog</h1>
                    <p class="page-subtitle">Industry insights, best practices, and company updates</p>
                </div>
            </div>
            <div class="container">
                
                
                <?php
                // Fetch categories from database
                $blog_categories = [];
                $blog_posts = [];
                try {
                    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    
                    // Fetch categories
                    $stmt = $pdo->query("SELECT name FROM categories WHERE status = 'active' ORDER BY name ASC");
                    $blog_categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    
                    // Fetch published blog posts
                    $stmt = $pdo->query("SELECT * FROM blog_posts WHERE status = 'published' ORDER BY created_at DESC");
                    $blog_posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
                } catch (PDOException $e) {
                    // Fallback to empty arrays
                }
                ?>
                
                <div class="blog-categories">
                    <button class="category-btn glossy-badge glossy-badge-blue active" onclick="filterBlogPosts('all')">All</button>
                    <?php foreach ($blog_categories as $cat): ?>
                        <button class="category-btn glossy-badge glossy-badge-blue" onclick="filterBlogPosts('<?php echo htmlspecialchars($cat['name']); ?>')">
                            <?php echo htmlspecialchars($cat['name']); ?>
                        </button>
                    <?php endforeach; ?>
                </div>
                
                <div class="blog-grid-full">
                    <?php foreach ($blog_posts as $post): ?>
                        <article class="blog-card-full glossy-card" data-category="<?php echo strtolower($post['category']); ?>">
                            <div class="blog-image-large">
                                <?php if (!empty($post['image_url'])): ?>
                                    <img src="<?php echo htmlspecialchars($post['image_url']); ?>" alt="<?php echo htmlspecialchars($post['title']); ?>" style="width: 100%; height: 100%; object-fit: cover;">
                                <?php else: ?>
                                    <span class="blog-emoji-large">📝</span>
                                <?php endif; ?>
                            </div>
                            <div class="blog-content-full">
                                <div class="blog-meta">
                                    <span class="blog-category"><?php echo htmlspecialchars($post['category']); ?></span>
                                    <span class="blog-date"><?php echo date('F d, Y', strtotime($post['created_at'])); ?></span>
                                </div>
                                <h2><?php echo htmlspecialchars($post['title']); ?></h2>
                                <p class="blog-excerpt"><?php echo htmlspecialchars($post['excerpt'] ?? substr($post['content'], 0, 150) . '...'); ?></p>
                                <div class="blog-content-text">
                                    <p><?php echo htmlspecialchars($post['content']); ?></p>
                                </div>
                                <div class="blog-actions">
                                    <a href="#" class="blog-link">Read More →</a>
                                    <div class="blog-share">
                                        <button class="share-btn" onclick="sharePost('<?php echo $post['id']; ?>')">Share</button>
                                    </div>
                                </div>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
                
                <section class="blog-newsletter">
                    <div class="newsletter-content">
                        <h2>Stay Updated</h2>
                        <p>Subscribe to our newsletter for the latest industry insights and company updates.</p>
                        <form class="newsletter-form" onsubmit="subscribeNewsletter(event)">
                            <input type="email" placeholder="Enter your email address" required>
                            <button type="submit" class="btn btn-primary">Subscribe</button>
                        </form>
                    </div>
                </section>
                
                <section class="blog-categories-info">
                    <h2>Blog Categories</h2>
                    <div class="category-info-grid">
                        <?php
                        // Fetch full category details for info cards
                        try {
                            if (isset($pdo)) {
                                $stmt = $pdo->query("SELECT name, description, icon FROM categories WHERE status = 'active' ORDER BY name ASC");
                                $category_details = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                
                                foreach ($category_details as $cat):
                        ?>
                            <div class="category-info-card">
                                <h3><?php echo htmlspecialchars($cat['icon'] ?? '📁'); ?> <?php echo htmlspecialchars($cat['name']); ?></h3>
                                <p><?php echo htmlspecialchars($cat['description']); ?></p>
                            </div>
                        <?php
                                endforeach;
                            }
                        } catch (PDOException $e) {
                            // Fallback message
                            echo '<p>No categories available at the moment.</p>';
                        }
                        ?>
                    </div>
                </section>
            </div>
        </main>
        
        <?php renderFooter(); ?>
    </div>
    
    <script src="script.js"></script>
    <script>
        function filterBlogPosts(category) {
            const posts = document.querySelectorAll('.blog-card-full');
            const buttons = document.querySelectorAll('.blog-categories .category-btn');
            
            // Update active button
            buttons.forEach(btn => btn.classList.remove('active'));
            event.target.classList.add('active');
            
            // Filter posts
            posts.forEach(post => {
                if (category === 'all' || post.dataset.category === category.toLowerCase()) {
                    post.style.display = 'block';
                } else {
                    post.style.display = 'none';
                }
            });
        }
        
        function subscribeNewsletter(event) {
            event.preventDefault();
            const email = event.target.querySelector('input[type="email"]').value;
            showNotification('Thank you for subscribing! We\'ll keep you updated.');
            event.target.reset();
        }
        
        function sharePost(postId) {
            showNotification('Share functionality coming soon!');
        }
    </script>
    
    <style>
        .blog-grid-full {
            display: grid;
            gap: 40px;
            margin-bottom: 60px;
        }
        
        .blog-card-full {
            background-color: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0,0,0,0.08);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            display: grid;
            grid-template-columns: 300px 1fr;
        }
        
        .blog-card-full:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        }
        
        .blog-image-large {
            background: linear-gradient(135deg, var(--primary-blue), #025a9e);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px;
        }
        
        .blog-emoji-large {
            font-size: 5em;
            filter: brightness(0) invert(1);
        }
        
        .blog-content-full {
            padding: 40px;
        }
        
        .blog-content-full h2 {
            font-size: 1.8em;
            margin-bottom: 15px;
            color: #333;
        }
        
        .blog-excerpt {
            font-size: 1.1em;
            color: var(--text-gray);
            margin-bottom: 20px;
            line-height: 1.6;
        }
        
        .blog-content-text {
            margin-bottom: 25px;
        }
        
        .blog-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .share-btn {
            background-color: #f8f9fa;
            border: 1px solid var(--border-gray);
            padding: 8px 16px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.2s ease;
        }
        
        .share-btn:hover {
            background-color: var(--primary-blue);
            color: white;
        }
        
        .blog-newsletter {
            background: linear-gradient(135deg, var(--primary-blue), #025a9e);
            color: white;
            padding: 60px 40px;
            border-radius: 15px;
            text-align: center;
            margin-bottom: 60px;
        }
        
        .newsletter-content h2 {
            font-size: 2em;
            margin-bottom: 15px;
        }
        
        .newsletter-form {
            display: flex;
            gap: 15px;
            max-width: 500px;
            margin: 30px auto 0;
        }
        
        .newsletter-form input {
            flex: 1;
            padding: 12px 20px;
            border: none;
            border-radius: 5px;
            font-size: 1em;
        }
        
        .blog-categories-info {
            margin-top: 60px;
        }
        
        .category-info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 30px;
            margin-top: 40px;
        }
        
        .category-info-card {
            background-color: #f8f9fa;
            padding: 30px;
            border-radius: 10px;
            text-align: center;
        }
        
        .category-info-card h3 {
            font-size: 1.3em;
            margin-bottom: 15px;
        }
        
        @media (max-width: 768px) {
            .blog-card-full {
                grid-template-columns: 1fr;
            }
            
            .blog-image-large {
                padding: 30px;
            }
            
            .blog-emoji-large {
                font-size: 3em;
            }
            
            .blog-content-full {
                padding: 30px 20px;
            }
            
            .blog-content-full h2 {
                font-size: 1.5em;
            }
            
            .newsletter-form {
                flex-direction: column;
                gap: 10px;
            }
            
            .category-info-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }
        }
    </style>
</body>
</html>