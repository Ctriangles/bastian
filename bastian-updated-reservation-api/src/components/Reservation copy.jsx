/* eslint-disable react/prop-types */
import { useState, useEffect } from "react";
import { FaArrowRight } from "react-icons/fa";
import { IoMdClose } from "react-icons/io";
import { FooterSortForms, FooterLongForms } from "../API/reservation";

export default function Reservation({ col }) {
  const [showModal, setShowModal] = useState(false);
  const handleShowModal = () => {
    setShowModal(!showModal);
  };

  useEffect(() => {
    if (showModal) {
      document.body.classList.add("no-scroll");
    } else {
      document.body.classList.remove("no-scroll");
    }
    return () => document.body.classList.remove("no-scroll");
  }, [showModal]);

  const [errorMessage, setErrorMessage] = useState('');
  const [responseData, setResponseData] = useState(null);
  const [successMessage, setSuccessMessage] = useState('');
  const [formData, setFormData] = useState({
    restaurant_id: '',
    booking_date: '',
    booking_time: ''
  });
  const [popupFormData, setPopupFormData] = useState({
    form_id: '',
    full_name: '',
    email: '',
    mobile: '',
    pax: '',
    age: '',
    pincode: ''
  });

  const handleSubmit = async (e) => {
    e.preventDefault();
    setErrorMessage('');
    setResponseData(null);
    try {
      const data = await FooterSortForms(formData);
      setResponseData(data);
      
      // Set form_id in popupFormData after receiving responseData
      if (data.form_id) {
        setPopupFormData((prevData) => ({
          ...prevData,
          form_id: data.form_id,
        }));
      }

      // Clear formData after submission
      setFormData({
        restaurant_id: '',
        booking_date: '',
        booking_time: ''
      });
    } catch (error) {
      console.error('Error details:', error);
      setErrorMessage('Something went wrong, please try again later.');
    } finally {
      handleShowModal(true);
    }
  };

  const handleChange = (e) => {
    const { name, value } = e.target;
    setFormData((prevFormData) => ({
      ...prevFormData,
      [name]: value,
    }));
    //  Pincode Validation: Allow only 6 digits
    if (name === "pincode") {
      newValue = value.replace(/\D/g, ""); // Remove non-numeric characters
      if (newValue.length > 6) newValue = newValue.slice(0, 6);
    }

    //  Mobile Number Validation: Allow only 10 digits
    if (name === "mobile") {
      newValue = value.replace(/\D/g, ""); // Remove non-numeric characters
      if (newValue.length > 10) newValue = newValue.slice(0, 10);
    }
  };

  const handlePopupSubmit = async (e) => {
    e.preventDefault();
    setErrorMessage('');
    try {
      const otherdata = await FooterLongForms(popupFormData);
      //console.log(otherdata);
      if (otherdata.status === true) {
        setSuccessMessage('Form submitted successfully!'); // Set success message
      }
      setPopupFormData({
        form_id: '',
        full_name: '',
        email: '',
        mobile: '',
        pax: '',
        age: '',
        pincode: ''
      });
    } catch (error) {
      console.error('Error details:', error);
      setErrorMessage('Something went wrong, please try again later.');
    } finally {
      handleShowModal(true);
    }
  };

  const handlePopupChange = (e) => {
    const { name, value } = e.target;
    setPopupFormData((prevFormData) => ({
      ...prevFormData,
      [name]: value,
    }));
  };

  return (
    <div className="w-full p-5 md:p-8 h-[520px] md:h-[500px] flex flex-col justify-center items-center gap-10 relative form-popup">
      <h1 className="text-[#F2CA99] text-[24px] md:text-[34px] lg:text-[48px] text-center">
        Make a Reservation
      </h1>
      <form className="w-full" onSubmit={handleSubmit}>
        <div className={`${col ? "flex-col" : "flex-row"} w-full flex gap-10 items-center justify-between md:items-center px-0 lg:px-8`}>
          <div className="form-group w-full custom-icon relative">
            <select name="restaurant_id" className="bg-[#101010] text-white border-2 w-full max-w-[350px] p-4 px-4 text-[16px] md:text-[24px] appearance-none" value={formData.restaurant_id} onChange={handleChange} required>
              <option value="">Select Restaurant</option>
              <option value="43383004">Bastian At The Top</option>
              <option value="98725763">Bastian Bandra</option>
              <option value="92788130">Bastian Garden City</option>
            </select>
          </div>
          <div className="form-group w-full custom-icon calender relative">
            <input type="date" name="booking_date" className="bg-[#101010] text-white border-2 w-full max-w-[350px] p-4 px-4 text-xl" value={formData.booking_date} onChange={handleChange} required />
          </div>
          <div className="form-group w-full custom-icon relative">
            <input type="time" name="booking_time" className="bg-[#101010] text-white border-2 w-full max-w-[350px] p-4 px-4 text-xl appearance-none" value={formData.booking_time} onChange={handleChange} required />
          </div>
        </div>
        <button type="submit" className="w-full text-center mt-12 cursor-pointer text-[#F2CA99] text-[12px] md:text-[24px] flex items-center gap-1 justify-center">
          Book now <FaArrowRight className="text-[10px]" />
        </button>
        {errorMessage && <p className="text-red-500">{errorMessage}</p>}
        {successMessage && <p className="text-[#00FF00] mt-4">{successMessage}</p>}
      </form>

      {showModal && (
        <div className="max-w-[90%] mx-auto md:max-w-[500px] w-full bg-black/80 z-[99] h-[550px] form-popup backdrop-blur-sm absolute border flex flex-col items-center justify-center w-full border-text-primary rounded-md p-2">
          <div className="w-full text-text-primary flex justify-between items-center p-2">
            <h1>Reservation</h1>
            <IoMdClose onClick={handleShowModal} className="cursor-pointer" />
          </div>
          {responseData && (
            <>
              <div className="box-wrapper w-full flex flex-wrap justify-between px-2">
                <select className="text-[#FFFFFF] w-half w-full bg-[#101010] border border-text-primary mb-6 text-sm text-text-primary"></select>
                <p className="text-[#FFFFFF] w-half bg-[#101010] border border-text-primary mb-2 text-sm text-text-primary"><div className="label">Booking Date:</div> {responseData.booking_date}</p>
                <p className="text-[#FFFFFF] w-half bg-[#101010] border border-text-primary mb-2 text-sm text-text-primary"><div className="label">Booking Time:</div> {responseData.booking_time}</p>
              </div>
            </>
          )}
          <form className="w-full" onSubmit={handlePopupSubmit}>
            <div className="flex flex-col justify-center gap-[15px] mt-2">
              <div className="flex justify-center items-center gap-2 p-2 pb-0">
                <input type="text" name="full_name" placeholder="Full Name" value={popupFormData.full_name} onChange={handlePopupChange} required className="bg-[#101010] border border-text-primary w-full p-2 px-1 text-sm text-text-primary" />
                <input type="hidden" value={popupFormData.form_id} name="form_id"/>
                <input type="email" name="email" placeholder="Email ID" value={popupFormData.email} onChange={handlePopupChange} required className="bg-[#101010] border border-text-primary w-full p-2 px-1 text-sm text-text-primary" />
              </div>
              <div className="flex justify-center items-center gap-2 p-2 pb-0">
                <input type="text" name="mobile" placeholder="Contact Number" value={popupFormData.mobile} onChange={handlePopupChange} required className="bg-[#101010] border border-text-primary w-full p-2 px-1 text-sm text-text-primary" />
                <input type="number" name="pax" placeholder="Pax" value={popupFormData.pax} onChange={handlePopupChange} required className="bg-[#101010] border border-text-primary w-full p-2 px-1 text-sm text-text-primary" />
              </div>
              <div className="flex justify-center items-center gap-2 p-2 pb-0">
                <input type="number" name="age" placeholder="Age" value={popupFormData.age} onChange={handlePopupChange} required className="bg-[#101010] border border-text-primary w-full p-2 px-1 text-sm text-text-primary" />
                <input type="number" name="pincode" placeholder="Pincode" value={popupFormData.pincode} onChange={handlePopupChange} className="bg-[#101010] border border-text-primary w-full p-2 px-1 text-sm text-text-primary" />
              </div>
              <div className="p-2">
                <p className="text-white text-center text-[14px] mb-4">Fill this in to become part of the Bastian community</p>
                <button type="submit" className="p-1 w-full bg-text-primary rounded-md">Book</button>
              </div>
            </div>
          </form>
        </div>
      )}
    </div>
  );
}
