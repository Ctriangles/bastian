<?php
/**
 * Production API Test Script
 * Tests all the required APIs to ensure they work in production
 */

// Load CodeIgniter configuration
require_once 'application/config/config.php';

echo "<h1>Production API Test Suite</h1>";
echo "<p><strong>Environment:</strong> " . $config['environment'] . "</p>";
echo "<p><strong>API Base URL:</strong> " . $config['base_url'] . "</p>";
echo "<p><strong>EatApp API URL:</strong> " . $config['eatapp_api_url'] . "</p>";

// Test configuration
$test_restaurant_id = "74e1a9cc-bad1-4217-bab5-4264a987cd7f"; // Use the working restaurant ID
$test_headers = ['Authorization: 123456789', 'Content-Type: application/json'];

echo "<hr>";
echo "<h2>1. Testing Restaurant Fetching API</h2>";

// Test restaurants endpoint
$restaurants_url = $config['base_url'] . '/api/eatapp/restaurants';
echo "<p><strong>Testing:</strong> GET $restaurants_url</p>";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $restaurants_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 30);
curl_setopt($ch, CURLOPT_HTTPHEADER, $test_headers);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

$response = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$error = curl_error($ch);
curl_close($ch);

if ($http_code === 200) {
    echo "<p style='color: green;'>✅ RESTAURANTS API: Working (HTTP $http_code)</p>";
    $restaurants_data = json_decode($response, true);
    if (isset($restaurants_data['data']['data'])) {
        echo "<p>Found " . count($restaurants_data['data']['data']) . " restaurants</p>";
    }
} else {
    echo "<p style='color: red;'>❌ RESTAURANTS API: Failed (HTTP $http_code)</p>";
    if ($error) echo "<p>Error: $error</p>";
    echo "<p>Response: " . substr($response, 0, 500) . "...</p>";
}

echo "<hr>";
echo "<h2>2. Testing Availability API</h2>";

// Test availability endpoint
$availability_url = $config['base_url'] . '/api/eatapp/availability';
echo "<p><strong>Testing:</strong> POST $availability_url</p>";

$availability_data = json_encode([
    'restaurant_id' => $test_restaurant_id,
    'earliest_start_time' => '2025-08-19T18:00:00',
    'latest_start_time' => '2025-08-19T22:00:00',
    'covers' => 2
]);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $availability_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 30);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $availability_data);
curl_setopt($ch, CURLOPT_HTTPHEADER, $test_headers);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

$response = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$error = curl_error($ch);
curl_close($ch);

if ($http_code === 200) {
    echo "<p style='color: green;'>✅ AVAILABILITY API: Working (HTTP $http_code)</p>";
    $availability_response = json_decode($response, true);
    if (isset($availability_response['data']['data']['attributes']['available'])) {
        $available_times = $availability_response['data']['data']['attributes']['available'];
        echo "<p>Found " . count($available_times) . " available time slots</p>";
    }
} else {
    echo "<p style='color: red;'>❌ AVAILABILITY API: Failed (HTTP $http_code)</p>";
    if ($error) echo "<p>Error: $error</p>";
    echo "<p>Response: " . substr($response, 0, 500) . "...</p>";
}

echo "<hr>";
echo "<h2>3. Testing Reservation Creation API</h2>";

// Test reservation creation endpoint
$reservation_url = $config['base_url'] . '/api/eatapp_controller/create_reservation';
echo "<p><strong>Testing:</strong> POST $reservation_url</p>";

$reservation_data = json_encode([
    'restaurant_id' => $test_restaurant_id,
    'covers' => 2,
    'start_time' => '2025-08-19T19:00:00',
    'first_name' => 'Test',
    'last_name' => 'User',
    'email' => 'test@example.com',
    'phone' => '1234567890'
]);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $reservation_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 30);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $reservation_data);
curl_setopt($ch, CURLOPT_HTTPHEADER, $test_headers);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

$response = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$error = curl_error($ch);
curl_close($ch);

