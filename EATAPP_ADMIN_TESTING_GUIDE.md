# EatApp Admin Integration - Testing Guide

## Overview

This guide provides comprehensive testing instructions for the EatApp admin integration, including URLs for both local and live environments.

## Environment Configuration

### Local Environment Setup
- **Base URL**: `http://localhost/bastian/admin`
- **EatApp API**: Sandbox environment
- **Database**: Local MySQL database

### Live Environment Setup
- **Base URL**: `https://bastian.ninetriangles.com/admin`
- **EatApp API**: Production environment
- **Database**: Live MySQL database

## Testing URLs

### 1. Admin Panel Access

#### Local Environment
```
http://localhost/bastian/admin/
```

#### Live Environment
```
https://bastian.ninetriangles.com/admin/
```

### 2. EatApp Dashboard

#### Local Environment
```
http://localhost/bastian/admin/backend/eatapp_dashboard
```

#### Live Environment
```
https://bastian.ninetriangles.com/admin/backend/eatapp_dashboard
```

**Features to Test:**
- ✅ Total reservations count
- ✅ Confirmed/Pending/Failed statistics
- ✅ Recent reservations table
- ✅ Quick stats (Today, This Week, This Month)
- ✅ Quick action buttons

### 3. EatApp Reservations Management

#### Local Environment
```
http://localhost/bastian/admin/backend/eatapp_reservations
```

#### Live Environment
```
https://bastian.ninetriangles.com/admin/backend/eatapp_reservations
```

**Features to Test:**
- ✅ View all reservations
- ✅ Filter by status (All, Confirmed, Pending, Failed)
- ✅ Search functionality
- ✅ Reservation details modal
- ✅ Status update functionality
- ✅ Statistics cards

### 4. EatApp Cache Management

#### Local Environment
```
http://localhost/bastian/admin/backend/eatapp_cache
```

#### Live Environment
```
https://bastian.ninetriangles.com/admin/backend/eatapp_cache
```

**Features to Test:**
- ✅ View active availability cache
- ✅ View expired cache entries
- ✅ View restaurant cache
- ✅ Clear expired cache functionality
- ✅ Cache statistics

### 5. API Endpoints (Direct Testing)

#### Local Environment
```
# Get Restaurants
GET http://localhost/bastian/admin/api/eatapp/restaurants
Headers: Authorization: 123456789

# Check Availability
POST http://localhost/bastian/admin/api/eatapp/availability
Headers: 
  Authorization: 123456789
  Content-Type: application/json
Body: {
  "restaurant_id": "restaurant_uuid",
  "earliest_start_time": "2024-01-15T18:00:00Z",
  "latest_start_time": "2024-01-15T22:00:00Z",
  "covers": 4
}

# Create Reservation
POST http://localhost/bastian/admin/api/eatapp/create_reservation
Headers:
  Authorization: 123456789
  Content-Type: application/json
Body: {
  "restaurant_id": "restaurant_uuid",
  "covers": 4,
  "start_time": "2024-01-15T19:00:00Z",
  "first_name": "John",
  "last_name": "Doe",
  "email": "john@example.com",
  "phone": "+1234567890",
  "notes": "Window seat preferred"
}

# Get Reservations (Admin)
GET http://localhost/bastian/admin/api/eatapp/get_reservations
Headers: Authorization: 123456789
```

#### Live Environment
```
# Get Restaurants
GET https://bastian.ninetriangles.com/admin/api/eatapp/restaurants
Headers: Authorization: 123456789

# Check Availability
POST https://bastian.ninetriangles.com/admin/api/eatapp/availability
Headers: 
  Authorization: 123456789
  Content-Type: application/json
Body: {
  "restaurant_id": "restaurant_uuid",
  "earliest_start_time": "2024-01-15T18:00:00Z",
  "latest_start_time": "2024-01-15T22:00:00Z",
  "covers": 4
}

# Create Reservation
POST https://bastian.ninetriangles.com/admin/api/eatapp/create_reservation
Headers:
  Authorization: 123456789
  Content-Type: application/json
Body: {
  "restaurant_id": "restaurant_uuid",
  "covers": 4,
  "start_time": "2024-01-15T19:00:00Z",
  "first_name": "John",
  "last_name": "Doe",
  "email": "john@example.com",
  "phone": "+1234567890",
  "notes": "Window seat preferred"
}

# Get Reservations (Admin)
GET https://bastian.ninetriangles.com/admin/api/eatapp/get_reservations
Headers: Authorization: 123456789
```

