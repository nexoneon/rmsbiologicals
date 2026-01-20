<?php
// Database configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'rbsbio');
define('DB_USER', 'root');
define('DB_PASS', '');

// Company information
$company_info = [
    'name' => 'RBS Biologicals',
    'full_name' => 'Advance Aqua Biotechnologies India Private Limited',
    'tagline' => 'Manufacturers & Exporters of Aquaculture, Poultry and Veterinary Health Care Products',
    'address' => 'RBS Biologicals, Guntur, Andhra Pradesh, INDIA',
    'email' => 'info@aabtgroup.in',
    'phone' => '+91 99999 99999',
    'years_in_business' => 24,
    'export_countries' => 50,
    'certifications' => ['ISO 9001:2015', 'GMP', 'IEC'],
    'awards' => ['Government of India Excellence in Export Award 2023', 'Government of India Excellence in Export Award 2021']
];

// Product categories
$product_categories = [
    [
        'id' => 'aquaculture',
        'name' => 'Aquaculture Products',
        'description' => 'Comprehensive range of prawn, shrimp, crab, and fish health care products',
        'icon' => '🦐',
        'featured_products' => [
            ['id' => 1, 'name' => 'HERBEX', 'description' => 'Herbal growth promoter for shrimp and fish'],
            ['id' => 2, 'name' => 'NUTRIZYME', 'description' => 'Enzyme supplement for better digestion'],
            ['id' => 3, 'name' => 'PARACURE', 'description' => 'Anti-parasitic treatment'],
            ['id' => 4, 'name' => 'GUT CLEAN', 'description' => 'Gut health optimizer']
        ]
    ],
    [
        'id' => 'poultry',
        'name' => 'Poultry Health Care',
        'description' => 'Specialized products for broilers, turkeys, and feed supplements',
        'icon' => '🐔',
        'featured_products' => [
            ['id' => 5, 'name' => 'Vitamin Premix A+', 'description' => 'Complete vitamin supplement'],
            ['id' => 6, 'name' => 'Mineral Boost', 'description' => 'Essential minerals blend'],
            ['id' => 7, 'name' => 'Poultry Pro', 'description' => 'Growth promoter']
        ]
    ],
    [
        'id' => 'veterinary',
        'name' => 'Veterinary Products',
        'description' => 'Health care solutions for cows, sheep, horses and other livestock',
        'icon' => '🐄',
        'featured_products' => [
            ['id' => 8, 'name' => 'VetCare Plus', 'description' => 'General health supplement'],
            ['id' => 9, 'name' => 'Livestorm', 'description' => 'Liver support formula']
        ]
    ]
];

// Categories
$categories = [
    [
        'id' => 1,
        'name' => 'Aquaculture',
        'description' => 'Comprehensive range of prawn, shrimp, crab, and fish health care products',
        'icon' => '🦐',
        'product_count' => 15
    ],
    [
        'id' => 2,
        'name' => 'Poultry Health Care',
        'description' => 'Specialized products for broilers, turkeys, and feed supplements',
        'icon' => '🐔',
        'product_count' => 12
    ],
    [
        'id' => 3,
        'name' => 'Veterinary Products',
        'description' => 'Health care solutions for cows, sheep, horses and other livestock',
        'icon' => '🐄',
        'product_count' => 8
    ],
    [
        'id' => 4,
        'name' => 'Feed Supplements',
        'description' => 'Nutritional supplements for optimal growth and health',
        'icon' => '🌾',
        'product_count' => 10
    ],
    [
        'id' => 5,
        'name' => 'Water Treatment',
        'description' => 'Products for water quality management and treatment',
        'icon' => '💧',
        'product_count' => 6
    ],
    [
        'id' => 6,
        'name' => 'Disinfectants',
        'description' => 'Sanitation and hygiene products for farm and facility',
        'icon' => '🧴',
        'product_count' => 5
    ]
];

