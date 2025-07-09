// API Configuration - Secure implementation
// EatApp credentials are now hidden in backend for security
//const API_URL = "";
const API_URL = "http://localhost/bastian-admin"; // For local development
// const API_URL = "https://bastianhospitality.com/admin";
// const API_URL = "https://bastian.ninetriangles.com/admin";
const APP_URL = "https://bastianhospitality.com/";


// API Endpoints - All external API calls are now proxied through secure backend
const Apis = {
  Headerform: `${API_URL}/api/header-form`,
  FooterSortForm: `${API_URL}/api/footer-sort-form`,
  FooterLongForm: `${API_URL}/api/footer-long-form`,
  CareerForm: `${API_URL}/api/career`,
  ReservationForm: `${API_URL}/api/reservation-form`,
  // Secure EatApp wrapper endpoints (credentials hidden in backend)
  EatAppRestaurants: `${API_URL}/index.php/api/Form_controller/getRestaurants`,
  EatAppAvailability: `${API_URL}/index.php/api/Form_controller/getAvailability`,
};

export { API_URL, Apis, APP_URL };
