#!/usr/bin/env node

// Simple verification script for production backend submission
const axios = require('axios');

const API_BASE = 'http://localhost/bastian-admin/api';
const API_KEY = '123456789';

const headers = {
  'Authorization': API_KEY,
  'Content-Type': 'application/json'
};

async function testReservationWithProductionSubmission() {
  console.log('🧪 Testing Reservation with Automatic Production Backend Submission\n');

  try {
    // Create a test reservation that should trigger production submission
    const testData = {
      formvalue: {
        restaurant_id: "verification-test-" + Date.now(),
        booking_date: "2024-12-31",
        booking_time: "20:00:00",
        full_name: "Production Verification User",
        email: "verification@example.com",
        mobile: "9999999999",
        pax: "2",
        age: "25-35",
        pincode: "400001",
        comments: "Verification test for production backend submission - " + new Date().toISOString()
      }
    };

    console.log('📝 Creating reservation (should auto-submit to production backend)...');
    console.log('Test Data:', JSON.stringify(testData, null, 2));

    const response = await axios.post(`${API_BASE}/reservation-form`, testData, { headers });

    console.log('\n✅ Local Reservation Response:');
    console.log('Status:', response.status);
    console.log('Data:', JSON.stringify(response.data, null, 2));

    if (response.data.status && response.data.reservation_id) {
      console.log('\n🎉 SUCCESS: Local reservation created successfully!');
      console.log('Reservation ID:', response.data.reservation_id);
      console.log('\n📤 According to the code, this should have automatically triggered:');
      console.log('1. ✅ Local database storage (confirmed)');
      console.log('2. 🔄 Production backend submission (via sendToProductionBackendAsync)');
      console.log('3. 🔄 Third-party system submission (edyne.dytel.co.in)');
      
      console.log('\n💡 To verify production submission:');
      console.log('- Check server logs for "Production backend response" messages');
      console.log('- Verify data appears at: https://bastian.ninetriangles.com/admin/backend/enquiries/');
      console.log('- Look for HTTP status codes in the logs');
      
      return true;
    } else {
      console.log('\n❌ FAILED: Local reservation creation failed');
      return false;
    }

  } catch (error) {
    console.error('\n❌ Test failed:', error.message);
    if (error.response) {
      console.error('Response status:', error.response.status);
      console.error('Response data:', error.response.data);
    }
    return false;
  }
}

async function testEatAppReservation() {
  console.log('\n🍽️ Testing EatApp Reservation (should also trigger production submission)...');

  try {
    // First get restaurants
    const restaurantsResponse = await axios.get(`${API_BASE}/eatapp-restaurants`, { headers });
    
    if (!restaurantsResponse.data.data || restaurantsResponse.data.data.length === 0) {
      console.log('❌ No restaurants available for EatApp test');
      return false;
    }

    const restaurant = restaurantsResponse.data.data[0];
    console.log('Using restaurant:', restaurant.attributes.name, '(' + restaurant.id + ')');

    // Get availability
    const tomorrow = new Date();
    tomorrow.setDate(tomorrow.getDate() + 1);
    
    const availabilityData = {
      restaurant_id: restaurant.id,
      earliest_start_time: tomorrow.toISOString().split('T')[0] + "T18:00:00",
      latest_start_time: tomorrow.toISOString().split('T')[0] + "T22:00:00",
      covers: 2
    };

    const availabilityResponse = await axios.post(`${API_BASE}/eatapp-availability`, availabilityData, { headers });
    
    if (!availabilityResponse.data.data.attributes.available.length) {
      console.log('❌ No available time slots for EatApp test');
      return false;
    }

    const selectedTime = availabilityResponse.data.data.attributes.available[0];
    console.log('Selected time:', selectedTime);

    // Create EatApp reservation
    const eatAppData = {
      restaurant_id: restaurant.id,
      covers: 2,
      start_time: selectedTime,
      first_name: "EatApp",
      last_name: "ProductionTest",
      email: "eatapp.production@example.com",
      phone: "8888888888",
      notes: "EatApp production verification test - " + new Date().toISOString(),
      referrer_tag: "concierge",
      terms_and_conditions_accepted: true,
      marketing_accepted: true
    };

    const eatAppResponse = await axios.post(`${API_BASE}/eatapp-reservations`, eatAppData, { headers });

    if (eatAppResponse.status === 201) {
      console.log('✅ EatApp reservation created successfully');
      console.log('Reservation ID:', eatAppResponse.data.data.id);
      console.log('\n📤 This should have also triggered production backend submission');
      return true;
    } else {
      console.log('❌ EatApp reservation failed');
      return false;
    }

  } catch (error) {
    console.error('EatApp test error:', error.message);
    return false;
  }
}

async function runVerification() {
  console.log('🚀 Production Backend Submission Verification\n');
  console.log('This script tests the automatic production backend submission functionality.\n');

  const results = [];

  // Test 1: Regular reservation form
  console.log('='.repeat(60));
  const test1 = await testReservationWithProductionSubmission();
  results.push({ test: 'Regular Reservation Form', passed: test1 });

  // Test 2: EatApp reservation
  console.log('\n' + '='.repeat(60));
  const test2 = await testEatAppReservation();
  results.push({ test: 'EatApp Reservation', passed: test2 });

  // Summary
  console.log('\n' + '='.repeat(60));
  console.log('📊 VERIFICATION SUMMARY');
  console.log('='.repeat(60));

  results.forEach(result => {
    console.log(`${result.passed ? '✅' : '❌'} ${result.test}: ${result.passed ? 'PASSED' : 'FAILED'}`);
  });

  const passedTests = results.filter(r => r.passed).length;
  console.log(`\n🎯 Overall: ${passedTests}/${results.length} tests passed`);

  if (passedTests === results.length) {
    console.log('\n🎉 All tests passed! The reservation system should be submitting data to:');
    console.log('1. ✅ Local database (confirmed)');
    console.log('2. ✅ EatApp sandbox (confirmed)');
    console.log('3. 🔄 Production backend (automatic via sendToProductionBackendAsync)');
    console.log('\n💡 Next steps:');
    console.log('- Check server logs for production submission confirmations');
    console.log('- Verify data appears at: https://bastian.ninetriangles.com/admin/backend/enquiries/');
    console.log('- Monitor for any error messages in the logs');
  } else {
    console.log('\n⚠️ Some tests failed. Please check the error messages above.');
  }

  console.log('\n📝 Note: The production backend submission happens asynchronously,');
  console.log('so check the server logs for detailed submission results.');
}

// Run verification
runVerification();
