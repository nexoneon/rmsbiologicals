-- Drop table structure for gallery
DROP TABLE IF EXISTS `gallery`;

-- Create gallery table
CREATE TABLE `gallery` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `title` varchar(255) DEFAULT NULL,
    `type` enum('products','facility','events','team') NOT NULL,
    `image_url` varchar(255) NOT NULL,
    `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert some sample data if needed (optional)
INSERT INTO `gallery` (`title`, `type`, `image_url`) VALUES
('Our Main Facility', 'facility', 'facility1.jpg'),
('Research Lab', 'facility', 'lab1.jpg'),
('Team Meeting', 'team', 'team1.jpg'),
('Annual Conference', 'events', 'event1.jpg');
