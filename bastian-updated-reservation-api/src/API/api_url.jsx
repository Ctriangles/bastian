//const API_URL = "";
const API_URL = "http://localhost/bastian-admin";
// const API_URL = "https://bastianhospitality.com/admin";
// const API_URL = "https://bastian.ninetriangles.com/admin";
const APP_URL = "https://bastianhospitality.com/";

// Public API headers (no sensitive data exposed to browser)
const PUBLIC_API_HEADERS = {
  'Accept': 'application/json',
  'Content-Type': 'application/json'
  // Note: No authorization tokens here - handled securely on backend
};


// Secure API endpoints - no sensitive tokens exposed to browser
const Apis = {
  Headerform: `${API_URL}/api/secure_proxy/header_form`,
  FooterSortForm: `${API_URL}/api/secure_proxy/footer_short_form`,
  FooterLongForm: `${API_URL}/api/secure_proxy/footer_long_form`,
  CareerForm: `${API_URL}/api/career`,
  ReservationForm: `${API_URL}/api/secure_proxy/reservation_form`,
};

// Secure EatApp API endpoints - routed through secure backend proxy
const EATAPP = {
  AVAILABILITY: `${API_URL}/api/secure_proxy/eatapp_availability`,
  RESERVATIONS: `${API_URL}/api/secure_proxy/eatapp_reservations`,
  RESTAURANTS: `${API_URL}/api/secure_proxy/eatapp_restaurants`,
}

export { API_URL, Apis, APP_URL, EATAPP, PUBLIC_API_HEADERS };
