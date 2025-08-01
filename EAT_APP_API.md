# EAT App API Integration Documentation

This document outlines the key API endpoints for the EAT App integration.

## 1. Get Restaurants

**Endpoint:** `GET https://api.eat-sandbox.co/concierge/v2/restaurants`

**Headers:**
```
Authorization: Bearer curl "https://api.eat-sandbox.co/concierge/v2/restaurants" -H "Authorization: Bearer eyJhbGciOiJIUzI1NiJ9.eyJleHAiOjE4OTIwNzM2MDAsImlhdCI6MTc0NTgxOTQ0NSwiaWQiOiJkOWZkNTI0Mi04YmQzLTQ1NDYtODNlNy1jZjU1NzY5MDI0MTIiLCJtb2RlbCI6IkNvbmNpZXJnZSIsImp0aSI6IjFkYWU1ZjYyOWM3M2VmOTU3M2U0IiwiYnkiOiJhbGlAZWF0YXBwLmNvIn0.ZCEiRP1gqPNvJEFYDVCk1uA6o0MSD2pzXu88eGh8xt0" -H "X-Group-ID: 4bcc6bdd-765b-4486-83ab-17c175dc3910"
X-Group-ID: 4bcc6bdd-765b-4486-83ab-17c175dc3910
Accept: application/json
```

## 2. Get Time Slots

**Endpoint:** `GET https://api.eat-sandbox.co/concierge/v2/availability`

**Parameters:**
- restaurant_id: 74e1a9cc-bad1-4217-bab5-4264a987cd7f
- covers: 2
- date: 2025-07-29

**Headers:**
```
Authorization: Bearer curl "https://api.eat-sandbox.co/concierge/v2/restaurants" -H "Authorization: Bearer eyJhbGciOiJIUzI1NiJ9.eyJleHAiOjE4OTIwNzM2MDAsImlhdCI6MTc0NTgxOTQ0NSwiaWQiOiJkOWZkNTI0Mi04YmQzLTQ1NDYtODNlNy1jZjU1NzY5MDI0MTIiLCJtb2RlbCI6IkNvbmNpZXJnZSIsImp0aSI6IjFkYWU1ZjYyOWM3M2VmOTU3M2U0IiwiYnkiOiJhbGlAZWF0YXBwLmNvIn0.ZCEiRP1gqPNvJEFYDVCk1uA6o0MSD2pzXu88eGh8xt0" -H "X-Group-ID: 4bcc6bdd-765b-4486-83ab-17c175dc3910"
X-Group-ID: 4bcc6bdd-765b-4486-83ab-17c175dc3910
Accept: application/json
```

## 3. Make a Reservation

**Endpoint:** `POST https://api.eat-sandbox.co/concierge/v2/reservations`

**Headers:**
```
Authorization: Bearer curl "https://api.eat-sandbox.co/concierge/v2/restaurants" -H "Authorization: Bearer eyJhbGciOiJIUzI1NiJ9.eyJleHAiOjE4OTIwNzM2MDAsImlhdCI6MTc0NTgxOTQ0NSwiaWQiOiJkOWZkNTI0Mi04YmQzLTQ1NDYtODNlNy1jZjU1NzY5MDI0MTIiLCJtb2RlbCI6IkNvbmNpZXJnZSIsImp0aSI6IjFkYWU1ZjYyOWM3M2VmOTU3M2U0IiwiYnkiOiJhbGlAZWF0YXBwLmNvIn0.ZCEiRP1gqPNvJEFYDVCk1uA6o0MSD2pzXu88eGh8xt0" -H "X-Group-ID: 4bcc6bdd-765b-4486-83ab-17c175dc3910"
X-Group-ID: 4bcc6bdd-765b-4486-83ab-17c175dc3910
Content-Type: application/json
```

**Request Body:**
```json
{
  "data": {
    "type": "reservation",
    "attributes": {
      "covers": 2,
      "date": "2025-07-29",
      "time": "19:30",
      "guest": {
        "first_name": "Test",
        "last_name": "User",
        "phone": "+911234567890",
        "email": "test@example.com"
      }
    },
    "relationships": {
      "restaurant": {
        "data": {
          "type": "restaurant",
          "id": "74e1a9cc-bad1-4217-bab5-4264a987cd7f"
        }
      }
    }
  }
}
```

### Important Response Fields

When making a reservation, check for these fields in the response:
```json
{
    "payment_required": true,
    "payment_url": "https://..."
}
```

These fields indicate whether payment is required and provide the URL where the payment can be processed.

## Notes
- All endpoints use the sandbox environment
- Replace `YOUR_ACCESS_TOKEN` with the actual access token
- The Group ID used is: `4bcc6bdd-765b-4486-83ab-17c175dc3910`
- All dates are in YYYY-MM-DD format
- Times are in 24-hour format (HH:MM)



curl "https://api.eat-sandbox.co/concierge/v2/restaurants" -H "Authorization: Bearer eyJhbGciOiJIUzI1NiJ9.eyJleHAiOjE4OTIwNzM2MDAsImlhdCI6MTc0NTgxOTQ0NSwiaWQiOiJkOWZkNTI0Mi04YmQzLTQ1NDYtODNlNy1jZjU1NzY5MDI0MTIiLCJtb2RlbCI6IkNvbmNpZXJnZSIsImp0aSI6IjFkYWU1ZjYyOWM3M2VmOTU3M2U0IiwiYnkiOiJhbGlAZWF0YXBwLmNvIn0.ZCEiRP1gqPNvJEFYDVCk1uA6o0MSD2pzXu88eGh8xt0" -H "X-Group-ID: 4bcc6bdd-765b-4486-83ab-17c175dc3910"
{"data":[{"id":"74e1a9cc-bad1-4217-bab5-4264a987cd7f","typ                                          e":"restaurant","attributes":{"name":"Bastian Test","price                                          _level":null,"available_online":true,"terms_and_conditions                                          ":null,"difficult":false,"cuisine":null,"image_url":null,"                   latitude":0.0,"longitude":0.0,"address_line_1":null,"ratin                                          gs_average":null,"ratings_count":null,"created_at":"2025-0                                          4-28T10:46:46","updated_at":"2025-07-29T13:18:19"},"relati                                          onships":{}},{"id":"4abd4dc6-a475-4f05-9a38-8b964abdb6e6",                                      "type":"restaurant","attributes":{"name":"Bastian test 2",           "price_level":null,"available_online":true,"terms_and_cond                                          itions":null,"difficult":false,"cuisine":null,"image_url":                                          null,"latitude":0.0,"longitude":0.0,"address_line_1":null,                                          "ratings_average":null,"ratings_count":null,"created_at":"                              2025-04-28T11:12:40","updated_at":"2025-07-29T05:36:01"},"   relationships":{}}],"meta":{"limit":30,"total_pages":1,"to                                          tal_count":2,"current_page":1},"links":{"first":"https://a                                          pi.eat-sandbox.co/concierge/v2/restaurants?page=1","next":                                          null,"prev":null,"last":"https://api.eat-sandbox.co/concie



