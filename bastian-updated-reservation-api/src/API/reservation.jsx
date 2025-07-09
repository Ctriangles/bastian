import axios from "axios";
import { Apis } from './api_url.jsx';

const HeaderForms = async (formvalue) => {
    const apiKey = '123456789';
    try {
        const response = await axios.post(Apis.Headerform, { formvalue }, {
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
const FooterSortForms = async (formvalue) => {
    const apiKey = '123456789';
    try {
        const response = await axios.post(Apis.FooterSortForm, { formvalue }, {
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
        const response = await axios.post(Apis.FooterLongForm, { formvalue }, {
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
        console.log('ReservationForm API called with:', formvalue);
        console.log('API URL:', Apis.ReservationForm);
        console.log('Request payload:', { formvalue });

        const response = await axios.post(Apis.ReservationForm, { formvalue }, {
            headers: {
                'Authorization': apiKey,
                'Content-Type': 'application/json',
            },
        });
        console.log('ReservationForm API response:', response.data);
        return response.data;
    } catch (error) {
        console.error('ReservationForm API error:', error);
        console.error('Error response:', error.response?.data);
        console.error('Error status:', error.response?.status);
        throw error;
    }
};

const GetAvailability = async (restaurant_id, date, covers) => {
    const apiKey = '123456789';
    try {
        console.log('GetAvailability called with:', { restaurant_id, date, covers });

        const response = await axios.post(Apis.EatAppAvailability, {
            restaurant_id,
            date,
            covers
        }, {
            headers: {
                'Authorization': apiKey,
                'Content-Type': 'application/json',
            },
        });

        console.log('GetAvailability response:', response.data);
        return response.data;
    } catch (error) {
        console.error('Error fetching availability data:', error);
        console.error('Error details:', {
            message: error.message,
            response: error.response?.data,
            status: error.response?.status
        });
        throw error;
    }
};

export { HeaderForms, FooterSortForms, FooterLongForms, ReservationForm, GetAvailability };