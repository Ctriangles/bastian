#!/bin/bash

# Bastian Reservation System - Production Deployment Script
# This script handles the deployment of the reservation system to production

set -e  # Exit on any error

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Configuration
PROJECT_NAME="Bastian Reservation System"
FRONTEND_DIR="bastian-updated-reservation-api"
BACKEND_DIR="admin"
BACKUP_DIR="/var/backups/bastian/$(date +%Y%m%d_%H%M%S)"

# Functions
log_info() {
    echo -e "${BLUE}[INFO]${NC} $1"
}

log_success() {
    echo -e "${GREEN}[SUCCESS]${NC} $1"
}

log_warning() {
    echo -e "${YELLOW}[WARNING]${NC} $1"
}

log_error() {
    echo -e "${RED}[ERROR]${NC} $1"
}

# Check if running as root or with sudo
check_permissions() {
    if [[ $EUID -eq 0 ]]; then
        log_warning "Running as root. This is not recommended for production deployments."
        read -p "Continue anyway? (y/N): " -n 1 -r
        echo
        if [[ ! $REPLY =~ ^[Yy]$ ]]; then
            exit 1
        fi
    fi
}

# Check prerequisites
check_prerequisites() {
    log_info "Checking prerequisites..."
    
    # Check if Node.js is installed
    if ! command -v node &> /dev/null; then
        log_error "Node.js is not installed. Please install Node.js first."
        exit 1
    fi
    
    # Check if npm is installed
    if ! command -v npm &> /dev/null; then
        log_error "npm is not installed. Please install npm first."
        exit 1
    fi
    
    # Check if PHP is installed
    if ! command -v php &> /dev/null; then
        log_error "PHP is not installed. Please install PHP first."
        exit 1
    fi
    
    # Check if required directories exist
    if [[ ! -d "$FRONTEND_DIR" ]]; then
        log_error "Frontend directory '$FRONTEND_DIR' not found."
        exit 1
    fi
    
    if [[ ! -d "$BACKEND_DIR" ]]; then
        log_error "Backend directory '$BACKEND_DIR' not found."
        exit 1
    fi
    
    log_success "Prerequisites check passed."
}

# Create backup
create_backup() {
    log_info "Creating backup..."
    
    if [[ -d "/var/www/html/bastian" ]]; then
        sudo mkdir -p "$BACKUP_DIR"
        sudo cp -r /var/www/html/bastian "$BACKUP_DIR/"
        log_success "Backup created at $BACKUP_DIR"
    else
        log_warning "No existing installation found to backup."
    fi
}

