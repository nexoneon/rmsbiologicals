<?php
require_once 'config.php';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $subject = trim($_POST['subject'] ?? '');
    $message = trim($_POST['message'] ?? '');
    
    // Validate form data
    $errors = [];
    if (empty($name)) $errors[] = 'Name is required';
    if (empty($email)) $errors[] = 'Email is required';
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Invalid email format';
    if (empty($message)) $errors[] = 'Message is required';
    
    if (empty($errors)) {
        // Database connection logic to ensure $pdo is available
        if (!isset($pdo)) {
            try {
                $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                $errors[] = "Database connection error: " . $e->getMessage();
            }
        }

        if (empty($errors) && isset($pdo)) {
            try {
                // 1. Save to database
                $stmt = $pdo->prepare("INSERT INTO messages (name, email, phone, subject, message) VALUES (?, ?, ?, ?, ?)");
                $stmt->execute([$name, $email, $phone, $subject, $message]);
                
                // 2. Send email notification
                $to = $company_info['email']; // Send to company email
                $email_subject = "New Inquiry: " . ($subject ? $subject : "General Inquiry");
                
                $email_body = "You have received a new message from your website contact form.\n\n";
                $email_body .= "Name: $name\n";
                $email_body .= "Email: $email\n";
                $email_body .= "Phone: $phone\n";
                $email_body .= "Subject: $subject\n\n";
                $email_body .= "Message:\n$message\n";
                
                $headers = "From: noreply@aabtgroup.in\n"; // Ideally use a real domain email
                $headers .= "Reply-To: $email";
                
                // Suppress error if mail server not configured locally
                @mail($to, $email_subject, $email_body, $headers);
                
                // 3. Clear form and show success message (PRG Pattern)
                header("Location: contact.php?success=1");
                exit;
                
            } catch (PDOException $e) {
                $errors[] = "Error saving message: " . $e->getMessage();
            }
        }
    }
}

// Check for success message after redirect
if (isset($_GET['success']) && $_GET['success'] == 1) {
    $success_message = "Thank you! Your message has been sent successfully. We will get back to you shortly.";
}