if ($http_code === 201) {
    echo "<p style='color: green;'>✅ RESERVATION API: Working (HTTP $http_code)</p>";
    $reservation_response = json_decode($response, true);
    
    // Check for payment widget URL
    if (isset($reservation_response['payment_url'])) {
        echo "<p style='color: green;'>✅ Payment Widget URL: Found</p>";
        echo "<p><strong>Payment URL:</strong> " . $reservation_response['payment_url'] . "</p>";
        echo "<p><strong>Payment Required:</strong> " . ($reservation_response['payment_required'] ? 'Yes' : 'No') . "</p>";
        echo "<p><strong>Payment Amount:</strong> $" . $reservation_response['payment_amount'] . "</p>";
    } else {
        echo "<p style='color: orange;'>⚠️ Payment Widget URL: Not found in response</p>";
    }
    
    if (isset($reservation_response['local_id'])) {
        echo "<p><strong>Local Reservation ID:</strong> " . $reservation_response['local_id'] . "</p>";
    }
} else {
    echo "<p style='color: red;'>❌ RESERVATION API: Failed (HTTP $http_code)</p>";
    if ($error) echo "<p>Error: $error</p>";
    echo "<p>Response: " . substr($response, 0, 500) . "...</p>";
}

echo "<hr>";
echo "<h2>4. Testing Form Submission APIs</h2>";

// Test form submission endpoints
$form_endpoints = [
    'Header Form' => '/api/header-form',
    'Footer Short Form' => '/api/footer-sort-form',
    'Footer Long Form' => '/api/footer-long-form',
    'Career Form' => '/api/career',
    'Reservation Form' => '/api/reservation-form'
];

foreach ($form_endpoints as $name => $endpoint) {
    $form_url = $config['base_url'] . $endpoint;
    echo "<p><strong>Testing:</strong> $name - POST $form_url</p>";
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $form_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(['test' => 'data']));
    curl_setopt($ch, CURLOPT_HTTPHEADER, $test_headers);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    
    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error = curl_error($ch);
    curl_close($ch);
    
    if ($http_code === 200 || $http_code === 201) {
        echo "<p style='color: green;'>✅ $name: Working (HTTP $http_code)</p>";
    } else {
        echo "<p style='color: red;'>❌ $name: Failed (HTTP $http_code)</p>";
        if ($error) echo "<p>Error: $error</p>";
    }
}

echo "<hr>";
echo "<h2>5. Environment Summary</h2>";

echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
echo "<tr><th>Component</th><th>Status</th><th>Details</th></tr>";

// Environment detection
$is_local = in_array($_SERVER['HTTP_HOST'] ?? '', ['localhost', '127.0.0.1']) || 
            strpos($_SERVER['HTTP_HOST'] ?? '', 'localhost') !== false ||
            strpos($_SERVER['HTTP_HOST'] ?? '', 'bastian_parent') !== false;

echo "<tr>";
echo "<td>Environment Detection</td>";
echo "<td>" . ($is_local ? 'Local' : 'Production') . "</td>";
echo "<td>Host: " . ($_SERVER['HTTP_HOST'] ?? 'unknown') . "</td>";
echo "</tr>";

echo "<tr>";
echo "<td>EatApp API</td>";
echo "<td>" . ($config['eatapp_api_url'] === 'https://api.eat-sandbox.co/concierge/v2' ? 'Sandbox' : 'Production') . "</td>";
echo "<td>" . $config['eatapp_api_url'] . "</td>";
echo "</tr>";

echo "<tr>";
echo "<td>Base URL</td>";
echo "<td>" . ($config['base_url'] === 'https://bastian.ninetriangles.com/admin' ? 'Production' : 'Local') . "</td>";
echo "<td>" . $config['base_url'] . "</td>";
echo "</tr>";

echo "</table>";

echo "<hr>";
echo "<h2>6. Recommendations</h2>";

if ($is_local) {
    echo "<p style='color: blue;'>🔵 You are currently testing on LOCAL environment</p>";
    echo "<p>To test production, deploy these files to your production server:</p>";
    echo "<ul>";
    echo "<li>admin/application/config/config.php</li>";
    echo "<li>admin/application/controllers/api/Eatapp_controller.php</li>";
    echo "<li>bastian-updated-reservation-api/src/API/api_url.jsx (after building)</li>";
    echo "</ul>";
} else {
    echo "<p style='color: green;'>🟢 You are currently testing on PRODUCTION environment</p>";
    echo "<p>All APIs should be working with the updated configuration.</p>";
}

echo "<hr>";
echo "<p><em>Test completed on: " . date('Y-m-d H:i:s') . "</em></p>";
echo "<p><a href='switch_environment.php'>Switch Environment</a> | <a href='debug_production.php'>Debug Production</a></p>";
?> 