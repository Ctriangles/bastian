import axios from "axios";
import { EATAPP, PUBLIC_API_HEADERS } from './api_url.jsx';

// Mock data for development/fallback - matching the expected API format
const MOCK_AVAILABILITY = {
  data: {
    id: "availability-1",
    type: "availability",
    attributes: {
      available: [
        "2025-07-07T18:00:00Z",
        "2025-07-07T18:30:00Z",
        "2025-07-07T19:00:00Z",
        "2025-07-07T19:30:00Z",
        "2025-07-07T20:00:00Z",
        "2025-07-07T20:30:00Z"
      ]
    }
  }
};

// Secure EatApp API service - all sensitive credentials are handled on backend
class EatAppSecureAPI {

  // Get restaurants list
  static async getRestaurants() {
    try {
      const response = await axios.get(EATAPP.RESTAURANTS, {
        headers: PUBLIC_API_HEADERS,
      });
      return response.data;
    } catch (error) {
      console.error('Error fetching restaurants:', error);
      throw error;
    }
  }

  // Get availability for a restaurant
  static async getAvailability(requestData) {
    try {
      const response = await axios.post(EATAPP.AVAILABILITY, requestData, {
        headers: PUBLIC_API_HEADERS,
      });
      return response.data;
    } catch (error) {
      console.error('Error fetching availability, using mock data:', error);
      // Return mock availability data as fallback with dynamic date
      return new Promise((resolve) => {
        setTimeout(() => {
          // Generate time slots for the requested date
          const requestedDate = requestData.earliest_start_time ?
            requestData.earliest_start_time.split('T')[0] :
            new Date().toISOString().split('T')[0];

          const timeSlots = [
            `${requestedDate}T18:00:00Z`,
            `${requestedDate}T18:30:00Z`,
            `${requestedDate}T19:00:00Z`,
            `${requestedDate}T19:30:00Z`,
            `${requestedDate}T20:00:00Z`,
            `${requestedDate}T20:30:00Z`
          ];

          resolve({
            data: {
              id: "availability-1",
              type: "availability",
              attributes: {
                available: timeSlots
              }
            }
          });
        }, 500);
      });
    }
  }

  // Create a reservation
  static async createReservation(reservationData) {
    try {
      console.log('Sending reservation data to EatApp:', reservationData);
      const response = await axios.post(EATAPP.RESERVATIONS, reservationData, {
        headers: PUBLIC_API_HEADERS,
      });
      console.log('EatApp reservation response:', response);

      // Note: Production backend submission is handled automatically by the backend
      // when the EatApp reservation is processed through our secure API wrapper.
      // This ensures all sensitive credentials remain on the server side.

      return response;
    } catch (error) {
      console.error('Error creating reservation:', error);
      console.error('Error response:', error.response?.data);
      console.error('Error status:', error.response?.status);

      // Throw the actual error so we can see what's happening
      throw error;
    }
  }
}

export default EatAppSecureAPI;
