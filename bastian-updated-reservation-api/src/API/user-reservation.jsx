import { useState, useEffect } from 'react';
import axios from 'axios';
// Note: This file is deprecated - use secure-reservation.jsx instead

const API_BASE_URL = 'https://api.eat-sandbox.co/concierge/v2';
const API_HEADERS = {
  'Authorization': `Bearer eyJhbGciOiJIUzI1NiJ9.eyJleHAiOjE4OTIwNzM2MDAsImlhdCI6MTc0NTgxOTQ0NSwiaWQiOiJkOWZkNTI0Mi04YmQzLTQ1NDYtODNlNy1jZjU1NzY5MDI0MTIiLCJtb2RlbCI6IkNvbmNpZXJnZSIsImp0aSI6IjFkYWU1ZjYyOWM3M2VmOTU3M2U0IiwiYnkiOiJhbGlAZWF0YXBwLmNvIn0.ZCEiRP1gqPNvJEFYDVCk1uA6o0MSD2pzXu88eGh8xt0`,
  'X-Group-ID': '4bcc6bdd-765b-4486-83ab-17c175dc3910',
  'Accept': 'application/json'
};

const useRestaurants = () => {
  const [restaurants, setRestaurants] = useState(null);
  const [error, setError] = useState('');
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    const fetchRestaurants = async () => {
      try {
        setLoading(true);
        // This file is deprecated - use secure-reservation.jsx instead
        throw new Error('This API is deprecated. Use secure-reservation.jsx instead.');

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

