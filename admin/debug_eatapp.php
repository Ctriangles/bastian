<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once('application/config/config.php');

// Test EatApp API connection
$eatapp_api_url = isset($config['eatapp_api_url']) ? $config['eatapp_api_url'] : 'Not configured';
$eatapp_auth_key = isset($config['eatapp_auth_key']) ? $config['eatapp_auth_key'] : 'Not configured';
$eatapp_group_id = isset($config['eatapp_group_id']) ? $config['eatapp_group_id'] : 'Not configured';

echo "<h2>EatApp Configuration Test</h2>";
echo "<pre>";
echo "API URL: " . $eatapp_api_url . "\n";
echo "Auth Key: [" . substr($eatapp_auth_key, 0, 20) . "...]\n";
echo "Group ID: " . $eatapp_group_id . "\n";

// Test API Connection
$url = $eatapp_api_url . '/restaurants';
$headers = array(
    'Authorization: ' . $eatapp_auth_key,
    'X-Group-ID: ' . $eatapp_group_id,
    'Accept: application/json'
);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_VERBOSE, true);

$verbose = fopen('php://temp', 'w+');
curl_setopt($ch, CURLOPT_STDERR, $verbose);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

rewind($verbose);
$verboseLog = stream_get_contents($verbose);

echo "\nAPI Test Results:\n";
echo "HTTP Code: " . $httpCode . "\n";
echo "Response: " . substr($response, 0, 500) . "...\n\n";
echo "Verbose Log:\n" . $verboseLog . "\n";

if(curl_errno($ch)) {
    echo "Curl Error: " . curl_error($ch) . "\n";
}

curl_close($ch);
echo "</pre>";
