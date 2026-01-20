-- AABT Group Database Setup Script
-- Run this script in phpMyAdmin or MySQL command line

-- Create database if it doesn't exist
CREATE DATABASE IF NOT EXISTS `rbsbio` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Use the database
USE `rbsbio`;

-- Create products table
CREATE TABLE IF NOT EXISTS `products` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `name` varchar(255) NOT NULL,
    `description` text DEFAULT NULL,
    `composition` text DEFAULT NULL,
    `benefits` text DEFAULT NULL,
    `dosage` varchar(255) DEFAULT NULL,
    `available_sizes` varchar(255) DEFAULT NULL,
    `category` varchar(100) DEFAULT NULL,
    `price` decimal(10,2) DEFAULT 0.00,
    `image_url` varchar(255) DEFAULT NULL,
    `featured` tinyint(1) DEFAULT 0,
    `status` enum('active','inactive') DEFAULT 'active',
    `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
    `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Create blog_posts table
CREATE TABLE IF NOT EXISTS `blog_posts` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `title` varchar(255) NOT NULL,
    `excerpt` text DEFAULT NULL,
    `content` longtext DEFAULT NULL,
    `category` varchar(100) DEFAULT NULL,
    `image_url` varchar(255) DEFAULT NULL,
    `status` enum('published','draft') DEFAULT 'published',
    `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
    `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Create team_members table
CREATE TABLE IF NOT EXISTS `team_members` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `name` varchar(255) NOT NULL,
    `position` varchar(255) DEFAULT NULL,
    `expertise` varchar(255) DEFAULT NULL,
    `email` varchar(255) DEFAULT NULL,
    `phone` varchar(50) DEFAULT NULL,
    `image_url` varchar(255) DEFAULT NULL,
    `status` enum('active','inactive') DEFAULT 'active',
    `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
    `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Create testimonials table
CREATE TABLE IF NOT EXISTS `testimonials` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `name` varchar(255) NOT NULL,
    `company` varchar(255) DEFAULT NULL,
    `country` varchar(100) DEFAULT NULL,
    `content` text NOT NULL,
    `rating` int(11) DEFAULT 5,
    `status` enum('active','inactive') DEFAULT 'active',
    `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
    `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Create contacts table
