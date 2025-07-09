import { useState, useEffect } from 'react';
import axios from 'axios';
import { Apis } from './api_url';

// Secure implementation - EatApp credentials are now hidden in backend
// All API calls go through secure backend wrapper

const useRestaurants = () => {
  const [restaurants, setRestaurants] = useState(null);
  const [error, setError] = useState('');
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    const fetchRestaurants = async () => {
      try {
        setLoading(true);
        setError(''); // Clear previous errors

        console.log('Fetching restaurants from:', Apis.EatAppRestaurants);

        // Use secure backend wrapper instead of direct EatApp API call
        const response = await axios.get(Apis.EatAppRestaurants, {
          headers: {
            'Authorization': '123456789', // Internal API key
            'Content-Type': 'application/json'
          },
          timeout: 10000 // 10 second timeout
        });

        console.log('Restaurants API response:', response.data);

        // Check if the response has the expected structure
        if (response.data && response.data.status === true && response.data.data) {
          setRestaurants(response.data.data);
        } else if (response.data && response.data.data) {
          // Fallback for direct EatApp format
          setRestaurants(response.data);
        } else {
          console.error('Invalid response format:', response.data);
          setError('Invalid response format from API');
          // Set fallback data to prevent crashes
          setRestaurants({
            data: [
              {
                id: "74e1a9cc-bad1-4217-bab5-4264a987cd7f",
                type: "restaurant",
                attributes: {
                  name: "Bastian Test",
                  available_online: true
                }
              }
            ]
          });
        }
      } catch (err) {
        console.error('Error fetching restaurants:', err);
        setError('Failed to fetch restaurants');
        // Set fallback data to prevent crashes
        setRestaurants({
          data: [
            {
              id: "74e1a9cc-bad1-4217-bab5-4264a987cd7f",
              type: "restaurant",
              attributes: {
                name: "Bastian Test",
                available_online: true
              }
            }
          ]
        });
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

export { useRestaurants };

