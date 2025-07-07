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
        const response = await axios.post(Apis.ReservationForm, { formvalue }, {
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
export { HeaderForms, FooterSortForms, FooterLongForms, ReservationForm };