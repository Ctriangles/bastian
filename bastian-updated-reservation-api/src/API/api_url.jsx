// SIMPLE ENVIRONMENT CONFIGURATION
// Just comment/uncomment the environment you want to use

// LOCAL DEVELOPMENT (Comment this block for other environments)
// const API_URL = "http://localhost/bastian_parent/bastian/admin"; // Local development (2 restaurants)
// const APP_URL = "http://localhost/bastian_parent/bastian/";

// UAT ENVIRONMENT (Uncomment this block for UAT, comment above block)
const API_URL = "https://bastian.ninetriangles.com/admin"; // UAT Environment
const APP_URL = "https://bastian.ninetriangles.com/";

// PRODUCTION ENVIRONMENT (Uncomment this block for Production, comment above blocks)
// const API_URL = "https://bastianhospitality.com/admin"; // Production Environment
// const APP_URL = "https://bastianhospitality.com/";


// ⚠️ SECURITY NOTE: EatApp credentials have been moved to backend for security
// Frontend now uses secure proxy endpoints instead of direct EatApp API calls
// This prevents exposure of sensitive API keys in browser inspect element


// UNIFIED RESTAURANT API (SECURE) - All restaurant operations through one API
const UNIFIED_RESTAURANT_API = {
  RESTAURANTS: `${API_URL}/api/eatapp/restaurants`,
  AVAILABILITY: `${API_URL}/api/eatapp/availability`,
  RESERVATIONS: `${API_URL}/api/eatapp_controller/create_reservation`,
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
  RESERVATIONS: `${API_URL}/api/eatapp_controller/create_reservation`, // Fixed: Use correct endpoint
  RESTAURANTS: `${API_URL}/api/eatapp/restaurants`,
};

export { API_URL, Apis, APP_URL, SECURE_EATAPP, UNIFIED_RESTAURANT_API };