CREATE TABLE IF NOT EXISTS `contacts` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `name` varchar(255) NOT NULL,
    `email` varchar(255) NOT NULL,
    `phone` varchar(50) DEFAULT NULL,
    `subject` varchar(255) DEFAULT NULL,
    `message` text DEFAULT NULL,
    `status` enum('new','read','replied') DEFAULT 'new',
    `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert sample data (only if tables are empty)
-- Sample products
INSERT IGNORE INTO `products` (`id`, `name`, `description`, `category`, `price`, `image_url`, `featured`, `status`) VALUES
(1, 'HERBEX', 'Herbal growth promoter for shrimp and fish', 'aquaculture', 1250.00, 'shrimp.jpg', 1, 'active'),
(2, 'NUTRIZYME', 'Enzyme supplement for better digestion', 'aquaculture', 980.00, 'pill.jpg', 1, 'active'),
(3, 'PARACURE', 'Anti-parasitic treatment', 'aquaculture', 1450.00, 'lab.jpg', 1, 'active'),
(4, 'GUT CLEAN', 'Gut health optimizer', 'aquaculture', 1100.00, 'herb.jpg', 1, 'active'),
(5, 'Vitamin Premix A+', 'Complete vitamin supplement', 'poultry', 750.00, 'vitamin.jpg', 1, 'active'),
(6, 'Mineral Boost', 'Essential minerals blend', 'poultry', 680.00, 'mineral.jpg', 1, 'active'),
(7, 'Poultry Pro', 'Growth promoter', 'poultry', 890.00, 'chicken.jpg', 1, 'active'),
(8, 'VetCare Plus', 'General health supplement', 'veterinary', 1200.00, 'cattle.jpg', 1, 'active'),
(9, 'Livestorm', 'Liver support formula', 'veterinary', 1350.00, 'medical.jpg', 1, 'active');

-- Sample blog posts
INSERT IGNORE INTO `blog_posts` (`id`, `title`, `excerpt`, `content`, `category`, `image_url`, `status`) VALUES
(1, 'Best Practices in Shrimp Farming', 'Learn about the latest techniques and best practices for successful shrimp farming operations.', 'Full blog post content about shrimp farming best practices...', 'Aquaculture', 'blog-shrimp.jpg', 'published'),
(2, 'Poultry Health Management Guide', 'Comprehensive guide to maintaining optimal health in poultry farms and preventing common diseases.', 'Full blog post content about poultry health management...', 'Poultry', 'blog-poultry.jpg', 'published'),
(3, 'International Aquaculture Expo 2026', 'Highlights from the recent International Aquaculture Expo and key industry trends to watch.', 'Full blog post content about the aquaculture expo...', 'Events', 'blog-expo.jpg', 'published');

-- Sample team members
INSERT IGNORE INTO `team_members` (`id`, `name`, `position`, `expertise`, `email`, `phone`, `image_url`, `status`) VALUES
(1, 'Dr. A. B. Sharma', 'Managing Director', 'Aquaculture Specialist', 'md@aabtgroup.in', '+91 99999 99991', 'team-member-1.jpg', 'active'),
(2, 'Mrs. C. D. Patel', 'Director - Operations', 'Poultry Health Care', 'director@aabtgroup.in', '+91 99999 99992', 'team-member-2.jpg', 'active'),
(3, 'Mr. E. F. Reddy', 'Director - Exports', 'International Business', 'exports@aabtgroup.in', '+91 99999 99993', 'team-member-3.jpg', 'active'),
(4, 'Dr. G. H. Kumar', 'Technical Director', 'Veterinary Medicine', 'technical@aabtgroup.in', '+91 99999 99994', 'team-member-4.jpg', 'active');

-- Sample testimonials
INSERT IGNORE INTO `testimonials` (`id`, `name`, `company`, `country`, `content`, `rating`, `status`) VALUES
(1, 'Mr. John Smith', 'Aquaculture International Ltd.', 'United Kingdom', 'AABT Group has been our trusted partner for over 10 years. Their aquaculture products are exceptional and their customer service is outstanding. Highly recommended!', 5, 'active'),
(2, 'Dr. Maria Rodriguez', 'Poultry Health Solutions', 'Spain', 'The quality and consistency of AABT\'s poultry health care products have significantly improved our production. Their technical support is invaluable.', 5, 'active'),
(3, 'Mr. Ahmed Hassan', 'Global Veterinary Supplies', 'UAE', 'We import AABT products across the Middle East. Their commitment to quality and international standards makes them our preferred supplier.', 5, 'active'),
(4, 'Dr. Li Wei', 'Asia Pacific Aquaculture', 'Singapore', 'AABT Group\'s innovative products and reliable delivery have helped us grow our business. Their expertise in aquaculture is unmatched.', 5, 'active');

-- Create categories table
CREATE TABLE IF NOT EXISTS `categories` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `name` varchar(100) NOT NULL,
    `description` text DEFAULT NULL,
    `icon` varchar(50) DEFAULT NULL,
    `image_url` varchar(255) DEFAULT NULL,
    `status` enum('active','inactive') DEFAULT 'active',
    `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
    `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert sample categories
INSERT IGNORE INTO `categories` (`id`, `name`, `description`, `icon`, `image_url`, `status`) VALUES
(1, 'Aquaculture', 'Comprehensive range of prawn, shrimp, crab, and fish health care products', 'icon-shrimp', 'aquaculture.jpg', 'active'),
(2, 'Poultry Health Care', 'Specialized products for broilers, turkeys, and feed supplements', 'icon-chicken', 'poultry.jpg', 'active'),
(3, 'Veterinary Products', 'Health care solutions for cows, sheep, horses and other livestock', 'icon-cattle', 'veterinary.jpg', 'active'),
(4, 'Feed Supplements', 'Nutritional supplements for optimal growth and health', 'icon-grain', 'feed.jpg', 'active'),
(5, 'Water Treatment', 'Products for water quality management and treatment', 'icon-water', 'water.jpg', 'active'),
(6, 'Disinfectants', 'Sanitation and hygiene products for farm and facility', 'icon-bottle', 'disinfectant.jpg', 'active');

-- Display completion message
SELECT 'Database setup completed successfully!' as message;