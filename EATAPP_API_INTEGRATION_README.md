# EatApp API Integration - Complete Documentation

## Overview

This document provides a comprehensive guide to the EatApp API integration implemented in the Bastian restaurant reservation system. The integration serves as a secure proxy between the frontend application and the EatApp API, ensuring data security, implementing caching mechanisms, and providing a robust reservation system.

## Table of Contents

1. [Architecture Overview](#architecture-overview)
2. [Authentication & Security](#authentication--security)
3. [API Endpoints](#api-endpoints)
4. [Data Flow & Processes](#data-flow--processes)
5. [Caching Mechanism](#caching-mechanism)
6. [Payment Integration](#payment-integration)
7. [Error Handling](#error-handling)
8. [Database Schema](#database-schema)
9. [Configuration](#configuration)
10. [Troubleshooting](#troubleshooting)

## Architecture Overview

The EatApp integration follows a **secure proxy pattern** with the following key components:

```
Frontend App → Bastian API → EatApp API
                ↓
            Local Database (Cache + Reservations)
```

### Key Design Principles

1. **Security First**: API credentials are never exposed to the frontend
2. **Database-First Reservations**: All reservations are stored locally before sending to EatApp
3. **Intelligent Caching**: Availability data is cached to reduce API calls
4. **Graceful Degradation**: System continues to work even if EatApp API is down
5. **Comprehensive Logging**: All operations are logged for debugging

## Authentication & Security

### API Key Authentication
- **Frontend → Bastian API**: Uses a simple API key (`123456789`)
- **Bastian API → EatApp API**: Uses Bearer token authentication

### CORS Configuration
```php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Request-Type, X-Client-Version, X-Platform');
```

### EatApp API Credentials (Hidden from Frontend)
```php
$this->eatapp_api_url = 'https://api.eat-sandbox.co/concierge/v2';
$this->eatapp_auth_key = 'Bearer [TOKEN]';
$this->eatapp_group_id = '4bcc6bdd-765b-4486-83ab-17c175dc3910';
```

## API Endpoints

### 1. Get Restaurants (`/restaurants`)

**Purpose**: Fetch real-time restaurant list from EatApp API

**Method**: `GET`

**Headers Required**:
```
Authorization: 123456789
```

**Response Structure**:
```json
{
  "status": true,
  "data": {
    "data": [
      {
        "id": "restaurant_id",
        "type": "restaurant",
        "attributes": {
          "name": "Restaurant Name",
          "available_online": true,
          "address_line_1": "Restaurant Address",
          "created_at": "2024-01-01T00:00:00Z",
          "updated_at": "2024-01-01T00:00:00Z"
        }
      }
    ],
    "meta": {
      "total_count": 10,
      "current_page": 1,
      "total_pages": 1
    }
  }
}
```

**Process Flow**:
1. Validate API key
2. Make direct request to EatApp API
3. Return response without modification
4. No caching (always fresh data)

### 2. Check Availability (`/availability`)

**Purpose**: Check available time slots for a restaurant

**Method**: `POST`

**Headers Required**:
```
Authorization: 123456789
Content-Type: application/json
```

**Request Body**:
```json
{
  "restaurant_id": "restaurant_uuid",
  "earliest_start_time": "2024-01-15T18:00:00Z",
  "latest_start_time": "2024-01-15T22:00:00Z",
  "covers": 4
}
```

**Response Structure**:
```json
{
  "status": true,
  "data": {
    "data": [
      {
        "id": "slot_id",
        "type": "availability_slot",
        "attributes": {
          "start_time": "2024-01-15T19:00:00Z",
          "end_time": "2024-01-15T21:00:00Z",
          "available": true
        }
      }
    ]
  },
  "cached": false
}
```

**Process Flow**:
1. Validate required fields
2. Check cache for existing availability data
3. If cached data exists and is fresh (15 minutes), return cached data
4. If cache miss, fetch from EatApp API
5. Cache the response for 15 minutes
6. Return availability data

### 3. Create Reservation (`/create_reservation`)

**Purpose**: Create a new restaurant reservation

**Method**: `POST`

**Headers Required**:
```
Authorization: 123456789
Content-Type: application/json
```

**Request Body**:
```json
{
  "restaurant_id": "restaurant_uuid",
  "covers": 4,
  "start_time": "2024-01-15T19:00:00Z",
  "first_name": "John",
  "last_name": "Doe",
  "email": "john@example.com",
  "phone": "+1234567890",
  "notes": "Window seat preferred"
}
```

**Response Structure**:
```json
{
  "status": true,
  "data": {
    "data": {
      "id": "reservation_id",
      "type": "reservation",
      "attributes": {
        "key": "reservation_key",
        "status": "confirmed",
        "start_time": "2024-01-15T19:00:00Z",
        "covers": 4
      }
    },
    "included": [
      {
        "type": "payment",
        "attributes": {
          "payment_widget_url": "https://payment.eatapp.co/widget/...",
          "amount": 20.00,
          "currency": "USD"
        }
      }
    ]
  },
  "message": "Reservation created successfully",
  "local_id": 123,
  "payment_url": "https://payment.eatapp.co/widget/...",
  "payment_required": true,
  "payment_amount": 20.00
}
```

**Process Flow**:
1. Validate all required fields
2. **Store reservation in local database first** (ensures data is never lost)
3. Attempt to create payment object (optional, doesn't fail if it doesn't work)
4. Send reservation to EatApp API
5. Update local database with EatApp response
6. Extract payment URL from response
7. Return comprehensive response with payment information

### 4. Get Reservations (Admin Only) (`/get_reservations`)

**Purpose**: Retrieve recent reservations from local database for debugging

**Method**: `GET`

**Headers Required**:
```
Authorization: 123456789
```

**Response Structure**:
```json
{
  "status": true,
  "data": [
    {
      "id": 123,
      "restaurant_id": "restaurant_uuid",
      "covers": 4,
      "start_time": "2024-01-15T19:00:00Z",
      "first_name": "John",
      "last_name": "Doe",
      "email": "john@example.com",
      "phone": "+1234567890",
      "notes": "Window seat preferred",
      "status": "confirmed",
      "eatapp_reservation_key": "reservation_key",
      "created_at": "2024-01-15T10:00:00Z",
      "updated_at": "2024-01-15T10:01:00Z"
    }
  ],
  "count": 10
}
```

## Data Flow & Processes

### Restaurant Data Flow
```
1. Frontend requests restaurants
2. Bastian API validates API key
3. Bastian API calls EatApp API directly
4. EatApp API returns restaurant list
5. Bastian API returns data to frontend
```

### Availability Data Flow
```
1. Frontend requests availability
2. Bastian API checks local cache
3. If cached data exists and is fresh → return cached data
4. If cache miss → call EatApp API
5. Cache EatApp response for 15 minutes
6. Return availability data to frontend
```

### Reservation Data Flow
```
1. Frontend sends reservation request
2. Bastian API validates all required fields
3. Bastian API stores reservation in local database (status: pending)
4. Bastian API attempts to create payment object
5. Bastian API sends reservation to EatApp API
6. If EatApp succeeds:
   - Update local database with EatApp response (status: confirmed)
   - Extract payment URL from response
   - Return success with payment information
7. If EatApp fails:
   - Update local database with failure status (status: failed)
   - Return error but keep local reservation for manual processing
```

## Caching Mechanism

### Availability Caching
- **Cache Duration**: 15 minutes
- **Cache Key**: `restaurant_id + date + covers`
- **Storage**: Database table `eatapp_availability`

### Cache Structure
```sql
CREATE TABLE eatapp_availability (
    id INT PRIMARY KEY AUTO_INCREMENT,
    restaurant_id VARCHAR(255),
    date DATE,
    covers INT,
    available_slots JSON,
    cached_at DATETIME,
    expires_at DATETIME
);
```

### Cache Logic
```php
// Check cache first
$cached_availability = $this->get_cached_availability($restaurant_id, $date, $covers);

if($cached_availability) {
    // Return cached data
    return $cached_availability;
} else {
    // Fetch from EatApp and cache
    $availability_data = fetch_from_eatapp();
    $this->cache_availability($restaurant_id, $date, $covers, $availability_data);
    return $availability_data;
}
```

## Payment Integration

### Payment Detection
The system automatically detects if payment is required by analyzing the EatApp API response:

1. **Payment Widget URL Extraction**: Searches for `payment_widget_url` in the response
2. **Payment Amount Detection**: Looks for payment amount in the response
3. **Payment Required Flag**: Determines if payment is mandatory

### Payment URL Extraction Process
```php
private function extract_payment_url($responseData) {
    // 1. Check included payments array (primary location)
    if(isset($responseData['included'])) {
        foreach($responseData['included'] as $included) {
            if($included['type'] === 'payment' && isset($included['attributes']['payment_widget_url'])) {
                return $included['attributes']['payment_widget_url'];
            }
        }
    }
    
    // 2. Check relationships (fallback)
    if(isset($responseData['data']['relationships']['payments']['data']['attributes']['payment_widget_url'])) {
        return $responseData['data']['relationships']['payments']['data']['attributes']['payment_widget_url'];
    }
    
    // 3. Check data attributes (fallback)
    if(isset($responseData['data']['attributes']['payment_widget_url'])) {
        return $responseData['data']['attributes']['payment_widget_url'];
    }
    
    // 4. Recursive search through entire response
    return $this->search_recursive_for_payment_url($responseData);
}
```

### Payment Object Creation
```php
private function create_payment_object($amount = 20.00, $currency = 'USD') {
    $url = $this->eatapp_api_url . '/payments';
    
    $postData = array(
        'amount' => $amount,
        'currency' => $currency,
        'description' => "A pre-payment for $amount $currency is required",
        'gateway' => 'stripe'
    );
    
    $response = $this->make_curl_request($url, 'POST', $postData);
    
    if($response['success']) {
        $paymentData = json_decode($response['data'], true);
        return $paymentData['data']['id'] ?? null;
    }
    
    return null;
}
```

### Payment Response Structure
When payment is required, the response includes:
```json
{
  "status": true,
  "data": { /* EatApp response */ },
  "payment_url": "https://payment.eatapp.co/widget/...",
  "payment_required": true,
  "payment_amount": 20.00
}
```

## Error Handling

### HTTP Status Codes
- `200`: Success
- `201`: Reservation created successfully
- `400`: Bad request (missing required fields)
- `401`: Unauthorized (invalid API key)
- `422`: Validation errors
- `500`: Internal server error

### Error Response Structure
```json
{
  "status": false,
  "message": "Error description",
  "error": "Detailed error message",
  "http_code": 500,
  "validations": {
    "field_name": ["validation error message"]
  }
}
```

### Graceful Degradation
- **EatApp API Down**: Reservations are still saved locally
- **Payment Creation Fails**: Reservation continues without payment
- **Cache Miss**: Falls back to real-time API call
- **Database Errors**: Logged for debugging

## Database Schema

### Reservations Table
```sql
CREATE TABLE eatapp_reservations (
    id INT PRIMARY KEY AUTO_INCREMENT,
    restaurant_id VARCHAR(255) NOT NULL,
    covers INT NOT NULL,
    start_time DATETIME NOT NULL,
    first_name VARCHAR(255) NOT NULL,
    last_name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    phone VARCHAR(50) NOT NULL,
    notes TEXT,
    status ENUM('pending', 'confirmed', 'failed') DEFAULT 'pending',
    eatapp_reservation_key VARCHAR(255),
    eatapp_response JSON,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
```

### Availability Cache Table
```sql
CREATE TABLE eatapp_availability (
    id INT PRIMARY KEY AUTO_INCREMENT,
    restaurant_id VARCHAR(255) NOT NULL,
    date DATE NOT NULL,
    covers INT NOT NULL,
    available_slots JSON NOT NULL,
    cached_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    expires_at DATETIME NOT NULL,
    INDEX idx_restaurant_date_covers (restaurant_id, date, covers),
    INDEX idx_expires_at (expires_at)
);
```

### Restaurants Table (Deprecated)
```sql
CREATE TABLE eatapp_restaurants (
    id INT PRIMARY KEY AUTO_INCREMENT,
    eatapp_id VARCHAR(255) UNIQUE NOT NULL,
    name VARCHAR(255) NOT NULL,
    address TEXT,
    status ENUM('active', 'inactive') DEFAULT 'active',
    eatapp_data JSON,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
```

## Configuration

### Environment Variables
```php
// EatApp API Configuration
$this->eatapp_api_url = 'https://api.eat-sandbox.co/concierge/v2';
$this->eatapp_auth_key = 'Bearer [YOUR_BEARER_TOKEN]';
$this->eatapp_group_id = '[YOUR_GROUP_ID]';

// Bastian API Configuration
$this->apikey = '123456789'; // Change this in production

// Cache Configuration
$cache_duration = 15; // minutes
```

### API Headers
```php
$this->api_headers = array(
    'Authorization: ' . $this->eatapp_auth_key,
    'X-Group-ID: ' . $this->eatapp_group_id,
    'Accept: application/json',
    'Content-Type: application/json'
);
```

## Troubleshooting

### Common Issues

#### 1. Authentication Errors
**Symptoms**: 401 Unauthorized responses
**Solutions**:
- Verify API key in request headers
- Check EatApp Bearer token validity
- Ensure Group ID is correct

#### 2. Missing Payment URLs
**Symptoms**: Payment required but no payment URL in response
**Solutions**:
- Check EatApp API response structure
- Verify payment object creation
- Review recursive payment URL search logic

#### 3. Cache Issues
**Symptoms**: Stale availability data
**Solutions**:
- Check cache expiration times
- Verify database connectivity
- Review cache key generation

#### 4. Reservation Failures
**Symptoms**: Reservations saved locally but not in EatApp
**Solutions**:
- Check EatApp API status
- Review reservation data format
- Verify restaurant ID validity

### Debug Endpoints

#### Get Recent Reservations
```
GET /get_reservations
Headers: Authorization: 123456789
```
Returns last 10 reservations for debugging.

#### Check API Status
```php
// Add to any endpoint for debugging
error_log("API Request: " . json_encode($request_data));
error_log("API Response: " . json_encode($response_data));
```

### Log Analysis
All operations are logged with:
- Request data
- Response data
- Error messages
- Database operations
- Cache hits/misses

Check PHP error logs for detailed debugging information.

## Security Considerations

1. **API Key Protection**: Never expose EatApp credentials to frontend
2. **Input Validation**: All user inputs are validated
3. **SQL Injection Prevention**: Using CodeIgniter's query builder
4. **CORS Configuration**: Properly configured for cross-origin requests
5. **Error Information**: Limited error details exposed to frontend

## Performance Optimization

1. **Caching**: 15-minute availability cache reduces API calls
2. **Database Indexing**: Proper indexes on frequently queried fields
3. **Connection Pooling**: Efficient database connections
4. **Response Compression**: JSON responses are optimized
5. **Background Processing**: Non-critical operations don't block responses

## Future Enhancements

1. **Webhook Integration**: Real-time updates from EatApp
2. **Advanced Caching**: Redis-based caching for better performance
3. **Retry Logic**: Automatic retry for failed API calls
4. **Rate Limiting**: Protect against API abuse
5. **Analytics**: Track API usage and performance metrics

---

**Last Updated**: January 2024
**Version**: 1.0
**Maintainer**: Bastian Development Team 