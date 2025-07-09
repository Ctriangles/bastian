# Bastian Hospitality - Restaurant Reservation System

A comprehensive restaurant reservation system built with React frontend and CodeIgniter backend, featuring integration with EatApp's reservation management system.

## 🏗️ Project Architecture

### Frontend (React + Vite)
- **Location**: `bastian-updated-reservation-api/`
- **Framework**: React 18.3.1 with Vite 6.3.5
- **Styling**: Tailwind CSS
- **Key Features**: 
  - Responsive restaurant website
  - Multi-step reservation forms
  - EatApp integration for real-time availability
  - Google Analytics & Facebook Pixel tracking
  - SEO optimized with dynamic meta tags

### Backend (CodeIgniter 3.x)
- **Location**: `admin/` (deployed to XAMPP's htdocs as `bastian-admin/`)
- **Framework**: CodeIgniter 3.x with PHP
- **Database**: MySQL (`bastiann_backend`)
- **Key Features**:
  - RESTful API endpoints
  - Email notifications
  - Admin dashboard
  - CORS enabled for frontend integration

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

#### `tbl_forms_data` - Main Reservation Data
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

#### `tbl_forms` - Short Form Data
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

## 🔌 API Documentation

### Base URL
- Local: `http://localhost/bastian-admin/api/`
- Production: `https://bastian.ninetriangles.com/admin/api/`

### Authentication
All API endpoints require an Authorization header:
```
Authorization: 123456789
```

### Endpoints

#### 1. Reservation Form (Full)
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

#### 2. Header Form (Quick Reservation)
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

#### 3. Footer Short Form
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

#### 4. Footer Long Form
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

**API Configuration** (`src/API/api_url.jsx`):
```javascript
const EATAPP_CONCIERGE_API_URL = 'https://api.eat-sandbox.co/concierge/v2';
const EatAppAuthKey = 'Bearer [TOKEN]';
const EatAppGroupID = '4bcc6bdd-765b-4486-83ab-17c175dc3910';
```

### Available EatApp Endpoints
- **Restaurants**: Get list of restaurants
- **Availability**: Check table availability
- **Reservations**: Create/manage reservations

## 🎨 Frontend Structure

### Key Components
- `Header.jsx` - Navigation and quick reservation
- `Footer.jsx` - Contact forms and links
- `Reservation.jsx` - Main reservation form
- `ReservationEatApp.jsx` - EatApp integrated reservations

### Pages
- `Home.jsx` - Landing page
- `Reservations.jsx` - Reservation page
- `Career.jsx` - Career applications
- Various restaurant-specific pages

### API Integration
- `src/API/reservation.jsx` - Backend API calls
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
    // ... other settings
);
```

## 🚀 Deployment

### Frontend Deployment
```bash
cd bastian-updated-reservation-api
npm run build
# Deploy dist/ folder to web server
```

### Backend Deployment
1. Upload `admin/` folder to web server
2. Configure database connection
3. Set up email SMTP settings
4. Update CORS settings for production domain

## 🔍 Testing

### API Testing
```bash
# Test reservation endpoint
curl -X POST http://localhost/bastian-admin/api/reservation-form \
  -H "Authorization: 123456789" \
  -H "Content-Type: application/json" \
  -d '{"formvalue":{"restaurant_id":"test","pax":"2","booking_date":"2025-07-10","booking_time":"19:00","full_name":"Test User","email":"test@example.com","mobile":"1234567890","age":"25","pincode":"123456","comments":"Test reservation"}}'
```

### Frontend Testing
1. Open `http://localhost:5173`
2. Navigate to reservation page
3. Fill out and submit forms
4. Check database for entries

## 📝 Development Workflow

### Detailed Reservation Process Flow

#### 1. Frontend User Journey
```
User visits website (localhost:5173)
    ↓
Navigates to Reservations page (/reservations)
    ↓
Selects restaurant and date/time
    ↓
Fills out reservation form with:
    - Restaurant ID
    - Number of guests (pax)
    - Booking date & time
    - Personal details (name, email, phone)
    - Additional info (age, pincode, comments)
    ↓
Form validation (React)
    ↓
Submit button triggers API call
```

#### 2. API Communication Flow
```javascript
// Frontend API call (src/API/reservation.jsx)
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

#### 3. Backend Processing Flow
```
API Request received at /api/reservation-form
    ↓
Form_controller.php → ReservationForm() method
    ↓
Authentication check (API key validation)
    ↓
Data extraction and formatting
    ↓
Database insertion (tbl_forms_data table)
    ↓
Email notification sent to restaurant
    ↓
EatApp integration attempt (sendDataAfterInsert)
    ↓
Response sent back to frontend
```

#### 4. Database Operations
```sql
-- Data inserted into tbl_forms_data
INSERT INTO tbl_forms_data (
    restaurant_id, booking_date, booking_time,
    full_name, email_id, contact_number,
    age, pax, pin_code, comments,
    user_ip, insert_date, edit_date, status
) VALUES (...);
```

#### 5. EatApp Integration Flow
```
Backend triggers sendDataAfterInsert()
    ↓
