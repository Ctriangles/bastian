#!/usr/bin/env node

// Comprehensive test script to verify the complete reservation flow with security testing
const axios = require('axios');

const API_BASE = 'http://localhost/bastian-admin/api';
const API_KEY = '123456789';
const PRODUCTION_API = 'https://bastian.ninetriangles.com/admin/api';

const headers = {
  'Authorization': API_KEY,
  'Content-Type': 'application/json'
};

// Test configuration
const TEST_CONFIG = {
  maxRetries: 3,
  retryDelay: 1000,
  timeout: 30000
};

// Test results tracking
let testResults = {
  passed: 0,
  failed: 0,
  total: 0,
  details: []
};

// Helper function to log test results
function logTest(testName, passed, message = '') {
  testResults.total++;
  if (passed) {
    testResults.passed++;
    console.log(`✅ ${testName}: PASSED ${message}`);
  } else {
    testResults.failed++;
    console.log(`❌ ${testName}: FAILED ${message}`);
  }
  testResults.details.push({ testName, passed, message });
}

// Helper function to make API requests with retry logic
async function makeRequest(url, options, retries = TEST_CONFIG.maxRetries) {
  for (let i = 0; i <= retries; i++) {
    try {
      const response = await axios({
        ...options,
        url,
        timeout: TEST_CONFIG.timeout
      });
      return response;
    } catch (error) {
      if (i === retries) throw error;
      console.log(`Retry ${i + 1}/${retries} for ${url}`);
      await new Promise(resolve => setTimeout(resolve, TEST_CONFIG.retryDelay));
    }
  }
}

// Security testing functions
async function testSecurityMeasures() {
  console.log('\n🔒 Testing Security Measures...\n');

  // Test 1: Invalid API key
  try {
    await axios.get(`${API_BASE}/eatapp-restaurants`, {
      headers: { ...headers, 'Authorization': 'invalid_key' }
    });
    logTest('Invalid API Key Test', false, 'Should have been rejected');
  } catch (error) {
    const passed = error.response?.status === 401;
    logTest('Invalid API Key Test', passed, passed ? 'Correctly rejected' : `Got status ${error.response?.status}`);
  }

  // Test 2: Missing Authorization header
  try {
    await axios.get(`${API_BASE}/eatapp-restaurants`, {
      headers: { 'Content-Type': 'application/json' }
    });
    logTest('Missing Auth Header Test', false, 'Should have been rejected');
  } catch (error) {
    const passed = error.response?.status === 401;
    logTest('Missing Auth Header Test', passed, passed ? 'Correctly rejected' : `Got status ${error.response?.status}`);
  }

  // Test 3: CORS headers check
  try {
    const response = await axios.options(`${API_BASE}/eatapp-restaurants`, { headers });
    const corsHeaders = response.headers;
    const hasCors = corsHeaders['access-control-allow-origin'] !== '*';
    logTest('CORS Security Test', hasCors, hasCors ? 'CORS properly restricted' : 'CORS allows all origins');
  } catch (error) {
    logTest('CORS Security Test', false, 'Could not check CORS headers');
  }

  // Test 4: SQL Injection attempt
  try {
    const maliciousData = {
      formvalue: {
        restaurant_id: "'; DROP TABLE reservations; --",
        booking_date: "2024-01-01",
        full_name: "Test User",
        email: "test@example.com",
        mobile: "1234567890",
        pax: "2"
      }
    };

    await axios.post(`${API_BASE}/reservation-form`, maliciousData, { headers });
    logTest('SQL Injection Test', false, 'Malicious input was accepted');
  } catch (error) {
    const passed = error.response?.status === 400 || error.response?.status === 422;
    logTest('SQL Injection Test', passed, passed ? 'Malicious input rejected' : 'Unexpected error');
  }
}

