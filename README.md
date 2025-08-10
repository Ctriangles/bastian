# Bastian Hospitality - Restaurant Reservation System

A comprehensive restaurant reservation system built with React frontend and CodeIgniter backend, featuring integration with EatApp's reservation management system with secure database-first approach.

## 🏗️ Project Architecture

### Frontend (React + Vite)
- **Location**: `bastian-updated-reservation-api/`
- **Framework**: React 18.3.1 with Vite 6.3.5
- **Styling**: Tailwind CSS
- **Key Features**: 
  - Responsive restaurant website
  - Multi-step reservation forms
  - EatApp integration for real-time availability
  - Payment integration with Stripe
  - Google Analytics & Facebook Pixel tracking
  - SEO optimized with dynamic meta tags

### Backend (CodeIgniter 3.x)
- **Location**: `admin/` (deployed to XAMPP's htdocs as `bastian-admin/`)
- **Framework**: CodeIgniter 3.x with PHP
- **Database**: MySQL (`bastiann_backend`)
- **Key Features**:
  - RESTful API endpoints with secure database-first approach
  - Email notifications
  - Admin dashboard
  - CORS enabled for frontend integration
  - EatApp API integration with local data backup

## 🚀 Quick Start

### Prerequisites
- Node.js (v16 or higher)
- XAMPP (Apache + MySQL + PHP)
- Git

### 1. Clone the Repository
```bash
git clone <repository-url>
cd bastian
```

### 2. Frontend Setup
```bash
cd bastian-updated-reservation-api
npm install
npm run dev
```
The React app will be available at: `http://localhost:5173`

### 3. Backend Setup

#### Step 1: Copy Backend to XAMPP
```bash
# Copy the admin folder to XAMPP's htdocs
cp -r admin /Applications/XAMPP/htdocs/bastian-admin
```

#### Step 2: Start XAMPP Services
- Start Apache and MySQL from XAMPP Control Panel
- Or use command line:
```bash
sudo /Applications/XAMPP/xamppfiles/xampp start
```

#### Step 3: Database Setup
1. Open phpMyAdmin: `http://localhost/phpmyadmin`
2. Create database: `bastiann_backend`
3. Import the SQL file: `bastiann_backend.sql`
4. Update database credentials in: `admin/application/config/database.php`

### 4. Verify Installation
- Frontend: `http://localhost:5173`
- Backend: `http://localhost/bastian-admin`
- API Test: `http://localhost/bastian-admin/api/reservation-form`

## 📊 Database Schema

### Core Tables

#### `tbl_forms_data` - Legacy Reservation Data (Deprecated)
```sql
- id (Primary Key)
- restaurant_id (varchar)
- booking_date (date)
- booking_time (time)
- full_name (varchar)
- email_id (varchar)
- contact_number (varchar)
- age (varchar)
- pax (varchar)
- residence_area (varchar)
- pin_code (varchar)
- comments (text)
- user_ip (varchar)
- insert_date (datetime)
- edit_date (datetime)
- status (int)
```

#### `tbl_forms` - Legacy Short Form Data (Deprecated)
```sql
- id (Primary Key)
- restaurant_id (int)
- pax (varchar)
- booking_date (date)
- user_ip (varchar)
- insert_date (datetime)
- edit_date (datetime)
- status (int)
```

#### `tbl_career` - Career Applications
```sql
- id (Primary Key)
- department (varchar)
- full_name (varchar)
- contact_number (varchar)
- email_id (varchar)
- user_ip (varchar)
- insert_date (datetime)
- edit_date (datetime)
- status (int)
```

### EatApp Integration Tables (Current System)

#### `eatapp_reservations` - Main Reservation Storage (ACTIVE)
```sql
- id (Primary Key, Auto Increment)
- restaurant_id (varchar) - EatApp restaurant ID
- restaurant_name (varchar) - Restaurant name
- diner_name (varchar) - Full diner name
- eatapp_reservation_key (varchar) - EatApp reservation key (e.g., PRZ0Q0, L45HUZ)
- eatapp_reservation_id (varchar) - EatApp internal ID
- covers (int) - Number of people
- start_time (datetime) - Reservation start time
- reservation_date (date) - Reservation date
- reservation_time (time) - Reservation time
- first_name (varchar) - Customer first name
- last_name (varchar) - Customer last name
- email (varchar) - Customer email
- phone (varchar) - Customer phone
- notes (text) - Special requests
- status (enum: pending,confirmed,failed,cancelled) - Reservation status
- eatapp_response (longtext) - Full EatApp API response
- payment_url (text) - Stripe payment URL
- email_data (longtext) - Email notification data
- qr_code_data (text) - QR code information
- calendar_links (longtext) - Calendar integration links
- share_url (text) - Shareable reservation URL
- email_sent_at (timestamp) - Email sent timestamp
- email_sent_to (varchar) - Email recipient
- payment_amount (decimal) - Payment amount
- payment_currency (varchar) - Payment currency (default: USD)
- created_at (timestamp) - Record creation time
- updated_at (timestamp) - Record update time
```

#### `eatapp_restaurants` - Restaurant Cache (ACTIVE)
```sql
- id (Primary Key, Auto Increment)
- eatapp_id (varchar) - EatApp restaurant ID
- name (varchar) - Restaurant name
- address (text) - Restaurant address
- status (enum: active,inactive) - Restaurant status
- eatapp_data (longtext) - Full EatApp restaurant data
- created_at (timestamp) - Record creation time
- updated_at (timestamp) - Record update time
```

#### `eatapp_availability` - Availability Cache (ACTIVE)
```sql
- id (Primary Key, Auto Increment)
- restaurant_id (varchar) - EatApp restaurant ID
- date (date) - Availability date
- covers (int) - Number of people
- available_slots (longtext) - Available time slots
- cached_at (timestamp) - Cache creation time
- expires_at (timestamp) - Cache expiration time
```

## 🔌 API Documentation

### Base URL
- Local: `http://localhost/bastian-admin/api/`
- Production: `https://bastian.ninetriangles.com/admin/api/`

### Authentication
All API endpoints require an Authorization header:
```
Authorization: 123456789
```

### Secure Database-First Endpoints (RECOMMENDED)

#### 1. Secure Reservation Form (Full)
**POST** `/reservation-form`
```json
{
  "formvalue": {
    "restaurant_id": "string",
    "pax": "string",
    "booking_date": "YYYY-MM-DD",
    "booking_time": "HH:MM",
    "full_name": "string",
    "email": "string",
    "mobile": "string",
    "age": "string",
    "pincode": "string",
    "comments": "string"
  }
}
```

**Response:**
```json
{
  "status": true,
  "message": "Reservation created successfully",
  "eatapp_data": {...},
  "payment_url": "https://pay.eat-sandbox.co/PRZ0Q0",
  "payment_required": true,
  "local_id": 66
}
```

#### 2. Secure Header Form (Quick Reservation)
**POST** `/header-form`
```json
{
  "formvalue": {
    "restaurant_id": "string",
    "booking_date": "YYYY-MM-DD",
    "pax": "string",
    "full_name": "string",
    "email": "string",
    "mobile": "string",
    "age": "string",
    "pincode": "string"
  }
}
```

#### 3. Secure Footer Long Form
**POST** `/footer-long-form`
```json
{
  "formvalue": {
    "form_id": "string",
    "full_name": "string",
    "email": "string",
    "mobile": "string",
    "age": "string",
    "pincode": "string"
  }
}
```

### Legacy Endpoints (DEPRECATED)

#### 4. Footer Short Form
**POST** `/footer-sort-form`
```json
{
  "formvalue": {
    "restaurant_id": "string",
    "booking_date": "YYYY-MM-DD",
    "pax": "string"
  }
}
```

#### 5. Career Form
**POST** `/career`
```json
{
  "formvalue": {
    "department": "string",
    "full_name": "string",
    "contact_number": "string",
    "email_id": "string"
  }
}
```

## 🍽️ EatApp Integration

### Configuration
The system integrates with EatApp's sandbox environment for real-time restaurant management.

**API Configuration** (`admin/application/controllers/api/Eatapp_controller.php`):
```php
$eatapp_api_url = 'https://api.eat-sandbox.co/concierge/v2';
$eatapp_auth_key = 'Bearer [TOKEN]';
$eatapp_group_id = '4bcc6bdd-765b-4486-83ab-17c175dc3910';
```

### Secure Database-First Approach
1. **Save to Database First** - All reservations are immediately stored in `eatapp_reservations` table
2. **Send to EatApp** - Reservation data is sent to EatApp API
3. **Update Database** - Database is updated with EatApp response and reservation key
4. **Payment Integration** - Payment URLs are extracted and returned to frontend

### Available EatApp Endpoints
- **Restaurants**: Get list of restaurants
- **Availability**: Check table availability (cached for 15 minutes)
- **Reservations**: Create/manage reservations with payment integration

## 💳 Payment Integration

### Stripe Payment Flow
1. **Reservation Created** - Customer submits reservation form
2. **Payment Required** - System detects payment requirement (usually $10-20 USD)
3. **Payment URL Generated** - EatApp creates Stripe payment link
4. **Customer Pays** - Customer completes payment via Stripe
5. **Reservation Confirmed** - Reservation is confirmed after payment

### Payment Configuration
- **Gateway**: Stripe (via EatApp)
- **Currency**: USD (default)
- **Amount**: $10-20 USD per reservation (varies by restaurant)
- **Payment URL Format**: `https://pay.eat-sandbox.co/[RESERVATION_KEY]`

## 🎨 Frontend Structure

### Key Components
- `Header.jsx` - Navigation and quick reservation (uses secure API)
- `Footer.jsx` - Contact forms and links (uses secure API)
- `Reservation.jsx` - Main reservation form (uses secure API)
- `ReservationEatApp.jsx` - EatApp integrated reservations

### Pages
- `Home.jsx` - Landing page
- `Reservations.jsx` - Reservation page
- `Career.jsx` - Career applications
- Various restaurant-specific pages

### API Integration
- `src/API/reservation.jsx` - Backend API calls (secure endpoints)
- `src/API/user-reservation.jsx` - EatApp integration
- `src/API/api_url.jsx` - Configuration

## 🔧 Configuration

### Environment Variables
Update the following in `src/API/api_url.jsx`:
```javascript
const API_URL = "http://localhost/bastian-admin"; // Local development
// const API_URL = "https://bastian.ninetriangles.com/admin"; // Production
```

### Database Configuration
Update `admin/application/config/database.php`:
```php
$db['default'] = array(
    'hostname' => 'localhost',
    'username' => 'bastiann_backend',
    'password' => 'backend@2927',
    'database' => 'bastiann_backend',
    'dbdriver' => 'mysqli'
);
```

## 📝 API Usage Examples

### Frontend Reservation Call
```javascript
const ReservationForm = async (formvalue) => {
    const response = await axios.post(Apis.ReservationForm,
        { formvalue },
        {
            headers: {
                'Authorization': '123456789',
                'Content-Type': 'application/json',
            },
        }
    );
    return response.data;
};
```

### Backend Processing Flow
```
API Request received at /api/reservation-form
    ↓
Form_controller.php → ReservationForm() method
    ↓
Authentication check (API key validation)
    ↓
Data extraction and formatting
    ↓
Database insertion (tbl_forms_data table - legacy)
    ↓
Secure EatApp integration (create_secure_eatapp_reservation)
    ↓
Database insertion (eatapp_reservations table - current)
    ↓
EatApp API call with payment integration
    ↓
Database update with EatApp response
    ↓
Response sent back to frontend with payment URL
```

## 🔒 Security Features

### Database-First Approach
- **No Data Loss** - All reservations saved locally before API calls
- **Audit Trail** - Complete history of all reservation attempts
- **Error Recovery** - Failed API calls don't lose customer data
- **Status Tracking** - Track pending, confirmed, failed, cancelled statuses

### CORS Configuration
```php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Request-Type, X-Client-Version, X-Platform');
```

## 🚀 Deployment

### Production Checklist
1. **Update API URLs** - Change from localhost to production domain
2. **Database Migration** - Ensure all tables are created
3. **SSL Certificate** - Enable HTTPS for payment security
4. **Environment Variables** - Set production database credentials
5. **Email Configuration** - Configure SMTP for notifications
6. **Monitoring** - Set up error logging and monitoring

### Performance Optimization
- **Availability Caching** - 15-minute cache for availability checks
- **Database Indexing** - Optimized indexes on frequently queried fields
- **API Rate Limiting** - Prevent abuse of reservation endpoints
- **CDN Integration** - Static assets served via CDN

## 📞 Support

For technical support or questions about the reservation system:
- **Email**: chiranjivee.suman@ninetriangles.com
- **Documentation**: This README file
- **API Testing**: Use the provided test endpoints

---

**Last Updated**: August 8, 2025
**Version**: 2.0 (Secure Database-First Implementation)
