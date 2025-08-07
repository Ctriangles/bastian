//const API_URL = "";
// const API_URL = "http://localhost/bastian";
// const API_URL = "https://bastianhospitality.com/admin";
// const API_URL = "https://bastian.ninetriangles.com/admin";
const API_URL = "http://localhost/bastian_parent/bastian/admin"; // Local development (2 restaurants)
// const API_URL = "https://bastian.ninetriangles.com/admin"; // Production URL (5 restaurants) - COMMENTED OUT
const APP_URL = "https://bastian.ninetriangles.com/";

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
  RESERVATIONS: `${API_URL}/api/eatapp/reservations`,
  RESTAURANTS: `${API_URL}/api/eatapp/restaurants`,
};

export { API_URL, Apis, APP_URL, SECURE_EATAPP, UNIFIED_RESTAURANT_API };