# Deploy frontend
deploy_frontend() {
    log_info "Deploying frontend..."
    
    cd "$FRONTEND_DIR"
    
    # Install dependencies
    log_info "Installing frontend dependencies..."
    npm ci --production
    
    # Build for production
    log_info "Building frontend for production..."
    npm run build
    
    # Copy built files to web directory
    log_info "Copying frontend files..."
    sudo mkdir -p /var/www/html/bastian/frontend
    sudo cp -r dist/* /var/www/html/bastian/frontend/
    
    # Set proper permissions
    sudo chown -R www-data:www-data /var/www/html/bastian/frontend
    sudo chmod -R 755 /var/www/html/bastian/frontend
    
    cd ..
    log_success "Frontend deployed successfully."
}

# Deploy backend
deploy_backend() {
    log_info "Deploying backend..."
    
    # Copy backend files
    log_info "Copying backend files..."
    sudo mkdir -p /var/www/html/bastian/admin
    sudo cp -r "$BACKEND_DIR"/* /var/www/html/bastian/admin/
    
    # Set proper permissions
    sudo chown -R www-data:www-data /var/www/html/bastian/admin
    sudo chmod -R 755 /var/www/html/bastian/admin
    sudo chmod -R 777 /var/www/html/bastian/admin/application/logs
    sudo chmod -R 777 /var/www/html/bastian/admin/uploads
    
    # Copy production configuration
    if [[ -f "$BACKEND_DIR/application/config/production.php" ]]; then
        sudo cp "$BACKEND_DIR/application/config/production.php" /var/www/html/bastian/admin/application/config/
        log_success "Production configuration copied."
    fi
    
    log_success "Backend deployed successfully."
}

# Configure environment
configure_environment() {
    log_info "Configuring production environment..."
    
    # Set environment variables
    if [[ ! -f "/var/www/html/bastian/.env" ]]; then
        log_info "Creating production environment file..."
        sudo cp "$FRONTEND_DIR/.env.production" /var/www/html/bastian/.env
        log_warning "Please update /var/www/html/bastian/.env with your production values."
    fi
    
    # Configure Apache/Nginx (basic example)
    log_info "Configuring web server..."
    
    # Create Apache virtual host configuration
    sudo tee /etc/apache2/sites-available/bastian.conf > /dev/null <<EOF
<VirtualHost *:80>
    ServerName bastian.ninetriangles.com
    DocumentRoot /var/www/html/bastian/frontend
    
    # Redirect to HTTPS
    Redirect permanent / https://bastian.ninetriangles.com/
</VirtualHost>

<VirtualHost *:443>
    ServerName bastian.ninetriangles.com
    DocumentRoot /var/www/html/bastian/frontend
    
    # SSL Configuration (update paths as needed)
    SSLEngine on
    SSLCertificateFile /path/to/your/certificate.crt
    SSLCertificateKeyFile /path/to/your/private.key
    
    # API Proxy
    ProxyPreserveHost On
    ProxyPass /admin/ http://localhost/bastian/admin/
    ProxyPassReverse /admin/ http://localhost/bastian/admin/
    
    # Security Headers
    Header always set X-Content-Type-Options nosniff
    Header always set X-Frame-Options DENY
    Header always set X-XSS-Protection "1; mode=block"
    Header always set Strict-Transport-Security "max-age=31536000; includeSubDomains"
    
    # Enable compression
    LoadModule deflate_module modules/mod_deflate.so
    <Location />
        SetOutputFilter DEFLATE
        SetEnvIfNoCase Request_URI \
            \.(?:gif|jpe?g|png)$ no-gzip dont-vary
        SetEnvIfNoCase Request_URI \
            \.(?:exe|t?gz|zip|bz2|sit|rar)$ no-gzip dont-vary
    </Location>
    
    ErrorLog \${APACHE_LOG_DIR}/bastian_error.log
    CustomLog \${APACHE_LOG_DIR}/bastian_access.log combined
</VirtualHost>
EOF
    
    log_success "Web server configuration created."
}

# Run security checks
run_security_checks() {
    log_info "Running security checks..."
    
    # Check file permissions
    log_info "Checking file permissions..."
    
    # Ensure sensitive files are not world-readable
    sudo find /var/www/html/bastian -name "*.php" -exec chmod 644 {} \;
    sudo find /var/www/html/bastian -name ".env*" -exec chmod 600 {} \;
    
    # Check for sensitive information in files
    log_info "Checking for sensitive information..."
    
    if grep -r "password\|secret\|key" /var/www/html/bastian/frontend/ 2>/dev/null | grep -v ".min.js" | grep -v ".map"; then
        log_warning "Potential sensitive information found in frontend files. Please review."
    fi
    
    log_success "Security checks completed."
}

# Test deployment
test_deployment() {
    log_info "Testing deployment..."
    
    # Test if web server is responding
    if command -v curl &> /dev/null; then
        if curl -f -s http://localhost/bastian/admin/api/test-reservation > /dev/null; then
            log_success "Backend API is responding."
        else
            log_warning "Backend API test failed. Please check configuration."
        fi
    else
        log_warning "curl not available. Skipping API test."
    fi
    
    # Run the comprehensive test script
    if [[ -f "test-reservation-flow.js" ]]; then
        log_info "Running comprehensive tests..."
        if node test-reservation-flow.js; then
            log_success "All tests passed."
        else
            log_warning "Some tests failed. Please review the output."
        fi
    fi
}

# Main deployment function
main() {
    echo "=========================================="
    echo "  $PROJECT_NAME"
    echo "  Production Deployment Script"
    echo "=========================================="
    echo
    
    check_permissions
    check_prerequisites
    
    log_info "Starting deployment process..."
    
    create_backup
    deploy_frontend
    deploy_backend
    configure_environment
    run_security_checks
    test_deployment
    
    echo
    log_success "Deployment completed successfully!"
    echo
    echo "Next steps:"
    echo "1. Update /var/www/html/bastian/.env with production values"
    echo "2. Configure SSL certificates"
    echo "3. Enable the Apache site: sudo a2ensite bastian"
    echo "4. Restart Apache: sudo systemctl restart apache2"
    echo "5. Test the application thoroughly"
    echo
    log_info "Backup location: $BACKUP_DIR"
}

# Run main function
main "$@"
