<?php
/**
 * Standalone Debug API - Test payment URL extraction
 * This file helps test the payment URL functionality without CodeIgniter routing
 */

// Simple password protection
if (!isset($_GET['debug_key']) || $_GET['debug_key'] !== 'bastian2024') {
    die('Access denied. Add ?debug_key=bastian2024 to URL to debug.');
}

// Test data - simulate what we expect from EatApp API (based on the real API structure)
$test_response_data = array(
    'data' => array(
        'id' => 'test-reservation-123',
        'type' => 'reservation',
        'attributes' => array(
            'key' => 'WZW73Y',
            'start_time' => '2024-08-07T16:00:00Z',
            'covers' => 2,
            'status' => 'confirmed'
        ),
        'relationships' => array(
            'payments' => array(
                'data' => array(
                    'id' => 'payment-123',
                    'type' => 'payment',
                    'attributes' => array(
                        'status' => 'requested',
                        'gateway' => 'stripe',
                        'description' => 'A pre-payment for 20.0 USD is required',
                        'payment_widget_url' => 'https://pay.eat-sandbox.co/UIF0PQ'
                    )
                )
            )
        )
    ),
    'meta' => array(
        'total_count' => 1
    )
);

echo "<h1>Payment URL Extraction Test</h1>";
echo "<p><strong>Goal:</strong> Extract the real payment URL that gets sent in the email</p>";

// Test the extraction logic
echo "<h2>Test Response Data (simulating EatApp API response):</h2>";
echo "<pre>";
print_r($test_response_data);
echo "</pre>";

// Simulate the extraction logic (same as in the controller)
function extract_payment_url_test($responseData) {
    $payment_url = null;
    
    // Look for payment_widget_url in relationships (the real location)
    if(isset($responseData['data']['relationships']['payments']['data']['attributes']['payment_widget_url'])) {
        $payment_url = $responseData['data']['relationships']['payments']['data']['attributes']['payment_widget_url'];
        echo "<p>✅ Found payment_widget_url in relationships: $payment_url</p>";
    }
    // Fallback to other possible locations
    elseif(isset($responseData['data']['attributes']['payment_widget_url'])) {
        $payment_url = $responseData['data']['attributes']['payment_widget_url'];
        echo "<p>✅ Found payment_widget_url in attributes: $payment_url</p>";
    }
    elseif(isset($responseData['data']['attributes']['payment_url'])) {
        $payment_url = $responseData['data']['attributes']['payment_url'];
        echo "<p>✅ Found payment_url in attributes: $payment_url</p>";
    }
    elseif(isset($responseData['data']['attributes']['payment_link'])) {
        $payment_url = $responseData['data']['attributes']['payment_link'];
        echo "<p>✅ Found payment_link in attributes: $payment_url</p>";
    }
    elseif(isset($responseData['payment_url'])) {
        $payment_url = $responseData['payment_url'];
        echo "<p>✅ Found payment_url in root: $payment_url</p>";
    }
    else {
        echo "<p>❌ No payment URL found in response</p>";
    }
    
    return $payment_url;
}

echo "<h2>Extraction Test Results:</h2>";
$extracted_url = extract_payment_url_test($test_response_data);

echo "<h2>Final Result:</h2>";
if($extracted_url) {
    echo "<p><strong>🎯 Payment URL found:</strong> <a href='$extracted_url' target='_blank'>$extracted_url</a></p>";
    echo "<p><strong>Amount:</strong> $20.00 USD</p>";
} else {
    echo "<p><strong>❌ No payment URL found</strong></p>";
}

echo "<hr>";
echo "<h2>How to Test the Real API:</h2>";
echo "<ol>";
echo "<li><strong>Make a real reservation</strong> through your frontend</li>";
echo "<li><strong>Check the browser console</strong> for debugging output</li>";
echo "<li><strong>Look for the payment URL</strong> in the API response</li>";
echo "<li><strong>Verify the payment button</strong> appears in the success UI</li>";
echo "</ol>";

echo "<h3>Expected API Response Structure:</h3>";
echo "<pre>";
echo "{
  \"status\": true,
  \"data\": { /* EatApp response */ },
  \"message\": \"Reservation created successfully\",
  \"local_id\": 123,
  \"payment_url\": \"http://e-link1.eatapp.co/ls/click?upn=...\",
  \"payment_required\": true,
  \"payment_amount\": 20.00
}";
echo "</pre>";

echo "<h3>Frontend Integration:</h3>";
echo "<p>The React component will automatically:</p>";
echo "<ul>";
echo "<li>Extract the payment_url from the API response</li>";
echo "<li>Show a 'Complete Your Reservation' button if payment_url exists</li>";
echo "<li>Open the payment URL in a new tab when clicked</li>";
echo "</ul>";

echo "<hr>";
echo "<h2>Test Real API Endpoint:</h2>";
echo "<p>To test the real API, use this endpoint:</p>";
echo "<code>POST http://localhost/bastian_parent/bastian/admin/api/eatapp_controller/create_reservation</code>";
echo "<br><br>";
echo "<p>Headers: Authorization: 123456789</p>";
echo "<p>Body: JSON with reservation data</p>";
?> 