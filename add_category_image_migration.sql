-- Migration script to add image_url column to categories table
-- Run this if you already have the categories table created

-- Add image_url column to categories table
ALTER TABLE `categories` 
ADD COLUMN `image_url` varchar(255) DEFAULT NULL AFTER `icon`;

-- Update existing categories with sample image URLs (optional)
UPDATE `categories` SET `image_url` = 'aquaculture.jpg' WHERE `name` = 'Aquaculture';
UPDATE `categories` SET `image_url` = 'poultry.jpg' WHERE `name` = 'Poultry Health Care';

SELECT 'Migration completed successfully! image_url column added to categories table.' as message;
