import { useState, useEffect } from 'react';
import axios from 'axios';
import { API_URL } from './api_url';

// Secure API wrapper that calls our backend instead of EatApp directly
// This hides all sensitive credentials from the frontend

const API_KEY = '123456789'; // Only our backend API key, not EatApp credentials

const API_HEADERS = {
  'Authorization': API_KEY,
  'Accept': 'application/json',
  'Content-Type': 'application/json'
};

/**
 * Hook to fetch restaurants securely through our backend
 */
const useSecureRestaurants = () => {
  const [restaurants, setRestaurants] = useState(null);
  const [error, setError] = useState('');
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    const fetchRestaurants = async () => {
      try {
        setLoading(true);
        const response = await axios.get(`${API_URL}/api/eatapp/restaurants`, {
          headers: API_HEADERS
        });

        if (response.data && response.data.status && response.data.data) {
          setRestaurants(response.data.data);
        } else {
          setError('Invalid response format from API');
        }
      } catch (err) {
        console.error('Error fetching restaurants:', err);
        setError('Failed to fetch restaurants');
      } finally {
        setLoading(false);
      }
    };

    fetchRestaurants();
  }, []);

  return { 
    restaurants, 
    error,
    loading,
    // Helper getter for the restaurants array
    getRestaurants: () => restaurants?.data || []
  };
};

/**
 * Check availability for a restaurant through our secure backend
 */
const checkAvailability = async (availabilityData) => {
  try {
    const response = await axios.post(
      `${API_URL}/api/eatapp/availability`,
      availabilityData,
      { headers: API_HEADERS }
    );

    if (response.data && response.data.status) {
      return {
        success: true,
        data: response.data.data,
        error: null
      };
    } else {
      return {
        success: false,
        data: null,
        error: response.data.message || 'Failed to check availability'
      };
    }
  } catch (error) {
    console.error('Availability check error:', error);
    return {
      success: false,
      data: null,
      error: error.response?.data?.message || 'Failed to check availability'
    };
  }
};

/**
 * Create a reservation through our secure backend
 */
const createSecureReservation = async (reservationData) => {
  try {
    const response = await axios.post(
      `${API_URL}/api/eatapp/reservations`,
      reservationData,
      { headers: API_HEADERS }
    );

    if (response.data && response.data.status) {
      return {
        success: true,
        data: response.data.data,
        message: response.data.message,
        error: null
      };
    } else {
      return {
        success: false,
        data: null,
        message: response.data.message || 'Failed to create reservation',
        error: response.data.error || 'Unknown error',
        validations: response.data.validations || null
      };
    }
  } catch (error) {
    console.error('Reservation creation error:', error);
    
    let errorMessage = 'Failed to create reservation';
    let validations = null;
    
    if (error.response) {
      switch (error.response.status) {
        case 400:
          errorMessage = 'Please select a restaurant to make a reservation';
          break;
        case 422:
          if (error.response.data?.validations) {
            validations = error.response.data.validations;
            errorMessage = 'Please check your reservation details';
          }
          break;
        default:
          errorMessage = error.response.data?.message || 'Failed to submit reservation. Please try again.';
      }
    }
    
    return {
      success: false,
      data: null,
      message: errorMessage,
      error: error.message,
      validations: validations
    };
  }
};

/**
 * Combined reservation flow that saves to both our database and EatApp
 */
const createFullReservation = async (formData) => {
  try {
    // First, save to our database using existing ReservationForm API
    const backendResponse = await axios.post(
      `${API_URL}/api/reservation-form`,
      { 
        formvalue: {
          restaurant_id: formData.restaurant_id,
          booking_date: formData.booking_date,
          booking_time: formData.booking_time,
          full_name: formData.full_name,
          email: formData.email,
          mobile: formData.mobile,
          pax: formData.pax,
          age: formData.age,
          pincode: formData.pincode,
          comments: formData.comments
        }
      },
      { headers: API_HEADERS }
    );

    console.log('Backend reservation saved:', backendResponse.data);

    // Then, create reservation in EatApp through our secure proxy
    const eatappData = {
      restaurant_id: formData.restaurant_id,
      covers: parseInt(formData.pax),
      start_time: formData.start_time,
      first_name: formData.first_name,
      last_name: formData.last_name,
      email: formData.email,
      phone: formData.mobile,
      notes: formData.comments || ''
    };

    const eatappResponse = await createSecureReservation(eatappData);

    return {
      success: eatappResponse.success,
      data: eatappResponse.data,
      message: eatappResponse.message,
      error: eatappResponse.error,
      validations: eatappResponse.validations,
      backendSaved: backendResponse.data.status === true
    };

  } catch (error) {
    console.error('Full reservation error:', error);
    return {
      success: false,
      data: null,
      message: 'Failed to complete reservation',
      error: error.message,
      validations: null,
      backendSaved: false
    };
  }
};

export { 
  useSecureRestaurants, 
  checkAvailability, 
  createSecureReservation,
  createFullReservation 
};
