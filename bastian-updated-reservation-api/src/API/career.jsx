import axios from "axios";
import { Apis } from './api_url.jsx';

const CareerForm = async (formvalue) => {
    const apiKey = '123456789';
    try {
        const response = await axios.post(Apis.CareerForm, { formvalue }, {
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
export { CareerForm };