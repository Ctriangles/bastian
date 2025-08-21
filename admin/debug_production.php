<?php
/**
 * Production Environment Debug Script
 * Use this to test your production environment configuration
 */

// Load CodeIgniter configuration
require_once 'application/config/config.php';

echo "<h1>Production Environment Debug</h1>";
echo "<h2>Server Information</h2>";
echo "<p><strong>HTTP Host:</strong> " . ($_SERVER['HTTP_HOST'] ?? 'unknown') . "</p>";
echo "<p><strong>Server Name:</strong> " . ($_SERVER['SERVER_NAME'] ?? 'unknown') . "</p>";
echo "<p><strong>Document Root:</strong> " . ($_SERVER['DOCUMENT_ROOT'] ?? 'unknown') . "</p>";

echo "<h2>Configuration Values</h2>";
echo "<p><strong>Base URL:</strong> " . $config['base_url'] . "</p>";
echo "<p><strong>Environment:</strong> " . $config['environment'] . "</p>";
echo "<p><strong>EatApp API URL:</strong> " . $config['eatapp_api_url'] . "</p>";
echo "<p><strong>EatApp Auth Key:</strong> " . substr($config['eatapp_auth_key'], 0, 20) . "...</p>";
echo "<p><strong>EatApp Group ID:</strong> " . $config['eatapp_group_id'] . "</p>";

echo "<h2>Environment Detection</h2>";
$is_local = in_array($_SERVER['HTTP_HOST'] ?? '', ['localhost', '127.0.0.1']) || 
            strpos($_SERVER['HTTP_HOST'] ?? '', 'localhost') !== false ||
            strpos($_SERVER['HTTP_HOST'] ?? '', 'bastian_parent') !== false;

echo "<p><strong>Is Local:</strong> " . ($is_local ? 'YES' : 'NO') . "</p>";
echo "<p><strong>Detected Environment:</strong> " . ($is_local ? 'local' : 'production') . "</p>";

echo "<h2>EatApp API Test</h2>";
$test_url = $config['eatapp_api_url'] . '/restaurants';
echo "<p><strong>Test URL:</strong> " . $test_url . "</p>";

// Test CURL connection
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $test_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 10);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Authorization: ' . $config['eatapp_auth_key'],
    'X-Group-ID: ' . $config['eatapp_group_id'],
    'Accept: application/json'
]);

$response = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$error = curl_error($ch);
curl_close($ch);

echo "<p><strong>HTTP Code:</strong> " . $http_code . "</p>";
if ($error) {
    echo "<p><strong>CURL Error:</strong> " . $error . "</p>";
} else {
    echo "<p><strong>Response:</strong> " . substr($response, 0, 500) . "...</p>";
}

echo "<h2>Recommendations</h2>";
if ($http_code === 200) {
    echo "<p style='color: green;'>✅ EatApp API is accessible!</p>";
} else {
    echo "<p style='color: red;'>❌ EatApp API is not accessible. Error: " . $error . "</p>";
    echo "<p><strong>Possible solutions:</strong></p>";
    echo "<ul>";
    echo "<li>Check if the EatApp API URL is correct</li>";
    echo "<li>Verify the authentication token is valid</li>";
    echo "<li>Check if there are any firewall restrictions</li>";
    echo "<li>Ensure the production server can make outbound HTTPS requests</li>";
    echo "</ul>";
}

echo "<hr>";
echo "<p><em>Generated on: " . date('Y-m-d H:i:s') . "</em></p>";
?> 