// Team members
$team_members = [
    [
        'id' => 1,
        'name' => 'Dr. A. B. Sharma',
        'position' => 'Managing Director',
        'expertise' => 'Aquaculture Specialist',
        'email' => 'md@aabtgroup.in',
        'phone' => '+91 99999 99991',
        'image' => '👨‍💼'
    ],
    [
        'id' => 2,
        'name' => 'Mrs. C. D. Patel',
        'position' => 'Director - Operations',
        'expertise' => 'Poultry Health Care',
        'email' => 'director@aabtgroup.in',
        'phone' => '+91 99999 99992',
        'image' => '👩‍💼'
    ],
    [
        'id' => 3,
        'name' => 'Mr. E. F. Reddy',
        'position' => 'Director - Exports',
        'expertise' => 'International Business',
        'email' => 'exports@aabtgroup.in',
        'phone' => '+91 99999 99993',
        'image' => '👨‍💼'
    ],
    [
        'id' => 4,
        'name' => 'Dr. G. H. Kumar',
        'position' => 'Technical Director',
        'expertise' => 'Veterinary Medicine',
        'email' => 'technical@aabtgroup.in',
        'phone' => '+91 99999 99994',
        'image' => '👨‍⚕️'
    ]
];

// Testimonials
$testimonials = [
    [
        'id' => 1,
        'name' => 'Mr. John Smith',
        'company' => 'Aquaculture International Ltd.',
        'country' => 'United Kingdom',
        'content' => 'RBS Biologicals has been our trusted partner for over 10 years. Their aquaculture products are exceptional and their customer service is outstanding. Highly recommended!',
        'rating' => 5
    ],
    [
        'id' => 2,
        'name' => 'Dr. Maria Rodriguez',
        'company' => 'Poultry Health Solutions',
        'country' => 'Spain',
        'content' => 'The quality and consistency of RBS Biologicals\' poultry health care products have significantly improved our production. Their technical support is invaluable.',
        'rating' => 5
    ],
    [
        'id' => 3,
        'name' => 'Mr. Ahmed Hassan',
        'company' => 'Global Veterinary Supplies',
        'country' => 'UAE',
        'content' => 'We import RBS Biologicals products across the Middle East. Their commitment to quality and international standards makes them our preferred supplier.',
        'rating' => 5
    ],
    [
        'id' => 4,
        'name' => 'Dr. Li Wei',
        'company' => 'Asia Pacific Aquaculture',
        'country' => 'Singapore',
        'content' => 'RBS Biologicals\' innovative products and reliable delivery have helped us grow our business. Their expertise in aquaculture is unmatched.',
        'rating' => 5
    ]
];

// Blog posts
$blog_posts = [
    [
        'id' => 1,
        'title' => 'Best Practices in Shrimp Farming',
        'excerpt' => 'Learn about the latest techniques and best practices for successful shrimp farming operations.',
        'category' => 'Aquaculture',
        'date' => 'January 15, 2026',
        'image' => '🦐',
        'content' => 'Full blog post content about shrimp farming best practices...',
        'link' => '/blog/shrimp-farming-practices'
    ],
    [
        'id' => 2,
        'title' => 'Poultry Health Management Guide',
        'excerpt' => 'Comprehensive guide to maintaining optimal health in poultry farms and preventing common diseases.',
        'category' => 'Poultry',
        'date' => 'January 10, 2026',
        'image' => '🐔',
        'content' => 'Full blog post content about poultry health management...',
        'link' => '/blog/poultry-health-management'
    ],
    [
        'id' => 3,
        'title' => 'International Aquaculture Expo 2026',
        'excerpt' => 'Highlights from the recent International Aquaculture Expo and key industry trends to watch.',
        'category' => 'Events',
        'date' => 'January 5, 2026',
        'image' => '🌍',
        'content' => 'Full blog post content about the aquaculture expo...',
        'link' => '/blog/aquaculture-expo-2026'
    ]
];

// Helper functions
function renderHeader($current_page = 'home') {
    global $company_info;
    ?>
    <header class="header">
        <div class="top-bar">
            <div class="container">
                <p class="registration-address"><?php echo htmlspecialchars($company_info['address']); ?></p>
            </div>
        </div>
        
        <nav class="main-nav">
            <div class="container">
                <div class="nav-content">
                    <a href="index.php" class="logo">
                        <img src="images/logo.PNG" alt="RBS Biologicals Logo" class="logo-img">
                        <h1><?php echo htmlspecialchars($company_info['name']); ?></h1>
                    </a>
                    
                    <button class="mobile-menu-toggle" onclick="toggleMobileMenu()" aria-label="Toggle mobile menu">
                        <span></span>
                        <span></span>
                        <span></span>
                    </button>
                    
                    <ul class="nav-menu" id="navMenu">
                        <li><a href="index.php" class="<?php echo $current_page === 'home' ? 'active' : ''; ?>">HOME</a></li>
                        <li><a href="about.php" class="<?php echo $current_page === 'about' ? 'active' : ''; ?>">ABOUT US</a></li>
                        <!-- <li><a href="categories.php" class="<?php echo $current_page === 'categories' ? 'active' : ''; ?>">CATEGORIES</a></li> -->
                        <li><a href="products.php" class="<?php echo $current_page === 'products' ? 'active' : ''; ?>">PRODUCTS</a></li>
                        <li><a href="blog.php" class="<?php echo $current_page === 'blog' ? 'active' : ''; ?>">BLOG</a></li>
                        <li><a href="gallery.php" class="<?php echo $current_page === 'gallery' ? 'active' : ''; ?>">GALLERY</a></li>
                        <li><a href="contact.php" class="<?php echo $current_page === 'contact' ? 'active' : ''; ?>">CONTACT</a></li>
                        
                        <!-- <li class="nav-actions">
                            <a href="mailto:<?php echo htmlspecialchars($company_info['email']); ?>" class="mail-btn">MAIL US</a>
                            <a href="https://wa.me/919999999999" target="_blank" rel="noopener noreferrer" class="whatsapp-btn">
                                <span class="whatsapp-icon">💬</span>
                            </a>
                        </li> -->
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <?php
}

