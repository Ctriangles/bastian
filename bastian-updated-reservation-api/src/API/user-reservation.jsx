import { useState, useEffect } from 'react';
import EatAppSecureAPI from './eatapp-secure.jsx';

// Temporary mock data for restaurants while backend is being deployed
const MOCK_RESTAURANTS = {
  data: [
    {
      id: "1",
      type: "restaurant",
      attributes: {
        name: "Bastian Test",
        slug: "bastian-test",
        description: "Contemporary seafood restaurant",
        cuisine_types: ["Seafood", "Continental"],
        location: {
          address: "B/1, New Kamal Building, Linking Road, Bandra West, Mumbai",
          city: "Mumbai",
          state: "Maharashtra"
        }
      }
    },
    {
      id: "2",
      type: "restaurant",
      attributes: {
        name: "Bastian test 2",
        slug: "bastian-test-2",
        description: "Premium seafood dining experience",
        cuisine_types: ["Seafood", "Continental"],
        location: {
          address: "Level 1, Palladium Mall, High Street Phoenix, Lower Parel, Mumbai",
          city: "Mumbai",
          state: "Maharashtra"
        }
      }
    }
  ],
  meta: {
    total: 2
  }
};

const useRestaurants = () => {
  const [restaurants, setRestaurants] = useState(null);
  const [error, setError] = useState('');
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    const fetchRestaurants = async () => {
      try {
        setLoading(true);

        // Try to fetch from API first, fallback to mock data
        try {
          const response = await EatAppSecureAPI.getRestaurants();
          if (response && response.data) {
            setRestaurants(response);
            return;
          }
        } catch (apiError) {
          console.warn('API not available, using mock data:', apiError);
        }

        // Use mock data as fallback
        setTimeout(() => {
          setRestaurants(MOCK_RESTAURANTS);
        }, 500); // Simulate API delay

      } catch (err) {
        console.error('Error fetching restaurants:', err);
        setError('Failed to fetch restaurants');
      } finally {
        setTimeout(() => {
          setLoading(false);
        }, 500);
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

