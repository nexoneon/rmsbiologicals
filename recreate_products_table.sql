-- Script to recreate products table with all fields
-- WARNING: This will delete all existing products data!
-- Run this in phpMyAdmin SQL tab or via run_recreate_products.php

-- Drop existing products table
DROP TABLE IF EXISTS `products`;

-- Create products table with all fields
CREATE TABLE `products` (
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

-- Insert sample products with detailed information
INSERT INTO `products` (`id`, `name`, `description`, `composition`, `benefits`, `dosage`, `available_sizes`, `category`, `price`, `image_url`, `featured`, `status`) VALUES
(1, 'HERBEX', 'Herbal growth promoter for shrimp and fish', 'Natural herbal extracts, Vitamins, Minerals', 'Promotes healthy growth\nImproves immunity\nEnhances feed conversion\nReduces stress', '5 gms per Kg feed', '1kg, 5kg, 25kg', 'aquaculture', 1250.00, 'shrimp.jpg', 1, 'active'),
(2, 'NUTRIZYME', 'Enzyme supplement for better digestion', 'Protease, Amylase, Lipase, Cellulase', 'Improves digestion\nEnhances nutrient absorption\nReduces feed cost\nImproves water quality', '3 gms per Kg feed', '500g, 1kg, 5kg', 'aquaculture', 980.00, 'pill.jpg', 1, 'active'),
(3, 'PARACURE', 'Anti-parasitic treatment for aquaculture', 'Herbal anti-parasitic compounds', 'Eliminates parasites\nSafe for aquatic life\nNo withdrawal period\nImproves health', '10 gms per 100 liters', '100g, 500g, 1kg', 'aquaculture', 1450.00, 'lab.jpg', 1, 'active'),
(4, 'GUT CLEAN', 'Gut health optimizer for shrimp and fish', 'Probiotics, Prebiotics, Enzymes', 'Maintains gut health\nPrevents diseases\nImproves growth\nEnhances immunity', '5 gms per Kg feed', '500g, 1kg, 5kg', 'aquaculture', 1100.00, 'herb.jpg', 1, 'active'),
(5, 'Vitamin Premix A+', 'Complete vitamin supplement for poultry', 'Vitamin A, D3, E, K, B-complex', 'Prevents vitamin deficiency\nImproves egg production\nEnhances growth\nBoosts immunity', '1 gm per Kg feed', '500g, 1kg, 5kg, 25kg', 'poultry', 750.00, 'vitamin.jpg', 1, 'active'),
(6, 'Mineral Boost', 'Essential minerals blend for poultry', 'Calcium, Phosphorus, Zinc, Iron, Copper', 'Strengthens bones\nImproves eggshell quality\nPrevents mineral deficiency\nEnhances productivity', '2 gms per Kg feed', '1kg, 5kg, 25kg', 'poultry', 680.00, 'mineral.jpg', 1, 'active'),
(7, 'Poultry Pro', 'Growth promoter for broilers and layers', 'Amino acids, Vitamins, Minerals, Probiotics', 'Accelerates growth\nImproves FCR\nEnhances meat quality\nBoosts egg production', '500 gms per 100 Kg feed', '1kg, 5kg, 25kg', 'poultry', 890.00, 'chicken.jpg', 1, 'active'),
(8, 'VetCare Plus', 'General health supplement for livestock', 'Multivitamins, Minerals, Amino acids', 'Maintains overall health\nImproves productivity\nEnhances immunity\nReduces stress', '10 ml per animal per day', '500ml, 1L, 5L', 'veterinary', 1200.00, 'cattle.jpg', 1, 'active'),
(9, 'Livestorm', 'Liver support formula for animals', 'Liver tonics, Vitamins, Amino acids', 'Supports liver function\nImproves metabolism\nDetoxifies body\nEnhances appetite', '20 ml per animal per day', '500ml, 1L, 5L', 'veterinary', 1350.00, 'medical.jpg', 1, 'active');

SELECT 'Products table recreated successfully with all fields and sample data!' as message;
