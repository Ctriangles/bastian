# Postman Setup Guide for EatApp API Testing

## Quick Setup Instructions

### 1. Import the Collection
1. Open Postman
2. Click "Import" button
3. Import the file: `EatApp_API_Postman_Collection.json`
4. The collection will be imported with all your actual API keys

### 2. Set Your Base URL
The collection uses environment variables. You need to set your actual base URL:

**For XAMPP (your current setup):**
```
http://localhost/bastian_parent/bastian/admin/index.php/api/eatapp_controller
```

**To set this:**
1. Click on the collection name "EatApp API Integration Tests"
2. Go to "Variables" tab
3. Update the `base_url` variable with your actual URL
4. Click "Save"

### 3. Your Actual API Configuration

Based on your code, here are your actual API keys:

#### Bastian API Key (for frontend → Bastian API)
```
API Key: 123456789
```

#### EatApp API Configuration (hidden from frontend)
```
EatApp API URL: https://api.eat-sandbox.co/concierge/v2
EatApp Bearer Token: eyJhbGciOiJIUzI1NiJ9.eyJleHAiOjE4OTIwNzM2MDAsImlhdCI6MTc0NTgxOTQ0NSwiaWQiOiJkOWZkNTI0Mi04YmQzLTQ1NDYtODNlNy1jZjU1NzY5MDI0MTIiLCJtb2RlbCI6IkNvbmNpZXJnZSIsImp0aSI6IjFkYWU1ZjYyOWM3M2VmOTU3M2U0IiwiYnkiOiJhbGlAZWF0YXBwLmNvIn0.ZCEiRP1gqPNvJEFYDVCk1uA6o0MSD2pzXu88eGh8xt0
Group ID: 4bcc6bdd-765b-4486-83ab-17c175dc3910
```

## Testing Sequence

### Step 1: Test Get Restaurants
1. Run "1. Get Restaurants"
2. This will store a restaurant ID automatically
3. Check the console for: "Restaurant ID stored: [restaurant-id]"

### Step 2: Test Check Availability
1. Run "2. Check Availability"
2. This will store an available time slot
3. Check the console for: "Available time stored: [time]"

### Step 3: Test Create Reservation (Get Payment Info)
1. Run "3. Create Reservation (Payment Test)"
2. This will extract payment information
3. Check the console for payment details:
   - Payment Required: true/false
   - Payment URL: [url]
   - Payment Amount: [amount]

### Step 4: Test Payment URL Extraction
1. Run "4. Payment URL Extraction Analysis"
2. This provides detailed analysis of where payment info is found
3. Check the console for complete payment analysis

## Expected Results

### Successful Restaurant Response
```json
{
  "status": true,
  "data": {
    "data": [
      {
        "id": "actual-restaurant-uuid",
        "type": "restaurant",
        "attributes": {
          "name": "Actual Restaurant Name",
          "available_online": true,
          "address_line_1": "Actual Address"
        }
      }
    ]
  }
}
```

### Successful Reservation with Payment
```json
{
  "status": true,
  "data": {
    "data": {
      "id": "reservation-id",
      "type": "reservation",
      "attributes": {
        "key": "reservation-key",
        "status": "confirmed"
      }
    },
    "included": [
      {
        "type": "payment",
        "attributes": {
          "payment_widget_url": "https://payment.eatapp.co/widget/actual-url",
          "amount": 20.00,
          "currency": "USD"
        }
      }
    ]
  },
  "message": "Reservation created successfully",
  "local_id": 123,
  "payment_url": "https://payment.eatapp.co/widget/actual-url",
  "payment_required": true,
  "payment_amount": 20.00
}
```

## Troubleshooting

### If you get "Connection refused":
1. Make sure XAMPP is running
2. Check that Apache is started
3. Verify the URL path is correct

### If you get "Unauthorized access":
1. Check that the Authorization header has: `123456789`
2. Make sure there are no extra spaces

### If you get "Missing required field":
1. Make sure you ran the tests in sequence
2. Check that restaurant_id and available_time are set in environment

### If no payment URL is found:
1. Check the console output from "Payment URL Extraction Analysis"
2. The system searches multiple locations in the response
3. Payment might not be required for all reservations

## Environment Variables (Auto-populated)

The tests will automatically set these variables:
- `restaurant_id`: From Get Restaurants test
- `available_time`: From Check Availability test
- `payment_url`: From Create Reservation test
- `payment_amount`: From Create Reservation test
- `local_reservation_id`: From Create Reservation test

## Manual Testing URLs

If you want to test manually in browser:

### Get Restaurants
```
GET http://localhost/bastian_parent/bastian/admin/index.php/api/eatapp_controller/restaurants
Headers: Authorization: 123456789
```

### Check Availability
```
POST http://localhost/bastian_parent/bastian/admin/index.php/api/eatapp_controller/availability
Headers: 
  Authorization: 123456789
  Content-Type: application/json
Body: {
  "restaurant_id": "your-restaurant-id",
  "earliest_start_time": "2024-01-15T18:00:00Z",
  "latest_start_time": "2024-01-15T22:00:00Z",
  "covers": 4
}
```

### Create Reservation
```
POST http://localhost/bastian_parent/bastian/admin/index.php/api/eatapp_controller/create_reservation
Headers:
  Authorization: 123456789
  Content-Type: application/json
Body: {
  "restaurant_id": "your-restaurant-id",
  "covers": 4,
  "start_time": "2024-01-15T19:00:00Z",
  "first_name": "John",
  "last_name": "Doe",
  "email": "john@example.com",
  "phone": "+1234567890",
  "notes": "Test reservation"
}
```

## Database Check

After creating reservations, you can check your database:

```sql
-- Check recent reservations
SELECT * FROM eatapp_reservations ORDER BY created_at DESC LIMIT 5;

-- Check availability cache
SELECT * FROM eatapp_availability ORDER BY cached_at DESC LIMIT 5;
```

## Security Notes

- The EatApp Bearer token is hidden from frontend
- Only the simple API key (123456789) is used for frontend authentication
- All sensitive operations happen server-side
- Database stores all reservation data locally first

## Next Steps

1. Import the collection
2. Set your base URL
3. Run tests in sequence
4. Check console output for payment information
5. Verify database entries
6. Test error scenarios

The collection is ready to use with your actual API configuration! 