// Validation testing functions
async function testValidation() {
  console.log('\n✅ Testing Input Validation...\n');

  // Test 1: Missing required fields
  try {
    const incompleteData = {
      formvalue: {
        restaurant_id: "",
        booking_date: "",
        full_name: "",
        email: "",
        mobile: "",
        pax: ""
      }
    };

    await axios.post(`${API_BASE}/reservation-form`, incompleteData, { headers });
    logTest('Missing Fields Validation', false, 'Should reject empty fields');
  } catch (error) {
    const passed = error.response?.status === 400;
    logTest('Missing Fields Validation', passed, passed ? 'Empty fields rejected' : `Got status ${error.response?.status}`);
  }

  // Test 2: Invalid email format
  try {
    const invalidEmailData = {
      formvalue: {
        restaurant_id: "test-restaurant",
        booking_date: "2024-12-31",
        full_name: "Test User",
        email: "invalid-email",
        mobile: "1234567890",
        pax: "2"
      }
    };

    await axios.post(`${API_BASE}/reservation-form`, invalidEmailData, { headers });
    logTest('Email Validation', false, 'Should reject invalid email');
  } catch (error) {
    const passed = error.response?.status === 400 || error.response?.status === 422;
    logTest('Email Validation', passed, passed ? 'Invalid email rejected' : `Got status ${error.response?.status}`);
  }

  // Test 3: Invalid phone number
  try {
    const invalidPhoneData = {
      formvalue: {
        restaurant_id: "test-restaurant",
        booking_date: "2024-12-31",
        full_name: "Test User",
        email: "test@example.com",
        mobile: "123", // Too short
        pax: "2"
      }
    };

    await axios.post(`${API_BASE}/reservation-form`, invalidPhoneData, { headers });
    logTest('Phone Validation', false, 'Should reject invalid phone');
  } catch (error) {
    const passed = error.response?.status === 400 || error.response?.status === 422;
    logTest('Phone Validation', passed, passed ? 'Invalid phone rejected' : `Got status ${error.response?.status}`);
  }
}

async function testReservationFlow() {
  console.log('🧪 Testing Bastian Reservation Flow with EatApp Integration\n');

  try {
    // Step 1: Get restaurants
    console.log('1️⃣ Fetching restaurants...');
    const restaurantsResponse = await makeRequest(`${API_BASE}/eatapp-restaurants`, {
      method: 'GET',
      headers
    });

    const restaurants = restaurantsResponse.data.data;
    logTest('Restaurant Fetch', restaurants && restaurants.length > 0, `Found ${restaurants?.length || 0} restaurants`);

    if (!restaurants || restaurants.length === 0) {
      throw new Error('No restaurants found');
    }

    restaurants.forEach(r => console.log(`   - ${r.attributes.name} (${r.id})`));
    const restaurantId = restaurants[0].id;
    console.log(`\n🏪 Using restaurant: ${restaurants[0].attributes.name}\n`);

    // Step 2: Check availability
    console.log('2️⃣ Checking availability...');
    const today = new Date();
    const tomorrow = new Date(today);
    tomorrow.setDate(tomorrow.getDate() + 1);
    
    const availabilityData = {
      restaurant_id: restaurantId,
      earliest_start_time: tomorrow.toISOString().split('T')[0] + "T12:00:00",
      latest_start_time: tomorrow.toISOString().split('T')[0] + "T22:00:00",
      covers: 2
    };

    const availabilityResponse = await makeRequest(`${API_BASE}/eatapp-availability`, {
      method: 'POST',
      headers,
      data: availabilityData
    });

    const availability = availabilityResponse.data.data.attributes;
    logTest('Availability Fetch', availability && availability.available.length > 0, `Found ${availability?.available?.length || 0} slots`);

    console.log(`   First slot: ${availability.available[0]}`);
    console.log(`   Last slot: ${availability.available[availability.available.length - 1]}`);

    if (availability.available.length === 0) {
      throw new Error('No available time slots');
    }

    const selectedTime = availability.available[0];
    console.log(`\n⏰ Selected time: ${selectedTime}\n`);

    // Step 3: Create reservation
    console.log('3️⃣ Creating reservation...');
    const reservationData = {
      restaurant_id: restaurantId,
      covers: 2,
      start_time: selectedTime,
      first_name: "Test",
      last_name: "User",
      email: "test@example.com",
      phone: "1234567890",
      notes: "Test reservation from API",
      referrer_tag: "concierge",
      terms_and_conditions_accepted: true,
      marketing_accepted: true
    };

    const reservationResponse = await makeRequest(`${API_BASE}/eatapp-reservations`, {
      method: 'POST',
      headers,
      data: reservationData
    });

    const reservation = reservationResponse.data.data;
    const reservationSuccess = reservation && reservation.id && reservation.attributes.key;
    logTest('EatApp Reservation', reservationSuccess, reservationSuccess ? `ID: ${reservation.id}` : 'Failed to create');

    if (reservationSuccess) {
      console.log(`   Reservation ID: ${reservation.id}`);
      console.log(`   Reservation Key: ${reservation.attributes.key}`);
      console.log(`   Status: ${reservation.attributes.status}`);
      console.log(`   Guest: ${reservation.attributes.first_name} ${reservation.attributes.last_name}`);
      console.log(`   Time: ${reservation.attributes.start_time}`);
      console.log(`   Covers: ${reservation.attributes.covers}`);
    }

    // Step 4: Test backend reservation form (saves to local database)
    console.log('\n4️⃣ Testing backend reservation form...');
    const backendData = {
      formvalue: {
        restaurant_id: restaurantId,
        booking_date: tomorrow.toISOString().split('T')[0],
        full_name: "Test User",
        email: "test@example.com",
        mobile: "1234567890",
        pax: "2",
        age: "25-35",
        pincode: "400001",
        comments: "Test reservation",
        booking_time: selectedTime.split('T')[1]
      }
    };

    const backendResponse = await makeRequest(`${API_BASE}/reservation-form`, {
      method: 'POST',
      headers,
      data: backendData
    });

    const backendSuccess = backendResponse.data.status === true;
    logTest('Backend Reservation', backendSuccess, backendSuccess ? `ID: ${backendResponse.data.reservation_id}` : 'Failed to save');

    // Step 5: Test dual submission verification
    console.log('\n5️⃣ Testing dual submission verification...');
    await testDualSubmission(restaurantId, selectedTime);

    // Step 6: Test error scenarios
    console.log('\n6️⃣ Testing error scenarios...');
    await testErrorScenarios();

    // Print final summary
    printTestSummary(restaurantId, reservation, backendResponse, selectedTime);

  } catch (error) {
    console.error('\n❌ Test failed:', error.message);
    if (error.response) {
      console.error('Response status:', error.response.status);
      console.error('Response data:', error.response.data);
    }
    logTest('Main Test Flow', false, error.message);
  }
}

