<?php
require_once 'config.php';
$page_title = 'Gallery - ' . $company_info['name'];

// Database connection and data fetching
try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Fetch all gallery items
    $stmt = $pdo->query("SELECT * FROM gallery ORDER BY created_at DESC");
    $db_gallery_items = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $db_gallery_items = [];
    // Log error or handle gracefully
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
        <?php renderHeader('gallery'); ?>
        
        <main class="main-content">
            <div class="page-header">
                <div class="container">
                    <h1>Gallery</h1>
                    <p class="page-subtitle">Explore our products, facilities, and company milestones</p>
                </div>
            </div>
            <div class="container">
                
                <div class="gallery-categories">
                    <button class="gallery-category-btn glossy-badge glossy-badge-blue active" onclick="filterGallery(event, 'all')">All</button>
                    <button class="gallery-category-btn glossy-badge glossy-badge-blue" onclick="filterGallery(event, 'products')">Products</button>
                    <button class="gallery-category-btn glossy-badge glossy-badge-blue" onclick="filterGallery(event, 'facility')">Facility</button>
                    <button class="gallery-category-btn glossy-badge glossy-badge-blue" onclick="filterGallery(event, 'events')">Events</button>
                    <button class="gallery-category-btn glossy-badge glossy-badge-blue" onclick="filterGallery(event, 'team')">Team</button>
                </div>
                
                <div id="no-records-msg" class="no-records-message" style="display: none;">
                    No records found for this category.
                </div>

                <div class="gallery-grid">
                    <?php if (empty($db_gallery_items)): ?>
                        <!-- No items in DB yet -->
                    <?php else: ?>
                        <?php foreach ($db_gallery_items as $item): ?>
                            <div class="gallery-item" data-category="<?php echo htmlspecialchars($item['type']); ?>">
                                <div class="gallery-image">
                                    <?php if (!empty($item['image_url'])): ?>
                                        <img src="uploads/<?php echo htmlspecialchars($item['image_url']); ?>" alt="<?php echo htmlspecialchars($item['title']); ?>" style="width: 100%; height: 100%; object-fit: cover;">
                                    <?php else: ?>
                                        <span class="gallery-emoji">🖼️</span>
                                    <?php endif; ?>
                                </div>
                                <div class="gallery-overlay">
                                    <h3><?php echo htmlspecialchars($item['title'] ?: 'Untitled'); ?></h3>
                                    <span class="gallery-tag"><?php echo ucfirst(htmlspecialchars($item['type'])); ?></span>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                
                <section class="gallery-stats">
                    <h2>Our Gallery by Numbers</h2>
                    <div class="stats-grid">
                        <div class="stat-card glossy-card">
                            <div class="stat-number"><?php echo count(array_filter($db_gallery_items, fn($i) => $i['type'] == 'products')); ?>+</div>
                            <div class="stat-title">Product Images</div>
                            <div class="stat-description">Complete product portfolio</div>
                        </div>
                        
                        <div class="stat-card glossy-card">
                            <div class="stat-number"><?php echo count(array_filter($db_gallery_items, fn($i) => $i['type'] == 'facility')); ?>+</div>
                            <div class="stat-title">Facility Photos</div>
                            <div class="stat-description">State-of-the-art manufacturing</div>
                        </div>
                        
                        <div class="stat-card glossy-card">
                            <div class="stat-number"><?php echo count(array_filter($db_gallery_items, fn($i) => $i['type'] == 'events')); ?>+</div>
                            <div class="stat-title">Event Coverage</div>
                            <div class="stat-description">Industry events and exhibitions</div>
                        </div>
                        
                        <div class="stat-card glossy-card">
                            <div class="stat-number"><?php echo count(array_filter($db_gallery_items, fn($i) => $i['type'] == 'team')); ?>+</div>
                            <div class="stat-title">Team Moments</div>
                            <div class="stat-description">Our dedicated team members</div>
                        </div>
                    </div>
                </section>
                
                <section class="gallery-cta">
                    <div class="cta-content">
                        <h2>Want to See More?</h2>
                        <p>Visit our manufacturing facility or schedule a product demonstration. We'd love to show you our operations in person.</p>
                        <div class="cta-buttons">
                            <a href="contact.php" class="btn btn-primary">Schedule a Visit</a>
                            <a href="products.php" class="btn btn-secondary">Browse Products</a>
                        </div>
                    </div>
                </section>
            </div>
        </main>
        
        <?php renderFooter(); ?>
    </div>
    
    <script src="script.js"></script>
    <script>
        function filterGallery(event, category) {
            const items = document.querySelectorAll('.gallery-item');
            const buttons = document.querySelectorAll('.gallery-category-btn');
            const noRecordsMsg = document.getElementById('no-records-msg');
            let visibleCount = 0;
            
            // Update active button
            buttons.forEach(btn => btn.classList.remove('active'));
            event.target.classList.add('active');
            
            // Filter items
            items.forEach(item => {
                if (category === 'all' || item.dataset.category === category) {
                    item.style.display = 'block';
                    // Trigger reflow only if needed, for animation reset if we had one
                    visibleCount++;
                } else {
                    item.style.display = 'none';
                }
            });
            
            // Handle "No records" message
            if (visibleCount === 0) {
                noRecordsMsg.style.display = 'block';
                if (category === 'all') {
                     noRecordsMsg.innerHTML = 'No records found in the gallery.';
                } else {
                     noRecordsMsg.innerHTML = 'No records found for <strong>' + category.charAt(0).toUpperCase() + category.slice(1) + '</strong>.';
                }
            } else {
                noRecordsMsg.style.display = 'none';
            }
        }
        
        // Initial check in case DB is empty
        window.onload = function() {
            const items = document.querySelectorAll('.gallery-item');
            const noRecordsMsg = document.getElementById('no-records-msg');
            if (items.length === 0) {
                noRecordsMsg.style.display = 'block';
                noRecordsMsg.innerHTML = 'No records found in the gallery.';
            }
        };
    </script>
    
    <style>
        .gallery-categories {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-bottom: 40px;
            flex-wrap: wrap;
        }
        
        .gallery-category-btn {
            background-color: white;
            color: #4a5568;
            border: 2px solid #e2e8f0;
            padding: 10px 25px;
            border-radius: 25px;
            cursor: pointer;
            font-size: 15px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .gallery-category-btn:hover,
        .gallery-category-btn.active {
            background-color: #667eea;
            color: white;
            border-color: #667eea;
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
            transform: translateY(-2px);
        }
        
        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 30px;
            margin-bottom: 60px;
            min-height: 200px; /* Prevent layout collapse */
        }
        
        .gallery-item {
            position: relative;
            background-color: #fff;
            border-radius: 20px;
            overflow: hidden;
            aspect-ratio: 1;
            cursor: pointer;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        }
        
        .gallery-item:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.15);
        }
        
        .gallery-image {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f7fafc;
        }
        
        .gallery-image img {
            transition: transform 0.5s ease;
        }
        
        .gallery-item:hover .gallery-image img {
            transform: scale(1.1);
        }
        
        .gallery-emoji {
            font-size: 4em;
            opacity: 0.5;
        }
        
        .gallery-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(to top, rgba(0,0,0,0.9) 0%, rgba(0,0,0,0.5) 60%, transparent 100%);
            color: white;
            padding: 40px 25px 25px;
            transform: translateY(100%);
            transition: transform 0.3s ease;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
        }
        
        .gallery-item:hover .gallery-overlay {
            transform: translateY(0);
        }
        
        .gallery-overlay h3 {
            font-size: 1.25em;
            margin: 0 0 5px 0;
            font-weight: 600;
        }
        
        .gallery-tag {
            font-size: 0.85em;
            opacity: 0.9;
            text-transform: uppercase;
            letter-spacing: 1px;
            background: rgba(255,255,255,0.2);
            padding: 4px 12px;
            border-radius: 12px;
            align-self: flex-start;
            backdrop-filter: blur(4px);
        }
        
        .no-records-message {
            text-align: center;
            padding: 50px 20px;
            font-size: 1.2em;
            color: #718096;
            background: #f7fafc;
            border-radius: 12px;
            margin-bottom: 60px;
            border: 2px dashed #e2e8f0;
        }
        
        .gallery-stats {
            margin-bottom: 60px;
        }
        
        .gallery-cta {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 60px 40px;
            border-radius: 30px;
            text-align: center;
        }
        
        .gallery-cta h2 {
            font-size: 2em;
            margin-bottom: 15px;
        }
        
        .gallery-cta p {
            font-size: 1.1em;
            margin-bottom: 30px;
            opacity: 0.95;
        }
        
        @media (max-width: 768px) {
            .gallery-grid {
                grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
                gap: 15px;
            }
            .gallery-overlay {
                padding: 15px;
            }
            .gallery-overlay h3 {
                font-size: 1em;
            }
        }
    </style>
</body>
</html>