Constructs API call to EatApp sandbox
    ↓
Sends reservation data to EatApp system
    ↓
EatApp processes and stores reservation
    ↓
Restaurant staff can view in EatApp dashboard
```

### Component Architecture

#### Frontend Components Hierarchy
```
App.jsx
├── Header.jsx (Quick reservation form)
├── Routes
│   ├── Home.jsx
│   ├── Reservations.jsx
│   │   └── Reservation.jsx (Main form)
│   ├── ReservationsNew.jsx
│   │   └── ReservationEatApp.jsx (EatApp integration)
│   └── Other pages...
└── Footer.jsx (Contact forms)
```

#### Backend Controller Structure
```
admin/application/controllers/api/
└── Form_controller.php
    ├── HeaderForm() - Quick reservations
    ├── FooterSortForm() - Short form data
    ├── FooterLongForm() - Complete form data
    ├── ReservationForm() - Main reservation endpoint
    ├── Career() - Career applications
    └── sendDataAfterInsert() - EatApp integration
```

### Data Flow Diagram
```
[React Frontend]
       ↓ HTTP POST
[CodeIgniter API]
       ↓ SQL INSERT
[MySQL Database]
       ↓ Email/EatApp
[External Services]
```

### Code Structure
```
bastian/
├── bastian-updated-reservation-api/    # React Frontend
│   ├── src/
│   │   ├── components/                 # Reusable components
│   │   ├── pages/                      # Page components
│   │   ├── API/                        # API integration
│   │   └── assets/                     # Static assets
│   └── package.json
├── admin/                              # CodeIgniter Backend
│   ├── application/
│   │   ├── controllers/api/            # API controllers
│   │   ├── models/                     # Database models
│   │   ├── views/                      # Email templates
│   │   └── config/                     # Configuration
│   └── index.php
└── bastiann_backend.sql               # Database schema
```

## 🛠️ Troubleshooting

### Common Issues

1. **CORS Errors**: Check CORS headers in `Form_controller.php`
2. **Database Connection**: Verify XAMPP MySQL is running
3. **API 404 Errors**: Ensure backend is copied to XAMPP htdocs
4. **Email Not Sending**: Configure SMTP settings in admin panel

### Logs
- Frontend: Browser console
- Backend: `admin/application/logs/`
- Apache: XAMPP logs directory

## ✅ Current Project Status

### ✅ Working Features
- ✅ React frontend running on `http://localhost:5173`
- ✅ CodeIgniter backend running on `http://localhost/bastian-admin`
- ✅ Database connection and schema setup
- ✅ API endpoints functional and tested
- ✅ **SECURE** EatApp integration with backend proxy
- ✅ Email notifications system
- ✅ CORS properly configured
- ✅ Responsive design with Tailwind CSS
- ✅ **API credentials protected** from frontend exposure

### 🔒 Security Improvements
- ✅ **EatApp API credentials moved to backend** - No longer exposed in browser
- ✅ **Backend proxy pattern implemented** - Secure server-to-server communication
- ✅ **Frontend uses secure API wrapper** - Only backend API key exposed (safe)
- ✅ **All reservation functionality maintained** - No feature loss

### 🔧 Known Issues
- ⚠️ Minor URL variable issue in EatApp integration (line 320 in Form_controller.php)
- ⚠️ Some npm audit vulnerabilities (1 low severity)

### 🚀 Next Steps
1. Fix the EatApp URL variable issue
2. Update npm packages to resolve security vulnerabilities
3. Add comprehensive error handling
4. Implement reservation confirmation emails to customers
5. Add admin dashboard for managing reservations
6. Set up production deployment pipeline

## 🔄 Development Commands

### Frontend Development
```bash
# Start development server
cd bastian-updated-reservation-api
npm run dev

# Build for production
npm run build

# Run linting
npm run lint

# Preview production build
npm run preview
```

### Backend Development
```bash
# Start XAMPP services
sudo /Applications/XAMPP/xamppfiles/xampp start

# Stop XAMPP services
sudo /Applications/XAMPP/xamppfiles/xampp stop

# View logs
tail -f /Applications/XAMPP/xamppfiles/logs/error_log
```

### Database Management
```bash
# Access MySQL via command line
/Applications/XAMPP/xamppfiles/bin/mysql -u root -p

# Backup database
/Applications/XAMPP/xamppfiles/bin/mysqldump -u root -p bastiann_backend > backup.sql

# Restore database
/Applications/XAMPP/xamppfiles/bin/mysql -u root -p bastiann_backend < bastiann_backend.sql
```

## 📞 Support

For technical support or questions about the reservation system, please contact the development team.

### Project Structure Summary
- **Frontend**: Modern React app with Vite build system
- **Backend**: CodeIgniter 3.x REST API
- **Database**: MySQL with comprehensive reservation schema
- **Integration**: EatApp sandbox for restaurant management
- **Deployment**: XAMPP for local development, production-ready architecture

---

**Last Updated**: July 2025
**Version**: 1.0.0
**Status**: ✅ Fully Functional Development Environment