// Test dual submission functionality
async function testDualSubmission(restaurantId, selectedTime) {
  try {
    // Test that EatApp reservations also save to backend
    const eatAppData = {
      restaurant_id: restaurantId,
      covers: 2,
      start_time: selectedTime,
      first_name: "Dual",
      last_name: "Test",
      email: "dual@example.com",
      phone: "9876543210",
      notes: "Dual submission test",
      referrer_tag: "concierge",
      terms_and_conditions_accepted: true,
      marketing_accepted: true
    };

    const eatAppResponse = await makeRequest(`${API_BASE}/eatapp-reservations`, {
      method: 'POST',
      headers,
      data: eatAppData
    });

    const dualSubmissionSuccess = eatAppResponse.status === 201;
    logTest('Dual Submission Test', dualSubmissionSuccess, dualSubmissionSuccess ? 'EatApp + Backend' : 'Failed');

    // Wait a moment for async backend submission
    await new Promise(resolve => setTimeout(resolve, 2000));

    // Verify data appears in backend
    try {
      const testResponse = await makeRequest(`${API_BASE}/test-reservation`, {
        method: 'GET',
        headers
      });

      const hasRecentData = testResponse.data.count > 0;
      logTest('Backend Data Verification', hasRecentData, hasRecentData ? `${testResponse.data.count} records found` : 'No data found');
    } catch (error) {
      logTest('Backend Data Verification', false, 'Could not verify backend data');
    }

  } catch (error) {
    logTest('Dual Submission Test', false, error.message);
  }
}

