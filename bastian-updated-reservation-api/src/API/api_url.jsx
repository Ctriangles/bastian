// Environment-aware API configuration
// Automatically detects local vs production environment

// Detect environment based on hostname
const isLocal = window.location.hostname === 'localhost' || 
                window.location.hostname.includes('bastian_parent') ||
                window.location.hostname === '127.0.0.1';

// Set API URLs based on environment
// Use a host-relative API URL in production so the frontend talks to the same origin
// This avoids incorrect calls to localhost when the app is deployed under a different host
const API_URL = isLocal
  ? "http://localhost/bastian_parent/bastian/admin"
  : '/admin';

const APP_URL = isLocal
  ? "http://localhost/bastian_parent/bastian"
  : '/';

// ⚠️ SECURITY NOTE: EatApp credentials have been moved to backend for security
// Frontend now uses secure proxy endpoints instead of direct EatApp API calls
// This prevents exposure of sensitive API keys in browser inspect element

// UNIFIED RESTAURANT API (SECURE) - All restaurant operations through one API
const UNIFIED_RESTAURANT_API = {
  RESTAURANTS: `${API_URL}/api/eatapp/restaurants`,
  AVAILABILITY: `${API_URL}/api/eatapp/availability`,
  RESERVATIONS: `${API_URL}/api/eatapp/reservations`,
  DEBUG_RESERVATION: `${API_URL}/api/debug_controller/test_reservation`,
  SUBMIT_FORM: `${API_URL}/api/reservation-form`,
};

// LEGACY API ENDPOINTS (DEPRECATED - FOR BACKWARD COMPATIBILITY)
const Apis = {
  Headerform: `${API_URL}/api/header-form`,
  FooterSortForm: `${API_URL}/api/footer-sort-form`,
  FooterLongForm: `${API_URL}/api/footer-long-form`,
  CareerForm: `${API_URL}/api/career`,
  ReservationForm: `${API_URL}/api/reservation-form`,
};

// DEPRECATED: Use UNIFIED_RESTAURANT_API instead
const SECURE_EATAPP = {
  AVAILABILITY: `${API_URL}/api/eatapp/availability`,
  RESERVATIONS: `${API_URL}/api/eatapp/reservations`,
  RESTAURANTS: `${API_URL}/api/eatapp/restaurants`,
};

// Environment information for debugging
const ENV_INFO = {
  isLocal,
  hostname: window.location.hostname,
  apiUrl: API_URL,
  appUrl: APP_URL,
  environment: isLocal ? 'local' : 'production'
};

export { API_URL, Apis, APP_URL, SECURE_EATAPP, UNIFIED_RESTAURANT_API, ENV_INFO };
