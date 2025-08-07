<?php
/**
 * EatApp Database Setup Script
 * Run this script once to set up the required database tables and sync restaurants
 * 
 * Usage: 
 * 1. Upload this file to your admin directory
 * 2. Access via browser: https://yourdomain.com/admin/setup_eatapp_database.php
 * 3. Delete this file after successful setup
 */

// Prevent direct access in production
if ($_SERVER['HTTP_HOST'] !== 'localhost' && $_SERVER['HTTP_HOST'] !== '127.0.0.1') {
    // Add a simple password protection for production
    if (!isset($_GET['setup_key']) || $_GET['setup_key'] !== 'bastian2024') {
        die('Access denied. Add ?setup_key=bastian2024 to URL to run setup.');
    }
}

// Include CodeIgniter
require_once 'application/config/config.php';
require_once 'application/config/database.php';
require_once 'system/database/DB.php';

// Database configuration
$db_config = array(
    'hostname' => $db['default']['hostname'],
    'username' => $db['default']['username'],
    'password' => $db['default']['password'],
    'database' => $db['default']['database'],
    'dbdriver' => $db['default']['dbdriver'],
    'char_set' => $db['default']['char_set'],
    'dbcollat' => $db['default']['dbcollat']
);

// Initialize database connection
$db = new CI_DB($db_config);

echo "<h1>EatApp Database Setup</h1>";

// Step 1: Create tables
echo "<h2>Step 1: Creating Database Tables</h2>";

$tables_sql = array(
    "eatapp_restaurants" => "
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
    ",
    
    "eatapp_availability" => "
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
    ",
    
    "eatapp_reservations" => "
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
    "
);

foreach ($tables_sql as $table_name => $sql) {
    if ($db->query($sql)) {
        echo "✅ Table '$table_name' created successfully<br>";
    } else {
        echo "❌ Error creating table '$table_name': " . $db->error()['message'] . "<br>";
    }
}

// Step 2: Sync restaurants from EatApp
echo "<h2>Step 2: Syncing Restaurants from EatApp</h2>";

// EatApp API Configuration
$eatapp_api_url = 'https://api.eat-sandbox.co/concierge/v2';
$eatapp_auth_key = 'Bearer eyJhbGciOiJIUzI1NiJ9.eyJleHAiOjE4OTIwNzM2MDAsImlhdCI6MTc0NTgxOTQ0NSwiaWQiOiJkOWZkNTI0Mi04YmQzLTQ1NDYtODNlNy1jZjU1NzY5MDI0MTIiLCJtb2RlbCI6IkNvbmNpZXJnZSIsImp0aSI6IjFkYWU1ZjYyOWM3M2VmOTU3M2U0IiwiYnkiOiJhbGlAZWF0YXBwLmNvIn0.ZCEiRP1gqPNvJEFYDVCk1uA6o0MSD2pzXu88eGh8xt0';
$eatapp_group_id = '4bcc6bdd-765b-4486-83ab-17c175dc3910';

$headers = array(
    'Authorization: ' . $eatapp_auth_key,
    'X-Group-ID: ' . $eatapp_group_id,
    'Accept: application/json',
    'Content-Type: application/json'
);

// Make API call to EatApp
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $eatapp_api_url . '/restaurants');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 30);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$response = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$error = curl_error($ch);
curl_close($ch);

if ($error) {
    echo "❌ Error connecting to EatApp API: $error<br>";
} elseif ($http_code !== 200) {
    echo "❌ EatApp API returned HTTP $http_code<br>";
    echo "Response: $response<br>";
} else {
    $eatapp_data = json_decode($response, true);
    
    if (isset($eatapp_data['data']) && is_array($eatapp_data['data'])) {
        $count = 0;
        foreach ($eatapp_data['data'] as $restaurant) {
            $data = array(
                'eatapp_id' => $restaurant['id'],
                'name' => $restaurant['attributes']['name'],
                'address' => $restaurant['attributes']['address_line_1'] ?? '',
                'status' => 'active',
                'eatapp_data' => json_encode($restaurant),
                'updated_at' => date('Y-m-d H:i:s')
            );

            // Check if restaurant already exists
            $existing = $db->where('eatapp_id', $restaurant['id'])->get('eatapp_restaurants');

            if ($existing->num_rows() > 0) {
                // Update existing
                $db->where('eatapp_id', $restaurant['id'])->update('eatapp_restaurants', $data);
                echo "🔄 Updated restaurant: " . $restaurant['attributes']['name'] . "<br>";
            } else {
                // Insert new
                $data['created_at'] = date('Y-m-d H:i:s');
                $db->insert('eatapp_restaurants', $data);
                echo "✅ Added restaurant: " . $restaurant['attributes']['name'] . "<br>";
            }
            $count++;
        }
        echo "<br>🎉 Successfully synced $count restaurants from EatApp!<br>";
    } else {
        echo "❌ Invalid response format from EatApp API<br>";
        echo "Response: $response<br>";
    }
}

// Step 3: Test the API endpoint
echo "<h2>Step 3: Testing API Endpoint</h2>";

$test_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$test_url = str_replace('setup_eatapp_database.php', 'api/eatapp/restaurants', $test_url);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $test_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 30);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: 123456789'));

$response = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($http_code === 200) {
    $data = json_decode($response, true);
    if ($data && isset($data['status']) && $data['status'] === true) {
        echo "✅ API endpoint working correctly!<br>";
        echo "Found " . count($data['data']['data']) . " restaurants<br>";
    } else {
        echo "❌ API endpoint returned invalid response<br>";
        echo "Response: $response<br>";
    }
} else {
    echo "❌ API endpoint returned HTTP $http_code<br>";
    echo "Response: $response<br>";
}

echo "<h2>Setup Complete!</h2>";
echo "<p>If everything shows ✅ above, your EatApp integration should now work correctly.</p>";
echo "<p><strong>Important:</strong> Delete this setup file after successful setup for security.</p>";
?> 