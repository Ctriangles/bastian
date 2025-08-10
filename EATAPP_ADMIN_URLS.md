# EatApp Admin Integration - Quick URL Reference

## 🚀 Quick Start URLs

### Local Environment
```
Admin Panel: http://localhost/bastian/admin/
EatApp Dashboard: http://localhost/bastian/admin/backend/eatapp_dashboard
Reservations: http://localhost/bastian/admin/backend/eatapp_reservations
Cache Management: http://localhost/bastian/admin/backend/eatapp_cache
```

### Live Environment
```
Admin Panel: https://bastian.ninetriangles.com/admin/
EatApp Dashboard: https://bastian.ninetriangles.com/admin/backend/eatapp_dashboard
Reservations: https://bastian.ninetriangles.com/admin/backend/eatapp_reservations
Cache Management: https://bastian.ninetriangles.com/admin/backend/eatapp_cache
```

## 🔧 API Testing URLs

### Local Environment
```
GET  http://localhost/bastian/admin/api/eatapp/restaurants
POST http://localhost/bastian/admin/api/eatapp/availability
POST http://localhost/bastian/admin/api/eatapp/create_reservation
GET  http://localhost/bastian/admin/api/eatapp/get_reservations
```

### Live Environment
```
GET  https://bastian.ninetriangles.com/admin/api/eatapp/restaurants
POST https://bastian.ninetriangles.com/admin/api/eatapp/availability
POST https://bastian.ninetriangles.com/admin/api/eatapp/create_reservation
GET  https://bastian.ninetriangles.com/admin/api/eatapp/get_reservations
```

## 📋 Required Headers
```
Authorization: 123456789
Content-Type: application/json (for POST requests)
```

## 🔄 Environment Switching

### To Local:
1. Edit `admin/application/config/config.php` → `$environment = 'local';`
2. Edit `admin/application/controllers/api/Eatapp_controller.php` → `$environment = 'local';`

### To Live:
1. Edit `admin/application/config/config.php` → `$environment = 'live';`
2. Edit `admin/application/controllers/api/Eatapp_controller.php` → `$environment = 'live';`
3. Update live API credentials in the controller

## ✅ Quick Test Commands

### Test Restaurants API
```bash
curl -X GET "http://localhost/bastian/admin/api/eatapp/restaurants" \
  -H "Authorization: 123456789"
```

### Test Reservations API
```bash
curl -X GET "http://localhost/bastian/admin/api/eatapp/get_reservations" \
  -H "Authorization: 123456789"
```

### Test Availability API
```bash
curl -X POST "http://localhost/bastian/admin/api/eatapp/availability" \
  -H "Authorization: 123456789" \
  -H "Content-Type: application/json" \
  -d '{
    "restaurant_id": "test-restaurant-id",
    "earliest_start_time": "2024-01-15T18:00:00Z",
    "latest_start_time": "2024-01-15T22:00:00Z",
    "covers": 4
  }'
```

## 🎯 Key Features to Test

### Admin Dashboard
- [ ] View reservation statistics
- [ ] Check recent reservations
- [ ] Test quick action buttons

### Reservations Management
- [ ] View all reservations
- [ ] Filter by status
- [ ] Search functionality
- [ ] Update reservation status

### Cache Management
- [ ] View active cache
- [ ] View expired cache
- [ ] Clear expired cache
- [ ] View restaurant cache

## 🚨 Important Notes

1. **API Key**: `123456789` (change in production)
2. **Local Environment**: Uses EatApp sandbox API
3. **Live Environment**: Uses EatApp production API (credentials needed)
4. **Database**: Requires `eatapp_reservations`, `eatapp_availability`, `eatapp_restaurants` tables

## 📞 Support

For issues:
1. Check server error logs
2. Verify database connectivity
3. Test API endpoints directly
4. Review configuration settings

---

**Environment**: Local & Live  
**Last Updated**: January 2024 