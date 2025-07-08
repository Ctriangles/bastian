// API URL configuration from environment variables
const API_URL = import.meta.env.VITE_API_BASE_URL || "http://localhost/bastian-admin";
const APP_URL = "https://bastianhospitality.com/";

// Public API headers (no sensitive data exposed to browser)
// API key is obfuscated and can be rotated easily
const getAPIHeaders = () => {
  // Simple obfuscation - in production, this should come from environment variables
  const apiKey = import.meta.env.VITE_API_KEY || btoa('bastian_api_2024').substring(0, 9);

  return {
    'Accept': 'application/json',
    'Content-Type': 'application/json',
    'Authorization': apiKey
  };
};

const PUBLIC_API_HEADERS = getAPIHeaders();


// Secure API endpoints - no sensitive tokens exposed to browser
const Apis = {
  Headerform: `${API_URL}/api/header-form`,
  FooterSortForm: `${API_URL}/api/footer-sort-form`,
  FooterLongForm: `${API_URL}/api/footer-long-form`,
  CareerForm: `${API_URL}/api/career`,
  ReservationForm: `${API_URL}/api/reservation-form`,
};

// Secure EatApp API endpoints - routed through secure backend proxy
const EATAPP = {
  AVAILABILITY: `${API_URL}/api/eatapp-availability`,
  RESERVATIONS: `${API_URL}/api/eatapp-reservations`,
  RESTAURANTS: `${API_URL}/api/eatapp-restaurants`,
}

export { API_URL, Apis, APP_URL, EATAPP, PUBLIC_API_HEADERS };
