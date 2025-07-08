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
        // Use secure backend wrapper instead of direct EatApp API call
        const response = await axios.get(Apis.EatAppRestaurants, {
          headers: {
            'Authorization': '123456789', // Internal API key
            'Content-Type': 'application/json'
          }
        });

        // The API returns data in the format:
        // {
        //   data: [...],
        //   meta: {...},
        //   links: {...}
        // }
        if (response.data && response.data.data) {
          setRestaurants(response.data);
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

export { useRestaurants };

