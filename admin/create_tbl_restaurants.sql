-- Create tbl_restaurants table for admin panel compatibility
-- This table is used by the admin panel to display restaurant names

CREATE TABLE IF NOT EXISTS `tbl_restaurants` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `eatapp_id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` text,
  `status` int(1) DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `eatapp_id` (`eatapp_id`),
  KEY `status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert restaurant data for admin panel compatibility
INSERT INTO `tbl_restaurants` (`eatapp_id`, `name`, `address`, `status`, `created_at`, `updated_at`) VALUES
('43383004', 'Bastian At The Top', 'Palladium Mall, High Street Phoenix, Lower Parel, Mumbai', 1, NOW(), NOW()),
('98725763', 'Bastian Bandra', 'Linking Road, Bandra West, Mumbai', 1, NOW(), NOW()),
('51191537', 'Inka By Bastian', 'Inka Restaurant Location', 1, NOW(), NOW()),
('10598428', 'Bastian Empire (Pune)', 'The Westin, 36, Mundhwa Rd, Koregaon Park Annexe, Ghorpadi, Pune', 1, NOW(), NOW()),
('92788130', 'Bastian Garden City (Bengaluru)', 'Garden City Mall, Bangalore', 1, NOW(), NOW())
ON DUPLICATE KEY UPDATE 
  `name` = VALUES(`name`),
  `address` = VALUES(`address`),
  `status` = VALUES(`status`),
  `updated_at` = NOW();
