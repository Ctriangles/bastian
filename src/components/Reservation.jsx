/* eslint-disable react/prop-types */
import { useState, useEffect } from "react";
import { FaArrowRight } from "react-icons/fa";
import { IoMdClose } from "react-icons/io";
import { FooterSortForms, FooterLongForms } from "../API/reservation";
import { IoPeopleSharp } from "react-icons/io5";
import { ImUser } from "react-icons/im";
import { BsFillPhoneFill } from "react-icons/bs";
import { SiMinutemailer } from "react-icons/si";
import DatePicker from "react-datepicker";
import "react-datepicker/dist/react-datepicker.css";
import ReCAPTCHA from 'react-google-recaptcha';
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

  const [errorMessage, setErrorMessage] = useState("");
  const [responseData, setResponseData] = useState(null);
  const [successMessage, setSuccessMessage] = useState(false);
  const [selectedOption, setSelectedOption] = useState('');
  const [selectedDate, setSelectedDate] = useState(null);
  const [selectedPax, setSelectedPax] = useState(null);
  const [recaptchaValue, setRecaptchaValue] = useState(null);
  const [loading, setLoading] = useState(false);
  const [error, setError] = useState("");
  useEffect(() => {
    if (successMessage) {
      const timer = setTimeout(() => setSuccessMessage(false), 10000);
      return () => clearTimeout(timer);
    }
  }, [successMessage]);
  const [formData, setFormData] = useState({
    restaurant_id: "",
    booking_date: null,
    pax: "",
  });
  const handleDateChange = (date) => {
    setFormData({
      ...formData,
      booking_date: date,
    });
    setError("");
  };
  const [popupFormData, setPopupFormData] = useState({
    form_id: "",
    restaurant_id: "",
    booking_date: "",
    full_name: "",
    email: "",
    mobile: "",
    pax: "",
    age: "",
    pincode: "",
  });
  const handleSubmit = async (e) => {
    e.preventDefault();
    setErrorMessage("");
    setSuccessMessage("");
    setResponseData(null);
    if (!formData.restaurant_id || !/^\d{1,2}$/.test(formData.pax)) {
      setErrorMessage("Please fill all fields correctly");
      return;
    }
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
        restaurant_id: "",
        booking_date: "",
        pax: "",
      });
    } catch (error) {
      console.error("Error details:", error);
      setErrorMessage("Something went wrong, please try again later.");
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
  };
  const handleRecaptchaChange = (value) => {
    setRecaptchaValue(value);
  };
  const handlePopupSubmit = async (e) => {
    e.preventDefault();

    //  Check if mobile number is exactly 10 digits
    if (popupFormData.mobile.length !== 10) {
      alert("Mobile number must be exactly 10 digits.");
      return;
    }
    // Check if pincode is exactly 6 digits
    if (popupFormData.pincode.length !== 6) {
      alert("Pincode must be exactly 6 digits.");
      return;
    }

    if (!recaptchaValue) {
      alert("Please complete the reCAPTCHA");
    } else {
      setErrorMessage("");
      setLoading(true);
      try {
        const otherdata = await FooterLongForms(popupFormData);
        // console.log(otherdata);
        if (otherdata.status === true) {
          setSuccessMessage("Thank you for submitting your details. A Bastian reservation executive will call you in 24 hours."); // Set success message
        }
        setPopupFormData({
          form_id: "",
          restaurant_id: "",
          booking_date: "",
          full_name: "",
          email: "",
          mobile: "",
          pax: "",
          age: "",
          pincode: "",
        });
      } catch (error) {
        console.error("Error details:", error);
        setErrorMessage("Something went wrong, please try again later.");
      } finally {
        // handleShowModal(true);
        setSelectedOption(responseData.restaurant_id);
        setLoading(false);
      }
    }
  };
  const handlePopupChange = (e) => {
    const { name, value } = e.target;
    let newValue = value;

    if (name === "pincode" || name === "mobile") {
      newValue = value.replace(/\D/g, ""); // Allow only numbers
    }

    if (name === "pincode") {
      newValue = newValue.slice(0, 6); // Limit to 6 digits
    } else if (name === "mobile") {
      newValue = newValue.slice(0, 10); // Limit to 10 digits
    }

    setPopupFormData((prevFormData) => ({
      ...prevFormData,
      [name]: newValue, // ✅ Correctly update only relevant fields
    }));
  };

  useEffect(() => {
    if (responseData && responseData.booking_date) {
      setSelectedDate(new Date(responseData.booking_date));
    }
    if (responseData && responseData.pax) {
      setSelectedPax(responseData.pax);
    }
    if (responseData && responseData.restaurant_id) {
      setSelectedOption(responseData.restaurant_id);
    }
  }, [responseData]);
  const handlePopupDateChange = (date) => {
    setSelectedDate(date);
  };
  const handlePaxChange = (event) => {
    setSelectedPax(event.target.value); // Update the pax value when user changes it
  };
  const handleSlectChange = (event) => {
    setSelectedOption(event.target.value);
  };
  const restaurantOpeningDate = new Date("2025-02-28");
  const minBookingDateFor10598428 = new Date(restaurantOpeningDate);
  const maxBookingDateFor10598428 = new Date(restaurantOpeningDate);
  maxBookingDateFor10598428.setDate(restaurantOpeningDate.getDate() + 15);
  return (
    <div className="home-form w-full p-5 md:p-8 h-[520px] md:h-[500px] flex flex-col justify-center items-center gap-10 relative form-popup">
      <h1 className="text-[#F2CA99] text-[24px] md:text-[34px] lg:text-[48px] text-center">
        Make A Reservation
      </h1>
      <form className="w-full" onSubmit={handleSubmit}>
        <div
          className={`${col ? "flex-col" : "flex-row"
            } w-full flex gap-10 items-center justify-between md:items-center px-0 lg:px-8`}
        >
          <div className="form-group w-full custom-icon relative">
            <select
              name="restaurant_id"
              className="bg-[#101010] text-white border-2 w-full max-w-[350px] p-3 px-4 text-[16px] md:text-[24px] appearance-none"
              value={formData.restaurant_id}
              onChange={handleChange}
            >
              <option value="">Select Restaurant</option>
              <option value="43383004">Bastian At The Top</option>
              <option value="98725763">Bastian Bandra</option>
              <option value="51191537">Inka by Bastian</option>
              <option value="10598428">Bastian Empire (Pune)</option>
              <option value="92788130">Bastian Garden City (Bengaluru)</option>
            </select>
          </div>
          <div className="form-group w-full custom-icon calender relative" style={{ zIndex: "70" }}>
            <DatePicker
              selected={formData.booking_date}
              onChange={handleDateChange}
              className="bg-[#101010] text-white border-2 w-full max-w-[350px] p-4 px-4 text-xl"
              placeholderText="dd-mm-yyyy"
              dateFormat="dd-MMM-yyyy"
              minDate={formData.restaurant_id === "511915371" ? minBookingDateFor10598428 : new Date()}
              maxDate={formData.restaurant_id === "511915371" ? maxBookingDateFor10598428 : new Date(new Date().setDate(new Date().getDate() + 15))}
              filterDate={(date) =>
                !(
                  ["43383004", "51191537", "10598428"].includes(formData.restaurant_id) &&
                  date.getDay() === 1
                )
              } // Disables Mondays for selected restaurants
              required
            />
          </div>
          <div className="form-group w-full relative">
            <IoPeopleSharp className="absolute left-[10px] text-[24px] top-[20px] text-[#fff]" />
            <input
              type="number"
              name="pax"
              placeholder="People"
              value={formData.pax}
              onChange={handleChange}
              maxLength="2"
              pattern="\d*"
              className="outline-none bg-[#101010] text-white border-2 w-full max-w-[350px] p-4 px-4 pl-[40px] text-xl appearance-none"
            />
          </div>
        </div>
        <button
          type="submit"
          className="w-full text-center mt-12 cursor-pointer text-[#F2CA99] text-[12px] md:text-[24px] flex items-center gap-1 justify-center"
        >
          Book Now <FaArrowRight className="text-[10px]" />
        </button>
        {errorMessage && (
          <p className="text-text-primary w-full text-center text-[20px]">
            {errorMessage}
          </p>
        )}
      </form>
      {showModal && (
        <div
          className={`${showModal ? "block" : "hidden"
            } fixed inset-0 bg-black bg-opacity-90 h-auto flex items-center justify-center z-[9999]`}
        >
          <div style={{ zIndex: "71" }} className="mt-[90px] header-popup max-w-[90%] mx-auto md:max-w-[500px] w-full bg-black/90 z-[99] h-auto py-6 form-popup backdrop-blur-sm absolute border flex flex-col items-center justify-center w-full border-text-primary rounded-md p-2">
            <div className="w-full text-text-primary pt-0 p-2 mb-1">

              {!successMessage && (
                <>
                  <h1 className="text-[24px] pr-[40px] leading-[1] py-1">
                    Make A Reservation
                  </h1>
                  <p className="text-white text-[14px]">
                    Fill in the form to join Bastian's exclusive community of indulgence.
                  </p>
                </>
              )}
              <span className="cross-icon absolute right-[0] top-[4px] text-white border border-text-primary w-[25px] h-[25px] rounded-full flex items-center justify-center cursor-pointer">
                <IoMdClose
                  onClick={handleShowModal}
                  className="cursor-pointer text-[16px]"
                />
              </span>
            </div>
            {successMessage ? (
              <p className="text-text-primary w-full text-center text-[20px]">{successMessage}</p>
            ) : (
              <form className="w-full" onSubmit={handlePopupSubmit}>
                <div className="flex flex-col justify-center gap-[15px] mt-0">
                  <div className="flex justify-center items-center gap-2 p-2 py-0">
                    <div className="inner-data-form w-full">
                      <div className="form-group w-full custom-icon relative">
                        <select
                          name="restaurant_id"
                          className={`bg-[#101010] text-white border border-text-primary w-full max-w-[350px] p-2 px-1 outline-none !text-[14px] appearance-none ${formData.restaurant_id
                              ? "!text-text-primary"
                              : "text-[#a9a9a9]"
                            }`}
                          value={selectedOption}
                          onChange={handleSlectChange}
                          disabled
                        >
                          <option value="">Select Restaurant</option>
                          <option value="43383004">Bastian At The Top</option>
                          <option value="98725763">Bastian Bandra</option>
                          <option value="92788130">Bastian Garden City (Bengaluru)</option>
                          <option value="10598428">Bastian Empire (Pune)</option>
                          <option value="51191537">Inka by Bastian</option>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div className="flex justify-center items-center gap-2 p-2 py-0">
                    <div className="w-full">
                      <DatePicker
                        selected={selectedDate}
                        onChange={handlePopupDateChange}
                        className={`bg-[#101010] border border-text-primary w-full p-2 px-1 text-sm outline-none ${formData.booking_date
                            ? "text-text-primary"
                            : "text-[#6d6969]"
                          }`}
                        placeholderText="dd-mm-yyyy"
                        value={selectedDate}
                        dateFormat="dd-MMM-yyyy"
                        name="booking_date"
                        disabled
                      />
                    </div>
                    <div className="relative w-full">
                      <IoPeopleSharp className="absolute left-[10px] text-[20px] top-[10px] text-[#6d6969]" />
                      <input
                        type="number"
                        name="pax"
                        placeholder="People"
                        value={selectedPax}
                        onChange={handlePaxChange}
                        required
                        disabled
                        className="bg-[#101010] border border-text-primary p-2 px-1 pl-[40px] text-sm text-text-primary outline-none w-full min-h-[30px]"
                      />
                    </div>
                  </div>
                  <div className="flex justify-center items-center gap-2 p-2 py-0 relative">
                    <input
                      type="text"
                      name="full_name"
                      placeholder="Full Name"
                      value={popupFormData.full_name}
                      onChange={handlePopupChange}
                      required
                      className="bg-[#101010] border border-text-primary w-full p-2 px-1 pl-[30px] text-sm text-text-primary outline-none"
                    />
                    <ImUser className="absolute left-[10px] text-[20px] text-[#6d6969]" />
                    <input
                      type="hidden"
                      value={popupFormData.form_id}
                      name="form_id"
                    />
                  </div>
                  <div className="flex justify-center items-center gap-2 p-2 py-0 relative">
                    <input
                      type="email"
                      name="email"
                      placeholder="Email ID"
                      value={popupFormData.email}
                      onChange={handlePopupChange}
                      required
                      className="bg-[#101010] border border-text-primary w-full p-2 px-1 pl-[30px] text-sm text-text-primary outline-none"
                    />
                    <SiMinutemailer className="absolute left-[10px] text-[20px] text-[#6d6969]" />
                    <input
                      type="hidden"
                      value={popupFormData.form_id}
                      name="form_id"
                    />
                  </div>
                  <div className="flex justify-center items-center gap-2 p-2 mb-0 py-0 relative">
                    <input
                      type="text"
                      value={"+" + 91}
                      className="absolute w-[30px] left-[35px] bg-transparent border-0 outline-none text-[#6d6969]"
                    />
                    <input
                      type="number"
                      name="mobile"
                      placeholder="Contact Number"
                      value={popupFormData.mobile}
                      onChange={handlePopupChange}
                      required
                      className="bg-[#101010] border border-text-primary w-full p-2 px-1 pl-[60px] text-sm text-text-primary outline-none"
                    />
                    <BsFillPhoneFill className="absolute left-[10px] text-[20px] text-[#6d6969]" />
                  </div>
                  <div className="flex justify-center items-center gap-2 p-2 py-0">
                    <select
                      name="age"
                      className={`bg-[#101010] border border-text-primary w-full p-2 px-1 text-sm outline-none ${popupFormData.age ? "text-text-primary" : "text-[#a9a9a9]"
                        }`}
                      value={popupFormData.age}
                      onChange={handlePopupChange}
                      required
                    >
                      <option value="">Select Age Range</option>
                      <option value="25-35">25-35</option>
                      <option value="36-45">36-45</option>
                      <option value="46-55">46-55</option>
                      <option value="55+">55+</option>
                    </select>
                    <input
                      type="number"
                      name="pincode"
                      placeholder="Pincode"
                      value={popupFormData.pincode}
                      onChange={handlePopupChange}
                      className="bg-[#101010] border border-text-primary w-full p-[5px] px-1 text-sm text-text-primary outline-none"
                    />
                  </div>
                  <div className="p-2"><ReCAPTCHA
                    sitekey="6LcKi3kqAAAAAC3y8p4RlrxPBgf42qRInxRghNTP"
                    onChange={handleRecaptchaChange}
                  />
                    <button
                      type="submit"
                      disabled={loading} // Disable the button if loading is true
                      className={`bg-text-primary text-white p-2 rounded-md mt-2 w-full ${loading ? 'cursor-not-allowed' : ''}`}
                    >
                      {loading ? (
                        'Sending...'
                      ) : (
                        'Submit Request'
                      )}
                    </button>
                  </div>
                </div>
              </form>
            )}
          </div>
        </div>
      )}
    </div>
  );
}
