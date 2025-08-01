//const API_URL = "";
// const API_URL = "http://localhost/bastian";
// const API_URL = "https://bastianhospitality.com/admin";
// const API_URL = "https://bastian.ninetriangles.com/admin";
// const API_URL = "http://localhost/bastian-admin"; // Local development
const API_URL = "https://bastian.ninetriangles.com/admin"; // Production URL
const APP_URL = "https://bastian.ninetriangles.com/";

// ⚠️ SECURITY NOTE: EatApp credentials have been moved to backend for security
// Frontend now uses secure proxy endpoints instead of direct EatApp API calls
// This prevents exposure of sensitive API keys in browser inspect element


const Apis = {
  Headerform: `${API_URL}/api/header-form`,
  FooterSortForm: `${API_URL}/api/footer-sort-form`,
  FooterLongForm: `${API_URL}/api/footer-long-form`,
  CareerForm: `${API_URL}/api/career`,
  ReservationForm: `${API_URL}/api/reservation-form`,
};

// Secure EatApp proxy endpoints (credentials hidden in backend)
const SECURE_EATAPP = {
  AVAILABILITY: `${API_URL}/api/eatapp/availability`,
  RESERVATIONS: `${API_URL}/api/eatapp/reservations`,
  RESTAURANTS: `${API_URL}/api/eatapp/restaurants`,
};

export { API_URL, Apis, APP_URL, SECURE_EATAPP };
