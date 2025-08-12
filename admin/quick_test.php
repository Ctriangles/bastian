<?php
// Quick test to verify login endpoint
echo "Testing login endpoint...\n";

$url = 'https://bastian.ninetriangles.com/admin/user_controller/backend_login';

// Test with timestamp to avoid caching
$url .= '?t=' . time();

$data = http_build_query([
    'username' => 'admin',
    'password' => 'admin123'
]);

$context = stream_context_create([
    'http' => [
        'method' => 'POST',
        'header' => [
            'Content-Type: application/x-www-form-urlencoded',
            'Cache-Control: no-cache',
            'Pragma: no-cache'
        ],
        'content' => $data
    ]
]);

try {
    $response = file_get_contents($url, false, $context);
    echo "Response: '$response'\n";
    echo "Response length: " . strlen($response) . "\n";
    echo "Response type: " . gettype($response) . "\n";
    
    if (trim($response) === 'true') {
        echo "✅ SUCCESS: Login working correctly!\n";
    } else {
        echo "❌ FAILED: Expected 'true', got '$response'\n";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?> 