function renderFooter() {
    global $company_info;
    ?>
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3>Product Categories</h3>
                    <ul class="footer-links">
                        <?php
                        // Access global PDO connection
                        global $pdo;
                        $footer_categories = [];
                        
                        // Ensure connection exists
                        $db_conn = $pdo;
                        if (!isset($db_conn)) {
                            try {
                                $db_conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
                                $db_conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                            } catch (PDOException $e) {
                                // Fallback silently
                            }
                        }
                        
                        if (isset($db_conn)) {
                            try {
                                $stmt = $db_conn->prepare("SELECT name FROM categories WHERE status = 'active' ORDER BY name ASC LIMIT 6");
                                $stmt->execute();
                                $footer_categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
                            } catch (PDOException $e) { /* ignore */ }
                        }
                        
                        // Display Dynamic Categories
                        if (!empty($footer_categories)) {
                            foreach ($footer_categories as $cat) {
                                echo '<li><a href="products.php?category=' . urlencode($cat['name']) . '">' . htmlspecialchars($cat['name']) . '</a></li>';
                            }
                        } else {
                            // Fallback if DB empty/fails
                            echo '<li><a href="products.php">All Products</a></li>';
                        }
                        ?>
                    </ul>
                </div>
                
                <div class="footer-section">
                    <h3>Quick Links</h3>
                    <ul class="footer-links">
                        <li><a href="about.php">About Us</a></li>
                        <li><a href="products.php">Products</a></li>
                        <li><a href="blog.php">Blog</a></li>
                        <li><a href="gallery.php">Gallery</a></li>
                        <li><a href="contact.php">Contact</a></li>
                    </ul>
                </div>
                
                <div class="footer-section">
                    <h3>Recent Posts</h3>
                    <ul class="footer-links">
                        <li><a href="blog.php#aquaculture">Aquaculture Best Practices</a></li>
                        <li><a href="blog.php#poultry">Poultry Health Management</a></li>
                        <li><a href="blog.php#events">Industry Events & Updates</a></li>
                    </ul>
                </div>
                
                <div class="footer-section">
                    <h3>Contact Information</h3>
                    <div class="contact-info">
                        <p><strong>RBS Biologicals</strong></p>
                        <p>Guntur, Andhra Pradesh</p>
                        <p>INDIA - 520001</p>
                        <p class="contact-item">
                            <a href="mailto:<?php echo htmlspecialchars($company_info['email']); ?>"><?php echo htmlspecialchars($company_info['email']); ?></a>
                        </p>
                        <p class="contact-item">
                            <a href="tel:<?php echo htmlspecialchars($company_info['phone']); ?>"><?php echo htmlspecialchars($company_info['phone']); ?></a>
                        </p>
                        <div class="social-links">
                            <a href="https://wa.me/919999999999" target="_blank" rel="noopener noreferrer" class="social-link whatsapp">
                                <span>💬</span>
                            </a>
                            <a href="#" class="social-link facebook">
                                <span>f</span>
                            </a>
                            <a href="#" class="social-link linkedin">
                                <span>in</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="footer-bottom">
                <div class="copyright">
                    <p>&copy; 2026 <?php echo htmlspecialchars($company_info['name']); ?>. All rights reserved.</p>
                </div>
                <div class="credits">
                    <p>Powered By <?php echo htmlspecialchars($company_info['name']); ?></p>
                </div>
            </div>
        </div>
    </footer>
    <?php
}
?>