#!/usr/bin/env node

// Direct test of production backend submission
const axios = require('axios');

async function testProductionBackendDirect() {
  console.log('🧪 Direct Test of Production Backend Submission\n');
  
  const productionUrl = 'https://bastian.ninetriangles.com/admin/api/reservation-form';
  
  const testData = {
    formvalue: {
      restaurant_id: 'DIRECT-TEST-' + Date.now(),
      booking_date: '2024-12-31',
      booking_time: '20:30:00',
      full_name: 'Direct Production Test User',
      email: 'direct.production@example.com',
      mobile: '8888888888',
      pax: '3',
      age: '25-35',
      pincode: '400001',
      comments: 'Direct test to production backend - ' + new Date().toISOString()
    }
  };

  console.log('🎯 Target URL:', productionUrl);
  console.log('📤 Sending data:', JSON.stringify(testData, null, 2));
  console.log('\n⏳ Making request...\n');

  try {
    const response = await axios.post(productionUrl, testData, {
      headers: {
        'Authorization': '123456789',
        'Content-Type': 'application/json'
      },
      timeout: 30000
    });

    console.log('✅ SUCCESS! Production backend responded:');
    console.log('Status:', response.status);
    console.log('Response:', JSON.stringify(response.data, null, 2));
    
    if (response.data.status) {
      console.log('\n🎉 Data successfully saved to production backend!');
      console.log('🔗 Check here: https://bastian.ninetriangles.com/admin/backend/enquiries/');
      
      if (response.data.reservation_id) {
        console.log('📝 Production Reservation ID:', response.data.reservation_id);
      }
    } else {
      console.log('\n⚠️ Production backend returned success=false');
      console.log('Message:', response.data.message);
    }

  } catch (error) {
    console.log('❌ FAILED to reach production backend:');
    console.log('Error:', error.message);
    
    if (error.response) {
      console.log('Status:', error.response.status);
      console.log('Response:', error.response.data);
    } else if (error.request) {
      console.log('No response received - possible network/connectivity issue');
    }
    
    console.log('\n🔍 Possible issues:');
    console.log('1. Network connectivity to bastian.ninetriangles.com');
    console.log('2. Production server is down');
    console.log('3. API endpoint has changed');
    console.log('4. API key is incorrect');
    console.log('5. Firewall blocking outbound requests');
  }
}

async function testLocalThenProduction() {
  console.log('🚀 Testing Local → Production Flow\n');
  
  // First test local submission (which should trigger production)
  console.log('1️⃣ Testing local reservation form...');
  
  try {
    const localResponse = await axios.post('http://localhost/bastian-admin/api/reservation-form', {
      formvalue: {
        restaurant_id: 'LOCAL-TO-PROD-' + Date.now(),
        booking_date: '2024-12-31',
        booking_time: '21:00:00',
        full_name: 'Local to Production Test',
        email: 'local.to.prod@example.com',
        mobile: '7777777777',
        pax: '2',
        age: '25-35',
        pincode: '400001',
        comments: 'Testing local form that should trigger production submission'
      }
    }, {
      headers: {
        'Authorization': '123456789',
        'Content-Type': 'application/json'
      }
    });

    console.log('✅ Local reservation created:', localResponse.data);
    console.log('📝 Local Reservation ID:', localResponse.data.reservation_id);
    console.log('🔄 This should have automatically triggered production submission\n');
    
  } catch (error) {
    console.log('❌ Local test failed:', error.message);
  }
  
  // Then test direct production
  console.log('2️⃣ Testing direct production backend...');
  await testProductionBackendDirect();
}

// Run the tests
testLocalThenProduction();
