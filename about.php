<?php
require_once 'config.php';
$page_title = 'About Us - ' . $company_info['name'];
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
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,600;0,700;1,600&display=swap" rel="stylesheet">
    
</head>
<body>
    <div class="app">
        <?php renderHeader('about'); ?>
        
        <div class="page-header">
            <div class="container">
                <span class="glossy-badge glossy-badge-orange mb-3 d-inline-block">SINCE 2002</span>
                <h1>About Us</h1>
                <p class="page-subtitle" style="font-size: 1.4em; max-width: 900px; margin-left: auto; margin-right: auto;">
                    At RBS Biologicals, we empower aquaculture farmers with <strong>science-backed, biological solutions</strong> for healthy aquatic environments.
                </p>
            </div>
        </div>

        <main class="main-content">
            <div class="container">
                <!-- Innovation Card -->
                <div class="glossy-card mb-4">
                    <span class="innovation-quote" style="display: block; font-size: 60px; color: var(--primary-blue); opacity: 0.2;">“</span>
                    <p class="innovation-text" style="font-size: 1.2em; text-align: center; color: var(--text-dark);">
                        We understand the complex challenges of modern aquaculture—from maintaining pristine water quality to ensuring optimal nutrition for fast, sustained growth. Our focus is on <strong>bridging the gap between traditional farming and advanced bio-technology</strong>.
                    </p>
                </div>

                <!-- Vision Section -->
                <div class="glossy-card mb-4" style="text-align: center; background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);">
                    <div class="vision-icon" style="font-size: 3em; margin-bottom: 20px;">👁️</div>
                    <h2 style="color: var(--primary-blue); margin-bottom: 20px;">Our Vision</h2>
                    <p class="innovation-text" style="max-width: 800px; margin: 0 auto; color: var(--text-gray);">
                        To be the most trusted partner in sustainable aquaculture, delivering innovative products that reduce environmental stress, enhance aquatic animal welfare, and ultimately secure a more profitable future for our customers.
                    </p>
                </div>

                <!-- Difference Section -->
                <div class="glossy-section-header">
                    <h2>The RBS Biologicals Difference</h2>
                </div>

                <div class="difference-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 30px; margin-bottom: 60px;">
                    <div class="glossy-card">
                        <div class="diff-icon-wrapper" style="font-size: 2.5em; margin-bottom: 20px; color: var(--primary-blue);">🔬</div>
                        <h3 style="color: var(--primary-blue); margin-bottom: 15px;">Science-First Approach</h3>
                        <p style="color: var(--text-gray);">
                            Our product portfolio—including specialized Probiotics, high-grade Zeolite, and Essential EC Minerals is developed through rigorous research and testing to deliver measurable results in pond health and animal performance.
                        </p>
                    </div>

                    <div class="glossy-card">
                        <div class="diff-icon-wrapper" style="font-size: 2.5em; margin-bottom: 20px; color: var(--primary-blue);">🔄</div>
                        <h3 style="color: var(--primary-blue); margin-bottom: 15px;">Complete Care</h3>
                        <p style="color: var(--text-gray);">
                            We provide comprehensive solutions that address the entire farming cycle, from initial pond preparation and critical water parameter management to advanced growth support through our Vitamin C Supplements and Protein Gels.
                        </p>
                    </div>

                    <div class="glossy-card">
                        <div class="diff-icon-wrapper" style="font-size: 2.5em; margin-bottom: 20px; color: var(--primary-blue);">🛡️</div>
                        <h3 style="color: var(--primary-blue); margin-bottom: 15px;">Quality You Can Trust</h3>
                        <p style="color: var(--text-gray);">
                            Every RBS Biologicals product is manufactured to the highest industry standards, ensuring purity, potency, and consistent effectiveness for your valuable stock.
                        </p>
                    </div>
                </div>

                <!-- Closing Banner -->
                <div class="glossy-card" style="margin-top: 60px; background: var(--gradient-mixed); text-align: center; color: white;">
                    <p class="closing-text" style="font-size: 1.5em; font-weight: 500;">
                        We are more than a supplier; we are your partner in biological balance and aqua-farming success.
                    </p>
                </div>
            </div>
            </div>
        </main>
        
        <?php renderFooter(); ?>
    </div>
    
    <script src="script.js"></script>
</body>
</html>