## Testing Checklist

### 1. Admin Panel Navigation
- [ ] Access admin panel with valid credentials
- [ ] Navigate to EatApp menu section
- [ ] Access EatApp Dashboard
- [ ] Access EatApp Reservations
- [ ] Access EatApp Cache Management

### 2. Dashboard Functionality
- [ ] View total reservations count
- [ ] View confirmed reservations count
- [ ] View pending reservations count
- [ ] View failed reservations count
- [ ] View recent reservations table
- [ ] Test quick action buttons

### 3. Reservations Management
- [ ] View all reservations
- [ ] Filter by status (All, Confirmed, Pending, Failed)
- [ ] Search reservations by name, email, phone
- [ ] View reservation details in modal
- [ ] Update reservation status
- [ ] View statistics cards

### 4. Cache Management
- [ ] View active availability cache
- [ ] View expired cache entries
- [ ] View restaurant cache
- [ ] Clear expired cache
- [ ] View cache statistics

### 5. API Testing
- [ ] Test restaurants endpoint
- [ ] Test availability endpoint
- [ ] Test create reservation endpoint
- [ ] Test get reservations endpoint
- [ ] Verify API responses

### 6. Database Verification
- [ ] Check eatapp_reservations table
- [ ] Check eatapp_availability table
- [ ] Check eatapp_restaurants table
- [ ] Verify data integrity

## Environment Switching

### To Switch to Local Environment
1. Edit `admin/application/config/config.php`
2. Set `$environment = 'local';`
3. Edit `admin/application/controllers/api/Eatapp_controller.php`
4. Set `$environment = 'local';`

### To Switch to Live Environment
1. Edit `admin/application/config/config.php`
2. Set `$environment = 'live';`
3. Edit `admin/application/controllers/api/Eatapp_controller.php`
4. Set `$environment = 'live';`
5. Update live API credentials in the controller

## Troubleshooting

### Common Issues

#### 1. Admin Panel Not Accessible
**Symptoms**: 404 error or login issues
**Solutions**:
- Verify base URL configuration
- Check database connectivity
- Verify admin credentials

#### 2. EatApp Data Not Loading
**Symptoms**: Empty tables or error messages
**Solutions**:
- Check database tables exist
- Verify API credentials
- Check network connectivity to EatApp API

#### 3. Cache Not Working
**Symptoms**: No cache entries or stale data
**Solutions**:
- Check cache table structure
- Verify cache expiration logic
- Clear expired cache manually

#### 4. API Endpoints Not Responding
**Symptoms**: 404 or 500 errors
**Solutions**:
- Verify API key authentication
- Check CORS configuration
- Verify route configuration

## Security Notes

1. **API Key Protection**: The API key `123456789` should be changed in production
2. **EatApp Credentials**: Live environment credentials are commented out for security
3. **Database Access**: Ensure proper database permissions
4. **Admin Authentication**: Verify admin user roles and permissions

## Performance Monitoring

### Key Metrics to Monitor
- API response times
- Database query performance
- Cache hit/miss ratios
- Reservation processing times
- Error rates

### Log Locations
- PHP Error Logs: Check server error logs
- Application Logs: Check CodeIgniter logs
- Database Logs: Check MySQL slow query logs

## Support

For technical support or issues:
1. Check the troubleshooting section above
2. Review server error logs
3. Verify configuration settings
4. Test API endpoints directly
5. Contact development team

---

**Last Updated**: January 2024
**Version**: 1.0
**Environment**: Local & Live 