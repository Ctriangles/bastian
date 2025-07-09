-- Create table for storing EatApp restaurants locally
-- This prevents frontend from making direct API calls to EatApp

CREATE TABLE IF NOT EXISTS `eatapp_restaurants` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `eatapp_id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` text,
  `status` enum('active','inactive') DEFAULT 'active',
  `eatapp_data` longtext,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `eatapp_id` (`eatapp_id`),
  KEY `status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Create table for storing availability cache
-- This prevents real-time availability checks from frontend

CREATE TABLE IF NOT EXISTS `eatapp_availability` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `restaurant_id` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `covers` int(11) NOT NULL,
  `available_slots` longtext,
  `cached_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `expires_at` timestamp NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `restaurant_date_covers` (`restaurant_id`, `date`, `covers`),
  KEY `expires_at` (`expires_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Create table for storing reservations locally before sending to EatApp
-- This ensures data is saved even if EatApp API fails

CREATE TABLE IF NOT EXISTS `eatapp_reservations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `restaurant_id` varchar(255) NOT NULL,
  `eatapp_reservation_key` varchar(255) DEFAULT NULL,
  `covers` int(11) NOT NULL,
  `start_time` datetime NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `notes` text,
  `status` enum('pending','confirmed','failed','cancelled') DEFAULT 'pending',
  `eatapp_response` longtext,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `restaurant_id` (`restaurant_id`),
  KEY `status` (`status`),
  KEY `eatapp_reservation_key` (`eatapp_reservation_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
