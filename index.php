<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RBS Biologicals</title>
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <link rel="stylesheet" href="styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <meta name="description" content="Manufacturers & Exporters of Aquaculture, Poultry and Veterinary Health Care Products">
    <meta name="keywords" content="aquaculture, poultry, veterinary, health care products, RBS Biologicals">
    <meta name="robots" content="max-image-preview:large">
</head>
<body>
    <div class="app">
        <?php
        require_once 'config.php';
        renderHeader('home');
        ?>
        
        <main class="main-content">
            <!-- Hero Section -->
            <section class="hero">
                <div class="container">
                    <div class="hero-content">
                        <h1 class="hero-title glossy-text-gradient"><?php echo htmlspecialchars($company_info['name']); ?></h1>
                        <p class="hero-subtitle">
                            <?php echo htmlspecialchars($company_info['tagline']); ?>
                        </p>
                        <div class="hero-buttons">
                            <a href="products.php" class="btn btn-primary">Explore Products</a>
                            <a href="contact.php" class="btn btn-secondary">Contact Us</a>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Statistics Section -->
            <section class="statistics">
                <div class="container">
                    <div class="stats-grid">
                        <div class="stat-card">
                            <div class="stat-number"><?php echo $company_info['years_in_business']; ?>+</div>
                            <div class="stat-title">Years</div>
                            <div class="stat-subtitle">Global Presence</div>
                            <div class="stat-description">Serving the aquaculture, poultry and veterinary industries worldwide</div>
                        </div>
                        
                        <div class="stat-card">
                            <div class="stat-number"><?php echo $company_info['export_countries']; ?>+</div>
                            <div class="stat-title">Countries</div>
                            <div class="stat-subtitle">Export Excellence</div>
                            <div class="stat-description">Building stronger connections across continents with quality products</div>
                        </div>
                        
                        <div class="stat-card">
                            <div class="stat-number">ISO</div>
                            <div class="stat-title">Certified</div>
                            <div class="stat-subtitle">Quality Standards</div>
                            <div class="stat-description"><?php echo implode(', ', $company_info['certifications']); ?> certified manufacturing facility</div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Product Categories Section -->
            <section class="product-categories">
                <div class="container">
                    <div class="glossy-section-header">
                        <h2>Our Product Categories</h2>
                        <p>High-quality products conforming to international standards</p>
                    </div>
                    
                <?php
                // Initialize PDO if not already done (though typically this should be in config or a db file)
                if (!isset($pdo)) {
                    try {
                        $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
                        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    } catch (PDOException $e) {
                        // Handle error silently or log
                    }
                }

                // Fetch categories from DB
                $db_categories = [];
                if (isset($pdo)) {
                    try {
                        $stmt = $pdo->prepare("SELECT * FROM categories WHERE status = 'active' ORDER BY id ASC LIMIT 6");
                        $stmt->execute();
                        $db_categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    } catch (PDOException $e) {
                        // fallback
                    }
                }
                
                // If DB fails or empty, maybe fallback to config array? 
                // But user wants DB. Let's assume DB works or show nothing.
                ?>
                
                    <div class="categories-grid">
                        <?php foreach ($db_categories as $category): ?>
                            <div class="category-card glossy-card">
                                <div class="category-icon"><?php echo $category['icon']; ?></div>
                                <div class="category-content">
                                    <h3><?php echo htmlspecialchars($category['name']); ?></h3>
                                    <p><?php echo htmlspecialchars(substr($category['description'], 0, 100)) . '...'; ?></p>
                                    <div class="category-products">
                                        <!-- Products tags placeholder or removed if fetching 1-by-1 is too heavy -->
                                        <span class="product-tag">View All Items</span>
                                    </div>
                                    <a href="products.php?category=<?php echo urlencode($category['name']); ?>" class="category-link">
                                        Explore Products →
                                    </a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    
                    <div class="categories-cta">
                        <a href="products.php" class="btn">View All Products</a>
                    </div>
                </div>
            </section>

            <!-- Management Team Section -->
            <section class="management-team">
                <div class="container">
                    <div class="glossy-section-header">
                        <h2>Our Management Team</h2>
                        <p>Highly trained specialists in aquaculture, poultry farming and veterinary medicine</p>
                    </div>
                    
                    <div class="team-grid">
                        <?php foreach ($team_members as $member): ?>
                            <div class="team-member">
                                <div class="member-image"><?php echo $member['image']; ?></div>
                                <div class="member-info">
                                    <h3><?php echo htmlspecialchars($member['name']); ?></h3>
                                    <p class="member-position"><?php echo htmlspecialchars($member['position']); ?></p>
                                    <p class="member-expertise"><?php echo htmlspecialchars($member['expertise']); ?></p>
                                    <!-- <div class="member-contact">
                                        <a href="mailto:<?php echo htmlspecialchars($member['email']); ?>" class="contact-link">
                                            <span class="contact-icon">📧</span>
                                            <?php echo htmlspecialchars($member['email']); ?>
                                        </a>
                                        <a href="tel:<?php echo htmlspecialchars($member['phone']); ?>" class="contact-link">
                                            <span class="contact-icon">📞</span>
                                            <?php echo htmlspecialchars($member['phone']); ?>
                                        </a>
                                    </div> -->
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </section>

            <!-- Testimonials Section -->
            <section class="testimonials">
                <div class="container">
                    <div class="glossy-section-header">
                        <h2>What Our Clients Say</h2>
                        <p>Building stronger connections across continents with trusted partnerships</p>
                    </div>
                    
                    <div class="testimonials-grid">
                        <?php foreach ($testimonials as $testimonial): ?>
                            <div class="testimonial-card glossy-card">
                                <div class="testimonial-rating">
                                    <?php echo str_repeat('⭐', $testimonial['rating']); ?>
                                </div>
                                <div class="testimonial-content">
                                    <p>"<?php echo htmlspecialchars($testimonial['content']); ?>"</p>
                                </div>
                                <div class="testimonial-author">
                                    <div class="author-info">
                                        <h4><?php echo htmlspecialchars($testimonial['name']); ?></h4>
                                        <p class="author-company"><?php echo htmlspecialchars($testimonial['company']); ?></p>
                                        <p class="author-country">📍 <?php echo htmlspecialchars($testimonial['country']); ?></p>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </section>

            <!-- Blog Section -->
            <section class="blog-section">
                <div class="container">
                    <div class="glossy-section-header">
                        <h2>Latest from Our Blog</h2>
                        <p>Industry insights, best practices, and company updates</p>
                    </div>
                    
                    <div class="blog-categories">
                        <button class="category-btn">All</button>
                        <button class="category-btn">Aquaculture</button>
                        <button class="category-btn">Poultry</button>
                        <button class="category-btn">Veterinary</button>
                        <button class="category-btn">Events</button>
                    </div>
                    
                    <div class="blog-grid">
                        <?php foreach ($blog_posts as $post): ?>
                            <article class="blog-card">
                                <div class="blog-image">
                                    <span class="blog-emoji"><?php echo $post['image']; ?></span>
                                </div>
                                <div class="blog-content">
                                    <div class="blog-meta">
                                        <span class="blog-category glossy-badge glossy-badge-orange"><?php echo htmlspecialchars($post['category']); ?></span>
                                        <span class="blog-date"><?php echo htmlspecialchars($post['date']); ?></span>
                                    </div>
                                    <h3><?php echo htmlspecialchars($post['title']); ?></h3>
                                    <p><?php echo htmlspecialchars($post['excerpt']); ?></p>
                                    <a href="<?php echo htmlspecialchars($post['link']); ?>" class="blog-link">
                                        Read More →
                                    </a>
                                </div>
                            </article>
                        <?php endforeach; ?>
                    </div>
                    
                    <div class="blog-cta">
                        <a href="blog.php" class="btn">View All Blog Posts</a>
                    </div>
                </div>
            </section>

            <!-- Call to Action -->
            <section class="call-to-action">
                <div class="container">
                    <div class="cta-content">
                        <h2>Ready to Experience Quality Products?</h2>
                        <p>Join thousands of satisfied customers worldwide who trust RBS Biologicals for their aquaculture, poultry, and veterinary health care needs.</p>
                        <div class="cta-buttons">
                            <a href="products.php" class="btn btn-primary">Visit Our Products</a>
                            <a href="contact.php" class="btn btn-secondary">Get in Touch</a>
                        </div>
                        <div class="cta-features">
                            <div class="feature">
                                <span class="feature-icon">🌍</span>
                                <span>Global Shipping</span>
                            </div>
                            <div class="feature">
                                <span class="feature-icon">🏆</span>
                                <span>Quality Certified</span>
                            </div>
                            <div class="feature">
                                <span class="feature-icon">📞</span>
                                <span>24/7 Support</span>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>
        
        <?php renderFooter(); ?>
    </div>

    <script src="script.js"></script>
</body>
</html>