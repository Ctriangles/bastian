-- EatApp Integration Database Tables
-- Run this SQL script to create the required tables for EatApp integration

-- Table to store restaurants from EatApp
CREATE TABLE IF NOT EXISTS `eatapp_restaurants` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `eatapp_id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` text,
  `status` enum('active','inactive') DEFAULT 'active',
  `eatapp_data` longtext,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `eatapp_id` (`eatapp_id`),
  KEY `status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table to cache availability data from EatApp
CREATE TABLE IF NOT EXISTS `eatapp_availability` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `restaurant_id` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `covers` int(11) NOT NULL,
  `available_slots` longtext,
  `cached_at` datetime NOT NULL,
  `expires_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `restaurant_date_covers` (`restaurant_id`, `date`, `covers`),
  KEY `expires_at` (`expires_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table to store reservations (database-first approach)
CREATE TABLE IF NOT EXISTS `eatapp_reservations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `restaurant_id` varchar(255) NOT NULL,
  `covers` int(11) NOT NULL,
  `start_time` datetime NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `notes` text,
  `status` enum('pending','confirmed','failed','cancelled') DEFAULT 'pending',
  `eatapp_reservation_key` varchar(255) NULL,
  `eatapp_response` longtext,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `restaurant_id` (`restaurant_id`),
  KEY `status` (`status`),
  KEY `start_time` (`start_time`),
  KEY `eatapp_reservation_key` (`eatapp_reservation_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert sample restaurant data (you can modify these based on your actual restaurants)
INSERT INTO `eatapp_restaurants` (`eatapp_id`, `name`, `address`, `status`, `eatapp_data`, `created_at`, `updated_at`) VALUES
('43383004', 'Bastian At The Top', 'Palladium Mall, High Street Phoenix, Lower Parel, Mumbai', 'active', '{"id":"43383004","type":"restaurant","attributes":{"name":"Bastian At The Top","available_online":true,"address_line_1":"Palladium Mall, High Street Phoenix, Lower Parel, Mumbai"}}', NOW(), NOW()),
('98725763', 'Bastian Bandra', 'Linking Road, Bandra West, Mumbai', 'active', '{"id":"98725763","type":"restaurant","attributes":{"name":"Bastian Bandra","available_online":true,"address_line_1":"Linking Road, Bandra West, Mumbai"}}', NOW(), NOW()),
('92788130', 'Bastian Garden City', 'Garden City Mall, Bangalore', 'active', '{"id":"92788130","type":"restaurant","attributes":{"name":"Bastian Garden City","available_online":true,"address_line_1":"Garden City Mall, Bangalore"}}', NOW(), NOW())
ON DUPLICATE KEY UPDATE 
  `name` = VALUES(`name`),
  `address` = VALUES(`address`),
  `status` = VALUES(`status`),
  `eatapp_data` = VALUES(`eatapp_data`),
  `updated_at` = NOW();
