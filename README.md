# AABT Group Website - PHP Version

A complete PHP replica of the AABT Group website (https://aabtgroup.in) with database-driven content management capabilities.

## 🚀 Features

### ✅ **Completed Features**
- **Multi-page PHP Website**: Complete with routing and dynamic content
- **Database Integration**: MySQL database with all necessary tables
- **Responsive Design**: Mobile-first approach with modern CSS
- **Contact Forms**: Functional contact form with validation
- **Content Management**: Database-driven content for easy updates
- **Professional Styling**: Matching original website design
- **SEO Optimized**: Proper meta tags and semantic HTML
- **Security**: Input validation and prepared statements

### 📁 **File Structure**
```
aabt-group-php/
├── config.php              # Database configuration and helper functions
├── index.php               # Homepage
├── about.php               # About page
├── products.php            # Products page
├── blog.php                # Blog page
├── gallery.php             # Gallery page
├── contact.php             # Contact page with form
├── setup_database.php      # Database setup script
├── styles.css              # Complete styling
├── script.js               # JavaScript functionality
└── README.md               # This file
```

## 🛠️ **Requirements**

### **Server Requirements**
- **PHP 7.4+** (Recommended PHP 8.0+)
- **MySQL 5.7+** or **MariaDB 10.2+**
- **Apache** or **Nginx** web server
- **mod_php** or **PHP-FPM** enabled

### **PHP Extensions Required**
- `pdo_mysql` (for database connectivity)
- `mbstring` (for string handling)
- `json` (for data processing)

## 📋 **Installation Instructions**

### **1. Database Setup**
```bash
# Upload files to your web server
# Access setup_database.php in your browser
# http://yourdomain.com/setup_database.php
```

### **2. Configure Database**
Edit `config.php` with your database credentials:
```php
define('DB_HOST', 'localhost');
define('DB_NAME', 'aabt_group');
define('DB_USER', 'your_db_user');
define('DB_PASS', 'your_db_password');
```

### **3. Set Permissions**
```bash
# Ensure web server can write to necessary files
chmod 755 *.php
chmod 644 styles.css script.js
```

### **4. Access Website**
Visit your domain in the browser:
```
http://yourdomain.com/
```

## 🗄️ **Database Schema**

### **Tables Created**
- `products` - Product catalog with categories
- `blog_posts` - Blog articles and content
- `team_members` - Management team information
- `testimonials` - Customer reviews and testimonials
- `contacts` - Contact form submissions

### **Sample Data**
The setup script automatically inserts sample data including:
- 9 sample products across 3 categories
- 3 blog posts with different categories
- 4 team members with contact information
- 4 customer testimonials
- Complete company information

## 🎨 **Design Features**

### **Responsive Design**
- Mobile-first approach
- Breakpoints for tablet and desktop
- Touch-friendly navigation
- Optimized images and layouts

### **Interactive Elements**
- Mobile hamburger menu
- Smooth scroll animations
- Hover effects on cards and buttons
- Form validation and feedback
- WhatsApp integration

### **Color Scheme**
- Primary Blue: `#0274be`
- Text Gray: `#808285`
- Accent Green: `#25d366` (WhatsApp)
- Professional gradients and shadows

## 📧 **Contact Form Features**

### **Form Validation**
- Required field validation
- Email format verification
- Server-side validation
- Error message display

### **Form Processing**
- Database storage of submissions
- Email notification capability (can be extended)
- Spam protection ready
- Success message feedback

## 🔧 **Customization Guide**

### **Adding New Products**
```sql
INSERT INTO products (name, description, category, price, featured) 
VALUES ('Product Name', 'Description', 'Category', 999.99, FALSE);
```

### **Adding Blog Posts**
```sql
INSERT INTO blog_posts (title, excerpt, content, category) 
VALUES ('Title', 'Excerpt', 'Full content...', 'Category');
```

### **Updating Company Info**
Edit the `$company_info` array in `config.php`:
```php
$company_info = [
    'name' => 'Your Company Name',
    'email' => 'contact@yourcompany.com',
    // ... other fields
];
```

## 🚀 **Advanced Features**

### **Content Management**
- All content stored in database
- Easy updates without code changes
- Status management (active/inactive)
- Timestamp tracking

### **SEO Optimization**
- Semantic HTML5 structure
- Meta tags for all pages
- Proper heading hierarchy
- Clean URLs

### **Security Features**
- Prepared statements for SQL
- Input sanitization
- XSS prevention
- CSRF protection ready

## 📱 **Mobile Features**

### **Responsive Navigation**
- Hamburger menu for mobile
- Touch-friendly buttons
- Optimized spacing
- Smooth transitions

### **Performance**
- Optimized CSS delivery
- Minimal JavaScript
- Fast loading times
- Efficient database queries

## 🔄 **Maintenance**

### **Regular Tasks**
- Database backups
- Content updates
- Security patches
- Performance monitoring

### **Scaling Options**
- Add caching layer
- Implement CDN
- Database optimization
- Load balancing

## 🐛 **Troubleshooting**

### **Common Issues**
1. **Database Connection**: Check credentials in `config.php`
2. **Permissions**: Ensure web server can read files
3. **PHP Errors**: Check error logs for details
4. **Blank Pages**: Enable error reporting in PHP

### **Debug Mode**
Add to top of PHP files for debugging:
```php
ini_set('display_errors', 1);
error_reporting(E_ALL);
```

## 📞 **Support**

### **Documentation**
- Inline comments in code
- Database schema documentation
- Installation guide above
- Function documentation in config.php

### **Getting Help**
1. Check error logs
2. Verify database setup
3. Test with sample data
4. Review server configuration

## 🔄 **Migration from React**

If you're migrating from the React version:
- Database structure is compatible
- All features are preserved
- Added backend functionality
- Enhanced with form processing

## 📄 **License**

This project is for educational/demonstration purposes as a replica of the original AABT Group website.

---

**Original Website**: [https://aabtgroup.in](https://aabtgroup.in)

**PHP Version Benefits**:
- ✅ Server-side processing
- ✅ Database integration
- ✅ Form handling
- ✅ Easy deployment
- ✅ Traditional hosting compatible
- ✅ SEO friendly
- ✅ No build process required