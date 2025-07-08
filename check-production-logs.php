<?php
// Simple script to check if production backend submission is working
// This will test the exact same method that gets called automatically

// Include CodeIgniter if needed, or just test the cURL directly
function testProductionSubmission() {
    $productionUrl = "https://bastian.ninetriangles.com/admin/api/reservation-form";
    
    $testData = array(
        'formvalue' => array(
            'restaurant_id' => 'MANUAL-TEST-' . time(),
            'booking_date' => '2024-12-31',
            'booking_time' => '20:00:00',
            'full_name' => 'Manual Production Test',
            'email' => 'manual.test@example.com',
            'mobile' => '9999999999',
            'pax' => '2',
            'age' => '25-35',
            'pincode' => '400001',
            'comments' => 'Manual test to verify production backend submission - ' . date('Y-m-d H:i:s')
        )
    );
    
    echo "🧪 Testing Production Backend Submission\n";
    echo "Target URL: $productionUrl\n";
    echo "Test Data: " . json_encode($testData, JSON_PRETTY_PRINT) . "\n\n";
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $productionUrl);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($testData));
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Authorization: 123456789',
        'Content-Type: application/json'
    ));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_VERBOSE, true);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curlError = curl_error($ch);
    $curlInfo = curl_getinfo($ch);
    curl_close($ch);
    
    echo "📊 RESULTS:\n";
    echo "HTTP Status Code: $httpCode\n";
    
    if ($curlError) {
        echo "❌ cURL Error: $curlError\n";
    } else {
        echo "✅ Request completed successfully\n";
    }
    
    echo "Response: $response\n\n";
    
    echo "🔍 Connection Details:\n";
    echo "Total Time: " . $curlInfo['total_time'] . " seconds\n";
    echo "DNS Lookup Time: " . $curlInfo['namelookup_time'] . " seconds\n";
    echo "Connect Time: " . $curlInfo['connect_time'] . " seconds\n";
    
    if ($httpCode >= 200 && $httpCode < 300) {
        echo "\n🎉 SUCCESS: Data should now appear at https://bastian.ninetriangles.com/admin/backend/enquiries/\n";
        return true;
    } else {
        echo "\n❌ FAILED: HTTP $httpCode - Data may not have been saved\n";
        echo "Check if:\n";
        echo "1. The production server is accessible\n";
        echo "2. The API key '123456789' is correct\n";
        echo "3. The endpoint '/admin/api/reservation-form' exists\n";
        return false;
    }
}

// Run the test
testProductionSubmission();
?>
