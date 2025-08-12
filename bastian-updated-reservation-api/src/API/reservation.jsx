import axios from "axios";
import { Apis, UNIFIED_RESTAURANT_API } from './api_url.jsx';

const HeaderForms = async (formvalue) => {
    const apiKey = '123456789';
    console.log("🌐 API DEBUG: HeaderForms called with:", formvalue);
    console.log("🔗 API DEBUG: API endpoint:", UNIFIED_RESTAURANT_API.SUBMIT_FORM);
    
    try {
        const requestData = { 
            form_type: 'header-form',
            formvalue 
        };
        console.log("📤 API DEBUG: Request data being sent:", requestData);
        console.log("🔑 API DEBUG: Using API key:", apiKey);
        
        const response = await axios.post(UNIFIED_RESTAURANT_API.SUBMIT_FORM, requestData, {
            headers: {
                'Authorization': apiKey,
                'Content-Type': 'application/json',
            },
        });
        
        console.log("📥 API DEBUG: Raw response received:");
        console.log("📊 Response status:", response.status);
        console.log("📋 Response headers:", response.headers);
        console.log("📦 Response data:", response.data);
        
        return response.data;
    } catch (error) {
        console.error('💥 API DEBUG: HeaderForms error occurred:');
        console.error('📋 Error object:', error);
        console.error('📋 Error message:', error?.message);
        console.error('📋 Error response status:', error?.response?.status);
        console.error('📋 Error response data:', error?.response?.data);
        console.error('📋 Error config:', error?.config);
        throw error;
    }
};
const FooterSortForms = async (formvalue) => {
    const apiKey = '123456789';
    try {
        const response = await axios.post(UNIFIED_RESTAURANT_API.SUBMIT_FORM, { 
            form_type: 'footer-sort-form',
            formvalue 
        }, {
            headers: {
                'Authorization': apiKey,
                'Content-Type': 'application/json',
            },
        });
        //console.log(response.data);
        return response.data;
    } catch (error) {
        console.error('Error fetching contact form data:', error);
        throw error;
    }
};
const FooterLongForms = async (formvalue) => {
    const apiKey = '123456789';
    try {
        console.log({formvalue});
        const response = await axios.post(UNIFIED_RESTAURANT_API.SUBMIT_FORM, { 
            form_type: 'footer-long-form',
            formvalue 
        }, {
            headers: {
                'Authorization': apiKey,
                'Content-Type': 'application/json',
            },
        });
        //console.log(response.data);
        return response.data;
    } catch (error) {
        console.error('Error fetching contact form data:', error);
        throw error;
    }
};
const ReservationForm = async (formvalue) => {
    const apiKey = '123456789';
    try {
        const response = await axios.post(UNIFIED_RESTAURANT_API.SUBMIT_FORM, { 
            form_type: 'reservation-form',
            formvalue 
        }, {
            headers: {
                'Authorization': apiKey,
                'Content-Type': 'application/json',
            },
        });
        console.log(response.data);
        return response.data;
    } catch (error) {
        console.error('Error fetching contact form data:', error);
        throw error;
    }
};

// New function to create reservation with EatApp API
const CreateReservation = async (reservationData) => {
    const apiKey = '123456789';
    try {
        const response = await axios.post(UNIFIED_RESTAURANT_API.SUBMIT_FORM, {
            form_type: 'reservation-form',
            formvalue: reservationData
        }, {
            headers: {
                'Authorization': apiKey,
                'Content-Type': 'application/json',
            },
        });
        console.log('Reservation Response:', response.data);
        return response.data;
    } catch (error) {
        console.error('Error creating reservation:', error);
        throw error;
    }
};

// Debug function to test reservation creation and payment URL extraction
const DebugReservation = async (reservationData) => {
    const apiKey = '123456789';
    try {
        const response = await axios.post(UNIFIED_RESTAURANT_API.DEBUG_RESERVATION, reservationData, {
            headers: {
                'Authorization': apiKey,
                'Content-Type': 'application/json',
            },
        });
        console.log('Debug Reservation Response:', response.data);
        return response.data;
    } catch (error) {
        console.error('Error in debug reservation:', error);
        throw error;
    }
};

export { HeaderForms, FooterSortForms, FooterLongForms, ReservationForm, CreateReservation, DebugReservation };