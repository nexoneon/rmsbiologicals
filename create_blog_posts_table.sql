-- Create blog_posts table
DROP TABLE IF EXISTS `blog_posts`;

CREATE TABLE `blog_posts` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `title` varchar(255) NOT NULL,
    `excerpt` text,
    `content` text NOT NULL,
    `category` varchar(100) NOT NULL,
    `image_url` varchar(255) DEFAULT NULL,
    `author` varchar(100) DEFAULT NULL,
    `status` enum('draft','published') NOT NULL DEFAULT 'draft',
    `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
    `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert sample blog posts
INSERT INTO `blog_posts` (`title`, `excerpt`, `content`, `category`, `image_url`, `author`, `status`) VALUES
('Best Practices in Shrimp Farming', 'Learn about the latest techniques and best practices for successful shrimp farming operations.', 'Shrimp farming requires careful attention to water quality, feeding schedules, and disease prevention. This comprehensive guide covers all essential aspects of modern shrimp aquaculture.', 'Aquaculture', NULL, 'Dr. A. B. Sharma', 'published'),
('Poultry Health Management Guide', 'Comprehensive guide to maintaining optimal health in poultry farms and preventing common diseases.', 'Effective poultry health management involves vaccination programs, biosecurity measures, and proper nutrition. Learn the key strategies for maintaining healthy flocks.', 'Poultry Health Care', NULL, 'Mrs. C. D. Patel', 'published'),
('International Aquaculture Expo 2026', 'Highlights from the recent International Aquaculture Expo and key industry trends to watch.', 'The 2026 International Aquaculture Expo showcased cutting-edge technologies and sustainable practices. Here are the major takeaways from this year\'s event.', 'Events', NULL, 'Mr. E. F. Reddy', 'published');
