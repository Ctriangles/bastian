//const API_URL = "";
// const API_URL = "http://localhost/bastian";
// const API_URL = "https://bastianhospitality.com/admin";
const API_URL = "https://bastian.ninetriangles.com/admin";
const APP_URL = "https://bastianhospitality.com/";
const EATAPP_CONCIERGE_API_URL = 'https://api.eat-sandbox.co/concierge/v2';
const EatAppAuthKey = `Bearer eyJhbGciOiJIUzI1NiJ9.eyJleHAiOjE4OTIwNzM2MDAsImlhdCI6MTc0NTgxOTQ0NSwiaWQiOiJkOWZkNTI0Mi04YmQzLTQ1NDYtODNlNy1jZjU1NzY5MDI0MTIiLCJtb2RlbCI6IkNvbmNpZXJnZSIsImp0aSI6IjFkYWU1ZjYyOWM3M2VmOTU3M2U0IiwiYnkiOiJhbGlAZWF0YXBwLmNvIn0.ZCEiRP1gqPNvJEFYDVCk1uA6o0MSD2pzXu88eGh8xt0`;
const EatAppGroupID = '4bcc6bdd-765b-4486-83ab-17c175dc3910';

const EATAPP_API_HEADERS = {
  'Authorization': EatAppAuthKey,
  'X-Group-ID': EatAppGroupID,
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
const EATAPP = {
  AVAILABILITY: `${EATAPP_CONCIERGE_API_URL}/availability`,
  RESERVATIONS: `${EATAPP_CONCIERGE_API_URL}/reservations`,
  RESTAURANTS: `${EATAPP_CONCIERGE_API_URL}/restaurants`,
}
export { API_URL, Apis, APP_URL, EATAPP, EATAPP_API_HEADERS };