$page_title = 'Contact Us - ' . $company_info['name'];
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
        <?php renderHeader('contact'); ?>
        
        <main class="main-content">
            <div class="page-header">
                <div class="container">
                    <h1>Contact Us</h1>
                    <p class="page-subtitle">Get in touch with our team for expert guidance and support</p>
                </div>
            </div>
            <div class="container">
                
                <?php if (isset($success_message)): ?>
                    <div class="success-message">
                        <?php echo htmlspecialchars($success_message); ?>
                    </div>
                <?php endif; ?>
                
                <?php if (isset($errors) && !empty($errors)): ?>
                    <div class="error-message">
                        <ul>
                            <?php foreach ($errors as $error): ?>
                                <li><?php echo htmlspecialchars($error); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>
                
                <div class="contact-content">
                    <div class="contact-info-section">
                        <h2>Get in Touch</h2>
                        <p>We're here to help you find the perfect solutions for your aquaculture, poultry, and veterinary needs.</p>
                        
                        <div class="contact-methods">
                            <div class="contact-method">
                                <div class="contact-icon">📧</div>
                                <div class="contact-details">
                                    <h3>Email</h3>
                                    <p><a href="mailto:<?php echo htmlspecialchars($company_info['email']); ?>"><?php echo htmlspecialchars($company_info['email']); ?></a></p>
                                    <p>Get a response within 24 hours</p>
                                </div>
                            </div>
                            
                            <div class="contact-method">
                                <div class="contact-icon">📞</div>
                                <div class="contact-details">
                                    <h3>Phone</h3>
                                    <p><a href="tel:<?php echo htmlspecialchars($company_info['phone']); ?>"><?php echo htmlspecialchars($company_info['phone']); ?></a></p>
                                    <p>Mon-Fri: 9:00 AM - 6:00 PM IST</p>
                                </div>
                            </div>
                            
                            <div class="contact-method">
                                <div class="contact-icon">💬</div>
                                <div class="contact-details">
                                    <h3>WhatsApp</h3>
                                    <p><a href="https://wa.me/919999999999" target="_blank">+91 99999 99999</a></p>
                                    <p>Instant support available</p>
                                </div>
                            </div>
                            
                            <div class="contact-method">
                                <div class="contact-icon">📍</div>
                                <div class="contact-details">
                                    <h3>Office Address</h3>
                                    <p><?php echo htmlspecialchars($company_info['address']); ?></p>
                                    <p>Guntur, Andhra Pradesh, India</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="office-hours glossy-card">
                            <h3>Office Hours</h3>
                            <div class="hours-grid">
                                <div class="hours-item">
                                    <span>Monday - Friday</span>
                                    <span>9:00 AM - 6:00 PM</span>
                                </div>
                                <div class="hours-item">
                                    <span>Saturday</span>
                                    <span>9:00 AM - 2:00 PM</span>
                                </div>
                                <div class="hours-item">
                                    <span>Sunday</span>
                                    <span>Closed</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="contact-form-section">
                        <h2>Send us a Message</h2>
                        <p>Fill out the form below and our team will get back to you shortly.</p>
                        
                        <form class="contact-form glossy-card" method="POST" action="">
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="name">Full Name *</label>
                                    <input type="text" id="name" name="name" required value="<?php echo htmlspecialchars($_POST['name'] ?? ''); ?>">
                                </div>
                                
                                <div class="form-group">
                                    <label for="email">Email Address *</label>
                                    <input type="email" id="email" name="email" required value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>">
                                </div>
                            </div>
                            
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="phone">Phone Number</label>
                                    <input type="tel" id="phone" name="phone" value="<?php echo htmlspecialchars($_POST['phone'] ?? ''); ?>">
                                </div>
                                
                                <div class="form-group">
                                    <label for="subject">Subject</label>
                                    <select id="subject" name="subject">
                                        <option value="">Select a subject</option>
                                        <option value="product-inquiry" <?php echo ($_POST['subject'] ?? '') === 'product-inquiry' ? 'selected' : ''; ?>>Product Inquiry</option>
                                        <option value="technical-support" <?php echo ($_POST['subject'] ?? '') === 'technical-support' ? 'selected' : ''; ?>>Technical Support</option>
                                        <option value="partnership" <?php echo ($_POST['subject'] ?? '') === 'partnership' ? 'selected' : ''; ?>>Partnership Opportunity</option>
                                        <option value="feedback" <?php echo ($_POST['subject'] ?? '') === 'feedback' ? 'selected' : ''; ?>>Feedback</option>
                                        <option value="other" <?php echo ($_POST['subject'] ?? '') === 'other' ? 'selected' : ''; ?>>Other</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="message">Message *</label>
                                <textarea id="message" name="message" rows="6" required><?php echo htmlspecialchars($_POST['message'] ?? ''); ?></textarea>
                            </div>
                            
                            <div class="form-actions">
                                <button type="submit" class="btn btn-primary">Send Message</button>
                                <button type="reset" class="btn btn-primary">Clear Form</button>
                            </div>
                        </form>
                    </div>
                </div>
                

                
                <section class="faq-section">
                    <h2>Frequently Asked Questions</h2>
                    <div class="faq-grid">
                        <div class="faq-item glossy-card">
                            <h3>How can I place an order?</h3>
                            <p>You can place an order by calling us, emailing, or filling out the contact form. Our team will guide you through the process.</p>
                        </div>
                        
                        <div class="faq-item glossy-card">
                            <h3>Do you ship internationally?</h3>
                            <p>Yes, we ship to over 50 countries worldwide. Contact us for shipping rates and delivery times to your location.</p>
                        </div>
                        
                        <div class="faq-item glossy-card">
                            <h3>What payment methods do you accept?</h3>
                            <p>We accept bank transfers, letter of credit, and other secure payment methods. Details will be provided during order processing.</p>
                        </div>
                        
                        <div class="faq-item glossy-card">
                            <h3>How can I get technical support?</h3>
                            <p>Our technical team is available via phone, email, and WhatsApp to provide expert guidance and support.</p>
                        </div>
                    </div>
                </section>
            </div>
        </main>
        
        <?php renderFooter(); ?>
    </div>
    
    <script src="script.js"></script>
    
    
</body>
</html>