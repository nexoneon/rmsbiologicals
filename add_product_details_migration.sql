-- Migration script to add product detail fields
-- Run this to add composition, benefits, dosage, and available_sizes fields

-- Add new columns to products table
ALTER TABLE `products` 
ADD COLUMN `composition` text DEFAULT NULL AFTER `description`,
ADD COLUMN `benefits` text DEFAULT NULL AFTER `composition`,
ADD COLUMN `dosage` varchar(255) DEFAULT NULL AFTER `benefits`,
ADD COLUMN `available_sizes` varchar(255) DEFAULT NULL AFTER `dosage`;

-- Update sample products with detailed information (optional)
UPDATE `products` SET 
    `composition` = 'High quality ingredients, scientifically formulated',
    `benefits` = 'Promotes healthy growth\nImproves immunity\nEnhances productivity',
    `dosage` = '5 gms per Kg feed',
    `available_sizes` = '1kg, 5kg, 25kg'
WHERE `id` = 1;

SELECT 'Migration completed successfully! Product detail fields added.' as message;
