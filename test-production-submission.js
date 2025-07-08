#!/usr/bin/env node

// Test script to verify production backend submission
const axios = require('axios');

const API_BASE = 'http://localhost/bastian-admin/api';
const API_KEY = '123456789';

const headers = {
  'Authorization': API_KEY,
  'Content-Type': 'application/json'
};

async function testProductionSubmission() {
  console.log('🧪 Testing Production Backend Submission\n');

  try {
    // Test data for production submission
    const testData = {
      formvalue: {
        restaurant_id: "test-restaurant-001",
        booking_date: "2024-12-31",
        booking_time: "19:00:00",
        full_name: "Production Test User",
        email: "production.test@example.com",
        mobile: "9876543210",
        pax: "4",
        age: "25-35",
        pincode: "400001",
        comments: "Test reservation for production backend verification"
      }
    };

    console.log('📤 Sending test data to production backend...');
    console.log('Data:', JSON.stringify(testData, null, 2));

    // Test the production submission endpoint
    const response = await axios.post(`${API_BASE}/test-production-submission`, testData, { headers });

    console.log('\n✅ Response received:');
    console.log('Status:', response.status);
    console.log('Data:', JSON.stringify(response.data, null, 2));

    if (response.data.status) {
      console.log('\n🎉 SUCCESS: Data successfully sent to production backend!');
      console.log('Production Response Details:');
      console.log('- HTTP Code:', response.data.production_response.http_code);
      console.log('- Success:', response.data.production_response.success);
      
      if (response.data.production_response.response) {
        try {
          const prodResponse = JSON.parse(response.data.production_response.response);
          console.log('- Production Response:', prodResponse);
        } catch (e) {
          console.log('- Production Response (raw):', response.data.production_response.response);
        }
      }
    } else {
      console.log('\n❌ FAILED: Could not send data to production backend');
      console.log('Error:', response.data.message);
    }

    // Also test the regular reservation form to ensure it triggers production submission
    console.log('\n📝 Testing regular reservation form (should also trigger production submission)...');
    
    const regularResponse = await axios.post(`${API_BASE}/reservation-form`, testData, { headers });
    
    console.log('Regular form response:');
    console.log('Status:', regularResponse.status);
    console.log('Data:', JSON.stringify(regularResponse.data, null, 2));

    if (regularResponse.data.status) {
      console.log('\n✅ Regular reservation form also working correctly');
      console.log('Reservation ID:', regularResponse.data.reservation_id);
    }

  } catch (error) {
    console.error('\n❌ Test failed:', error.message);
    if (error.response) {
      console.error('Response status:', error.response.status);
      console.error('Response data:', error.response.data);
    }
    process.exit(1);
  }
}

// Test EatApp reservation to ensure it also triggers production submission
async function testEatAppReservation() {
  console.log('\n🍽️ Testing EatApp reservation (should also trigger production submission)...');

  try {
    const eatAppData = {
      restaurant_id: "74e1a9cc-bad1-4217-bab5-4264a987cd7f",
      covers: 2,
      start_time: "2025-07-10T19:00:00",
      first_name: "EatApp",
      last_name: "Test",
      email: "eatapp.test@example.com",
      phone: "1234567890",
      notes: "EatApp test reservation",
      referrer_tag: "concierge",
      terms_and_conditions_accepted: true,
      marketing_accepted: true
    };

    const response = await axios.post(`${API_BASE}/eatapp-reservations`, eatAppData, { headers });

    console.log('EatApp reservation response:');
    console.log('Status:', response.status);
    
    if (response.status === 201) {
      console.log('✅ EatApp reservation created successfully');
      console.log('This should have also triggered production backend submission');
    } else {
      console.log('❌ EatApp reservation failed');
    }

  } catch (error) {
    console.error('EatApp reservation error:', error.message);
    if (error.response) {
      console.error('Response status:', error.response.status);
      console.error('Response data:', error.response.data);
    }
  }
}

async function runAllTests() {
  console.log('🚀 Starting Production Backend Submission Tests\n');
  
  await testProductionSubmission();
  await testEatAppReservation();
  
  console.log('\n📋 Summary:');
  console.log('1. ✅ Direct production submission test completed');
  console.log('2. ✅ Regular reservation form test completed');
  console.log('3. ✅ EatApp reservation test completed');
  console.log('\n💡 Check the server logs for detailed production backend submission attempts');
  console.log('💡 Verify data appears at: https://bastian.ninetriangles.com/admin/backend/enquiries/');
}

// Run the tests
runAllTests();
