# Admin Panel Deployment Checklist

## 🚀 Live Server Access Issues - Troubleshooting Guide

### Current Issue: https://bastian.ninetriangles.com/admin/ not accessible

## ✅ Configuration Updates Made

### 1. **Base URL Configuration** (COMPLETED)
- Updated `admin/application/config/config.php` to auto-detect environment
- Local: `http://localhost/bastian-admin`
- Production: `https://bastian.ninetriangles.com/admin`

### 2. **Database Configuration** (COMPLETED)
- Updated `admin/application/config/database.php` for environment detection
- Production credentials need to be verified

## 🔧 Required Actions for Live Server

### 1. **Verify File Upload**
Ensure all admin files are uploaded to the correct directory:
```
/public_html/admin/
├── application/
├── system/
├── public/
├── index.php
├── .htaccess
└── ...
```

### 2. **Database Setup**
1. Create database: `bastiann_backend`
2. Import SQL file: `bastiann_backend.sql`
3. Update database credentials in production section of `database.php`:
   ```php
   'hostname' => 'localhost', // Your DB host
   'username' => 'bastiann_backend', // Your DB username  
   'password' => 'backend@2927', // Your DB password
   'database' => 'bastiann_backend', // Your DB name
   ```

### 3. **File Permissions**
Set correct permissions on live server:
```bash
chmod 755 admin/
chmod 644 admin/.htaccess
chmod 644 admin/index.php
chmod -R 755 admin/application/
chmod -R 755 admin/system/
chmod -R 777 admin/public/uploads/ (if exists)
```

### 4. **Apache/Server Configuration**
Ensure these are enabled on your hosting:
- `mod_rewrite` (for URL rewriting)
- `mod_expires` (for caching)
- PHP 7.4+ with mysqli extension

### 5. **SSL Certificate**
Ensure HTTPS is properly configured for:
- `https://bastian.ninetriangles.com/admin/`

## 🔍 Common Issues & Solutions

### Issue 1: 404 Not Found
**Cause**: Files not uploaded or wrong directory
**Solution**: 
- Check if `admin/index.php` exists
- Verify directory structure
- Check .htaccess file is present

### Issue 2: 500 Internal Server Error
**Cause**: PHP errors or configuration issues
**Solution**:
- Check error logs in cPanel
- Verify PHP version compatibility
- Check file permissions

### Issue 3: Database Connection Error
**Cause**: Wrong database credentials
**Solution**:
- Update database.php with correct credentials
- Ensure database exists
- Check database user permissions

### Issue 4: Blank Page
**Cause**: PHP errors with display_errors off
**Solution**:
- Check error logs
- Temporarily enable error reporting
- Verify all required PHP extensions

## 📋 Testing Steps

1. **Basic Access**: `https://bastian.ninetriangles.com/admin/`
2. **Login Page**: Should show admin login form
3. **API Endpoints**: Test `https://bastian.ninetriangles.com/admin/api/eatapp/restaurants`
4. **Database**: Verify enquiries show in admin panel

## 🔐 Security Notes

- Change default admin credentials
- Ensure HTTPS is enforced
- Keep application/ and system/ directories protected
- Regular security updates

## 📞 Next Steps

1. **Upload files** to correct directory on live server
2. **Create database** and import SQL
3. **Update database credentials** in config
4. **Test access** to admin panel
5. **Verify API endpoints** are working
