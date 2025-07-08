# Bastian Hospitality - Restaurant Reservation System

A comprehensive restaurant reservation system built with React frontend and CodeIgniter backend, featuring secure API integration with EatApp sandbox for dual reservation management.

## 🏗️ Project Architecture

### Frontend (React + Vite)
- **Location**: `bastian-updated-reservation-api/`
- **Framework**: React 18.3.1 with Vite 6.3.5
- **Styling**: TailwindCSS 3.4.14
- **Key Features**:
  - Responsive restaurant website
  - Interactive reservation system
  - Multi-restaurant support
  - Date/time picker integration
  - reCAPTCHA validation
  - Email notifications

### Backend (CodeIgniter)
- **Location**: `admin/`
- **Framework**: CodeIgniter 3.x
- **Database**: MySQL (bastiann_backend)
- **Key Features**:
  - RESTful API endpoints
  - Secure API wrapper pattern
  - Dual reservation system integration
  - Email SMTP configuration
  - Admin panel for reservation management

## 🔐 Security Features

### API Security Implementation
The project implements a secure API wrapper pattern to protect sensitive data:

1. **Hidden Bearer Tokens**: EatApp API credentials are stored server-side
2. **API Key Authentication**: Custom API key system (`123456789`) for internal endpoints
3. **CORS Configuration**: Proper cross-origin resource sharing setup
4. **Request Validation**: Server-side validation for all form submissions

### Sensitive Data Protection
- Bearer tokens and API credentials are never exposed to browser
- All external API calls are proxied through backend
- Environment-specific configurations are server-side only

## 📊 Dual Reservation System

The system sends reservation data to two destinations:

1. **Primary Backend**: `https://bastian.ninetriangles.com/admin/backend/enquiries/`
2. **EatApp Sandbox**: `https://app.eat-sandbox.co/` (via API integration)

### Data Flow
```
Frontend Form → Backend API → Database Storage → Email Notification → External APIs
```

## 🚀 Quick Start

### Prerequisites
- Node.js (v16 or higher)
- XAMPP (Apache + MySQL + PHP)
- Git

### Frontend Setup
```bash
# Navigate to frontend directory
cd bastian-updated-reservation-api

# Install dependencies
npm install

# Start development server
npm run dev
```

### Backend Setup
1. **Start XAMPP**:
   - Start Apache and MySQL services
   - Ensure PHP 7.4+ is running

2. **Database Setup**:
   ```bash
   # Import database
   mysql -u root -p bastiann_backend < bastiann_backend.sql
   ```

3. **Configure Backend**:
   - Place `admin/` folder in XAMPP htdocs
   - Update database configuration in `admin/application/config/database.php`
   - Configure SMTP settings in admin panel

### Environment Configuration
Update API endpoints in `bastian-updated-reservation-api/src/API/api_url.jsx`:
```javascript
const API_URL = "http://localhost/bastian/admin"; // For local development
// const API_URL = "https://bastian.ninetriangles.com/admin"; // For production
```

## 📁 Project Structure

```
bastian/
├── admin/                          # CodeIgniter Backend
│   ├── application/
│   │   ├── controllers/
│   │   │   └── api/
│   │   │       └── Form_controller.php  # API endpoints
│   │   ├── models/                 # Database models
│   │   ├── views/                  # Email templates
│   │   └── config/                 # Configuration files
│   ├── assets/                     # Backend assets
│   └── system/                     # CodeIgniter core
├── bastian-updated-reservation-api/ # React Frontend
│   ├── src/
│   │   ├── API/                    # API integration layer
│   │   │   ├── api_url.jsx         # API endpoints configuration
│   │   │   ├── reservation.jsx     # Reservation API calls
│   │   │   └── user-reservation.jsx # EatApp integration
│   │   ├── components/             # Reusable components
│   │   ├── pages/                  # Page components
│   │   │   ├── Reservations.jsx    # Main reservation page
│   │   │   └── ReservationsNew.jsx # Updated reservation page
│   │   └── utils/                  # Utility functions
│   ├── public/                     # Static assets
│   └── package.json                # Dependencies
├── bastiann_backend.sql            # Database schema
└── README.md                       # This file
```

## 🔧 Development Workflow

### Available Scripts (Frontend)
```bash
npm run dev      # Start development server with hot reload
npm run build    # Build for production
npm run preview  # Preview production build
npm run lint     # Run ESLint
```

### API Endpoints
- `POST /api/header-form` - Header contact form
- `POST /api/footer-sort-form` - Footer short form
- `POST /api/footer-long-form` - Footer long form
- `POST /api/reservation-form` - Restaurant reservations
- `POST /api/career` - Career applications

### Database Tables
- `tbl_forms_data` - Reservation data storage
- `tbl_career` - Career applications
- `tbl_category` - Content categories
- `tbl_settings` - Site configuration

## 🧪 Testing

### Frontend Testing
```bash
# Run development server
npm run dev

# Test form submissions
# Verify API calls in browser network tab
# Check console for errors
```

### Backend Testing
1. **API Endpoint Testing**:
   - Use Postman or curl to test API endpoints
   - Verify database insertions
   - Check email delivery

2. **Security Testing**:
   - Inspect browser network tab for exposed credentials
   - Verify API key authentication
   - Test CORS policies

### Reservation Flow Testing
1. Fill out reservation form on frontend
2. Verify data appears in database
3. Check email notifications
4. Confirm data sent to EatApp sandbox

## 🔄 Deployment

### Production Deployment
1. **Frontend**:
   ```bash
   npm run build
   # Deploy dist/ folder to web server
   ```

2. **Backend**:
   - Upload admin/ folder to production server
   - Update database configuration
   - Configure production API URLs

3. **Environment Variables**:
   - Update API_URL in frontend
   - Configure production database credentials
   - Set up production SMTP settings

## 🛡️ Security Considerations

1. **API Security**:
   - Never expose EatApp bearer tokens in frontend
   - Use server-side API wrapper pattern
   - Implement proper authentication

2. **Data Protection**:
   - Validate all user inputs
   - Sanitize database queries
   - Use HTTPS in production

3. **CORS Configuration**:
   - Restrict origins to specific domains
   - Avoid wildcard (*) in production

## 🐛 Troubleshooting

### Common Issues

1. **CORS Errors**:
   - Check backend CORS headers
   - Verify API URL configuration

2. **Database Connection**:
   - Ensure XAMPP MySQL is running
   - Check database credentials

3. **API Authentication**:
   - Verify API key in requests
   - Check authorization headers

4. **Email Issues**:
   - Configure SMTP settings in admin panel
   - Test email delivery

## 📞 Support

For technical support or questions:
- Check existing functionality before making changes
- Test thoroughly before deployment
- Maintain backward compatibility

## 🔗 External Integrations

- **EatApp Sandbox**: Restaurant reservation management
- **EmailJS**: Email service integration
- **Google reCAPTCHA**: Form validation
- **Google Analytics**: Website tracking

---

**Note**: This project prioritizes security and data integrity. Always test changes thoroughly and ensure existing functionalities remain intact.
