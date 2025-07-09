import { useState } from "react";
import bg from "../assets/Images/careerbg.png";
import HeroSection from "../components/HeroSection";
import bgGredientImage from "../assets/Images/homeBannerGradient.png";
import ReCAPTCHA from 'react-google-recaptcha';
import { FaArrowRight } from "react-icons/fa";
import { CareerForm } from "../API/career"
import { Helmet } from 'react-helmet';

export default function Career() {
  const HeroImgText = {
    heading1: "Careers",
  };
  const [errorMessage, setErrorMessage] = useState('');
  const [loading, setLoading] = useState(false);
  const [recaptchaValue, setRecaptchaValue] = useState(null);
  const [formData, setFormData] = useState({
    department: '',
    full_name: '',
    contact_number: '',
    email_id: ''
  });
  const handleRecaptchaChange = (value) => {
    setRecaptchaValue(value);
  };
  const handleSubmit = async (e) => {
    e.preventDefault();
    if (!recaptchaValue) {
      alert("Please complete the reCAPTCHA");
    } else {
      setErrorMessage('');
      setLoading(true);
      try {
          const data = await CareerForm(formData);
          setFormData({
            department: '',
            full_name: '',
            contact_number: '',
            email_id: ''
          });
          //setErrors({});
          if (data.status === true) {
            alert("Thank you for submitting your details. Our HR team will be in touch with you suitably.");
          }
      } catch (error) {
          setErrorMessage('Something went wrong, please try again later.');
      } finally {
        setLoading(false); 
      }
  }
};
const handleChange = (e) => {
  const { name, value, type, checked } = e.target;
  if (type === 'checkbox') {
      setFormData(prevFormData => ({
          ...prevFormData,
          classes: checked
              ? [...prevFormData.classes, value]
              : prevFormData.classes.filter(item => item !== value)
      }));
  } else {
      setFormData({ ...formData, [name]: value });
  }
};
  return (
    <div className="w-full h-auto min-h-screen page-height career-page">
      <Helmet>
<title>Careers at Bastian - Join Us</title>
<meta 
name="description" 
content="Explore exciting career opportunities and become a part of Bastian's dynamic team." 
/>
</Helmet>
      <div>
        <HeroSection
          bg={bg}
          bg2={bg}
          HeroImgText={HeroImgText}
          bgGredientImage={bgGredientImage}
        />
      </div>
      <div className="form-section mx-auto max-w-[730px] px-4 mt-6">
        <form className="w-full" onSubmit={handleSubmit}>
          <div className="flex flex-col justify-center gap-[8px] mt-2">
            <div className="form-group w-full custom-icon relative mb-4">
              <select
                name="department"
                required
                className="bg-[#000] border border-text-primary w-full p-3 px-6 text-text-primary rounded-md text-[16px] md:text-[20px] appearance-none" value={formData.department} onChange={handleChange}>
                <option value="" disabled selected>
                Job Department
                </option>
                <option value="Operations">Operations</option>
                <option value="Marketing">Marketing</option>
                <option value="Sales">Sales</option>
                <option value="F&B">F&B</option>
                <option value="Reservations">Reservations</option>
                <option value="Guest Relations">Guest Relations</option>
                <option value="Human Resources">Human Resources</option>
              </select>
            </div>
            <div className="form-group w-full mb-4">
              <input
                type="text"
                placeholder="Name"
                name="full_name"
                required
                value={formData.full_name} 
                onChange={handleChange}
                className="bg-[#000] border border-text-primary w-full p-3 px-6 text-[16px] md:text-[20px] text-text-primary rounded-md"
              />
            </div>
            <div className="form-group w-full mb-4">
              <input
                type="number"
                placeholder="Contact Number"
                name="contact_number"
                required
                value={formData.contact_number} 
                onChange={handleChange}
                className="bg-[#000] border border-text-primary w-full p-3 px-6 text-[16px] md:text-[20px] text-text-primary rounded-md"
              />
            </div>
            <div className="form-group w-full mb-4">
              <input
                type="email"
                placeholder="Enter email address"
                name="email_id"
                required
                value={formData.email_id} 
                onChange={handleChange}
                className="bg-[#000] border border-text-primary w-full p-3 px-6 text-[16px] md:text-[20px] text-text-primary rounded-md"
              />
            </div>
            <div className="form-group w-full my-5"> <ReCAPTCHA
          sitekey="6LcKi3kqAAAAAC3y8p4RlrxPBgf42qRInxRghNTP"
          onChange={handleRecaptchaChange}
        />
            <button type="submit" disabled={loading} className={`bg-text-primary text-white p-2 rounded-md mt-4 w-full ${loading ? 'cursor-not-allowed' : ''}`}>
            {loading ? ('Sending...') : ('Submit')}
            </button>
              
              {errorMessage && <div className="successmessage"><p className="error text-text-primary">{errorMessage}</p></div>}
            </div>
          </div>
        </form>
      </div>
      <div>
        <div className="w-full mt-4 mb-8 md:mb-16 px-4">
          <div>
              <p className="text-white text-[20px] md:text-[26px] lg:text-[32px] text-center">Alternatively, email us at <a href="mailto:recruitment@bastianhospitality.com" className="text-text-primary">recruitment@bastianhospitality.com</a></p>
          </div>
        </div>
      </div>
    </div>
  );
}
