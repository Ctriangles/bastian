//const API_URL = "";
const API_URL = "http://localhost/bastian/admin";
// const API_URL = "https://bastianhospitality.com/admin";
// const API_URL = "https://bastian.ninetriangles.com/admin";
const APP_URL = "https://bastianhospitality.com/";

// Secure API headers for backend communication (no sensitive data exposed)
const SECURE_API_HEADERS = {
  'Authorization': '123456789', // Backend API key
  'Accept': 'application/json',
  'Content-Type': 'application/json'
};


const Apis = {
  Headerform: `${API_URL}/api/header-form`,
  FooterSortForm: `${API_URL}/api/footer-sort-form`,
  FooterLongForm: `${API_URL}/api/footer-long-form`,
  CareerForm: `${API_URL}/api/career`,
  ReservationForm: `${API_URL}/api/reservation-form`,
};

// Secure EatApp API endpoints - routed through backend wrapper
const EATAPP = {
  AVAILABILITY: `${API_URL}/api/eatapp-availability`,
  RESERVATIONS: `${API_URL}/api/eatapp-reservations`,
  RESTAURANTS: `${API_URL}/api/eatapp-restaurants`,
}

export { API_URL, Apis, APP_URL, EATAPP, SECURE_API_HEADERS };
