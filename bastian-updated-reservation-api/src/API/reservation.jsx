import axios from "axios";
import { Apis, PUBLIC_API_HEADERS } from './api_url.jsx';

const HeaderForms = async (formvalue) => {
    try {
        const response = await axios.post(Apis.Headerform, { formvalue }, {
            headers: PUBLIC_API_HEADERS,
        });
        //console.log(response.data);
        return response.data;
    } catch (error) {
        console.error('Error fetching contact form data:', error);
        throw error;
    }
};
const FooterSortForms = async (formvalue) => {
    try {
        const response = await axios.post(Apis.FooterSortForm, { formvalue }, {
            headers: PUBLIC_API_HEADERS,
        });
        //console.log(response.data);
        return response.data;
    } catch (error) {
        console.error('Error fetching contact form data:', error);
        throw error;
    }
};
const FooterLongForms = async (formvalue) => {
    try {
        console.log({formvalue});
        const response = await axios.post(Apis.FooterLongForm, { formvalue }, {
            headers: PUBLIC_API_HEADERS,
        });
        //console.log(response.data);
        return response.data;
    } catch (error) {
        console.error('Error fetching contact form data:', error);
        throw error;
    }
};
const ReservationForm = async (formvalue) => {
    try {
        const response = await axios.post(Apis.ReservationForm, { formvalue }, {
            headers: PUBLIC_API_HEADERS,
        });
        console.log(response.data);
        return response.data;
    } catch (error) {
        console.error('Error fetching contact form data:', error);
        throw error;
    }
};
export { HeaderForms, FooterSortForms, FooterLongForms, ReservationForm };