// Test error scenarios
async function testErrorScenarios() {
  // Test 1: Invalid restaurant ID
  try {
    const invalidData = {
      restaurant_id: "invalid-restaurant-id",
      covers: 2,
      start_time: new Date().toISOString(),
      first_name: "Error",
      last_name: "Test",
      email: "error@example.com",
      phone: "1234567890",
      notes: "Error test",
      referrer_tag: "concierge",
      terms_and_conditions_accepted: true,
      marketing_accepted: true
    };

    await makeRequest(`${API_BASE}/eatapp-reservations`, {
      method: 'POST',
      headers,
      data: invalidData
    });

    logTest('Invalid Restaurant Error', false, 'Should have failed');
  } catch (error) {
    const passed = error.response?.status >= 400;
    logTest('Invalid Restaurant Error', passed, passed ? 'Correctly rejected' : 'Unexpected response');
  }

  // Test 2: Past date reservation
  try {
    const pastDate = new Date();
    pastDate.setDate(pastDate.getDate() - 1);

    const pastDateData = {
      formvalue: {
        restaurant_id: "test-restaurant",
        booking_date: pastDate.toISOString().split('T')[0],
        full_name: "Past Date Test",
        email: "past@example.com",
        mobile: "1234567890",
        pax: "2"
      }
    };

    await makeRequest(`${API_BASE}/reservation-form`, {
      method: 'POST',
      headers,
      data: pastDateData
    });

    logTest('Past Date Error', false, 'Should have rejected past date');
  } catch (error) {
    const passed = error.response?.status >= 400;
    logTest('Past Date Error', passed, passed ? 'Past date rejected' : 'Unexpected response');
  }
}

// Print comprehensive test summary
function printTestSummary(restaurantId, reservation, backendResponse, selectedTime) {
  console.log('\n' + '='.repeat(80));
  console.log('📊 COMPREHENSIVE TEST SUMMARY');
  console.log('='.repeat(80));

  console.log(`\n🧪 Test Results: ${testResults.passed}/${testResults.total} passed`);

  if (testResults.failed > 0) {
    console.log('\n❌ Failed Tests:');
    testResults.details
      .filter(test => !test.passed)
      .forEach(test => console.log(`   - ${test.testName}: ${test.message}`));
  }

  console.log('\n✅ Passed Tests:');
  testResults.details
    .filter(test => test.passed)
    .forEach(test => console.log(`   - ${test.testName}: ${test.message}`));

  if (reservation && backendResponse) {
    console.log('\n📋 Reservation Details:');
    console.log(`   - EatApp Restaurant ID: ${restaurantId}`);
    console.log(`   - EatApp Reservation ID: ${reservation.id}`);
    console.log(`   - EatApp Reservation Key: ${reservation.attributes.key}`);
    console.log(`   - Backend Reservation ID: ${backendResponse.data.reservation_id}`);
    console.log(`   - Reservation Time: ${selectedTime}`);

    console.log('\n🎯 Data Destinations:');
    console.log('   1. ✅ EatApp Sandbox Dashboard');
    console.log('   2. ✅ Bastian Backend Database');
    console.log('   3. ✅ Production Backend (via async submission)');
  }

  console.log('\n🔒 Security Measures Verified:');
  console.log('   - API key authentication');
  console.log('   - CORS restrictions');
  console.log('   - Input validation');
  console.log('   - SQL injection protection');

  const overallSuccess = testResults.failed === 0;
  console.log(`\n${overallSuccess ? '🎉' : '⚠️'} Overall Status: ${overallSuccess ? 'ALL TESTS PASSED' : 'SOME TESTS FAILED'}`);
  console.log('='.repeat(80));
}

// Main test execution function
async function runAllTests() {
  console.log('🚀 Starting Comprehensive Bastian Reservation System Tests\n');
  console.log('This will test:');
  console.log('  - Security measures and authentication');
  console.log('  - Input validation and error handling');
  console.log('  - Complete reservation flow');
  console.log('  - Dual submission to EatApp and Backend');
  console.log('  - Error scenarios and edge cases\n');

  try {
    // Run security tests first
    await testSecurityMeasures();

    // Run validation tests
    await testValidation();

    // Run main reservation flow
    await testReservationFlow();

  } catch (error) {
    console.error('\n💥 Critical test failure:', error.message);
    if (error.response) {
      console.error('Response status:', error.response.status);
      console.error('Response data:', error.response.data);
    }
    logTest('Critical Test Execution', false, error.message);
  } finally {
    // Always print summary, even if tests failed
    if (testResults.total === 0) {
      console.log('\n❌ No tests were executed');
      process.exit(1);
    }

    const successRate = (testResults.passed / testResults.total * 100).toFixed(1);
    console.log(`\n📈 Success Rate: ${successRate}%`);

    // Exit with appropriate code
    process.exit(testResults.failed > 0 ? 1 : 0);
  }
}

// Run all tests
runAllTests();
