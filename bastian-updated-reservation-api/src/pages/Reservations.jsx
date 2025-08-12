import { useState, useEffect } from "react";
import bg from "../assets/Images/careerbg.png";
import HeroSection from "../components/HeroSection";
import bgGredientImage from "../assets/Images/homeBannerGradient.png";
import { IoMdClose } from "react-icons/io";
import { ImUser } from "react-icons/im";
import { BsFillPhoneFill } from "react-icons/bs";
import { SiMinutemailer } from "react-icons/si";
import { IoPeopleSharp } from "react-icons/io5";
import { MdKeyboardArrowDown, MdKeyboardArrowUp } from "react-icons/md";
import { Link, useNavigate } from "react-router-dom";
import DatePicker from "react-datepicker";
import "react-datepicker/dist/react-datepicker.css";
import ReCAPTCHA from "react-google-recaptcha";

import { HeaderForms } from "../API/reservation";
import { useSecureRestaurants } from "../API/secure-reservation.jsx";
import { API_URL } from "../API/api_url.jsx";
import axios from "axios";

import React from "react";
import { Helmet } from 'react-helmet';
const HeroImgText = {
  heading1: "Make A Reservation",
};
const Header = () => {
  const [showMenu, setShowMenu] = useState(false);
  const [isSticky, setIsSticky] = useState(false);
  const [showModal, setShowModal] = useState(false);
  const [error, setError] = useState("");
  const [loading, setLoading] = useState(false);
  const [recaptchaValue, setRecaptchaValue] = useState(null);
  
  // Fetch restaurants from secure API
  const { restaurants, error: restaurantsError, loading: restaurantsLoading, getRestaurants } = useSecureRestaurants();
  const handleRecaptchaChange = (value) => {
    setRecaptchaValue(value);
  };
  const handleDateChange = (date) => {
    setFormData({
      ...formData,
      booking_date: date,
    });
    setError("");
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
  const [formData, setFormData] = useState({
    restaurant_id: "",
    booking_date: "",
    booking_time: "",
    full_name: "",
    email: "",
    mobile: "",
    pax: "",
    age: "",
    pincode: "",
  });

  // State for available time slots
  const [availableTimeSlots, setAvailableTimeSlots] = useState([]);
  const [loadingTimeSlots, setLoadingTimeSlots] = useState(false);

  // Function to fetch available time slots
  const fetchAvailableTimeSlots = async (restaurantId, bookingDate, pax) => {
    if (!restaurantId || !bookingDate || !pax) {
      console.log("🕐 TIME SLOTS DEBUG: Missing required data for fetching time slots");
      return;
    }

    console.log("🕐 TIME SLOTS DEBUG: Fetching time slots for:", {
      restaurantId,
      bookingDate,
      pax
    });

    setLoadingTimeSlots(true);
    setAvailableTimeSlots([]);

    try {
      const availabilityData = {
        restaurant_id: restaurantId,
        earliest_start_time: `${bookingDate}T09:00:00`,
        latest_start_time: `${bookingDate}T23:00:00`,
        covers: parseInt(pax)
      };

      console.log("🕐 TIME SLOTS DEBUG: Calling availability API with:", availabilityData);

      const response = await axios.post(
        `${API_URL}/api/eatapp/availability`,
        availabilityData,
        {
          headers: {
            'Authorization': '123456789',
            'Content-Type': 'application/json',
          },
        }
      );

      console.log("🕐 TIME SLOTS DEBUG: Availability API response:", response.data);

      if (response.data.status && response.data.data) {
        const timeSlots = response.data.data.data || [];
        console.log("🕐 TIME SLOTS DEBUG: Available time slots:", timeSlots);
        setAvailableTimeSlots(timeSlots);
      } else {
        console.log("🕐 TIME SLOTS DEBUG: No time slots available");
        setAvailableTimeSlots([]);
      }
    } catch (error) {
      console.error("🕐 TIME SLOTS DEBUG: Error fetching time slots:", error);
      setAvailableTimeSlots([]);
    } finally {
      setLoadingTimeSlots(false);
    }
  };

  // Effect to fetch time slots when restaurant, date, or pax changes
  useEffect(() => {
    if (formData.restaurant_id && formData.booking_date && formData.pax) {
      fetchAvailableTimeSlots(formData.restaurant_id, formData.booking_date, formData.pax);
    } else {
      setAvailableTimeSlots([]);
    }
  }, [formData.restaurant_id, formData.booking_date, formData.pax]);

  const handleSubmit = async (e) => {
    e.preventDefault();
    
    console.log("🔵 RESERVATION DEBUG: Form submission started");
    console.log("📋 Form Data:", formData);
    console.log("🔐 ReCAPTCHA Value:", recaptchaValue);

    if (!recaptchaValue) {
      console.log("❌ RESERVATION DEBUG: ReCAPTCHA not completed");
      alert("Please complete the reCAPTCHA");
      return;
    }
    
    //  Check if mobile number is exactly 10 digits
    if (formData.mobile.length !== 10) {
      console.log("❌ RESERVATION DEBUG: Invalid mobile number length:", formData.mobile.length);
      alert("Mobile number must be exactly 10 digits.");
      return;
    }
    
    //  Check if pincode is exactly 6 digits
    if (formData.pincode.length !== 6) {
      console.log("❌ RESERVATION DEBUG: Invalid pincode length:", formData.pincode.length);
      alert("Pincode must be exactly 6 digits.");
      return;
    }

    // Check if booking time is selected
    if (!formData.booking_time) {
      console.log("❌ RESERVATION DEBUG: No booking time selected");
      alert("Please select a booking time.");
      return;
    }

    console.log("✅ RESERVATION DEBUG: All validations passed, calling API...");
    setErrorMessage("");
    setLoading(true);
    
    try {
      console.log("🚀 RESERVATION DEBUG: Calling HeaderForms API with data:", formData);
      const data = await HeaderForms(formData);
      console.log("📦 RESERVATION DEBUG: API Response received:", data);
      console.log("📊 RESERVATION DEBUG: Response status:", data?.status);
      console.log("💬 RESERVATION DEBUG: Response message:", data?.message);
      
      setFormData({
        restaurant_id: "",
        booking_date: "",
        booking_time: "",
        full_name: "",
        email: "",
        mobile: "",
        pax: "",
        age: "",
        pincode: "",
      });
      
      if (data.status === true) {
        console.log("✅ RESERVATION DEBUG: Success - showing success message");
        setErrorMessage(
          "Thank you for submitting your details. A Bastian reservation executive will call you in 24 hours."
        );
      } else {
        console.log("⚠️ RESERVATION DEBUG: API returned false status");
        console.log("📝 RESERVATION DEBUG: Error details:", data);
        setErrorMessage(data?.message || "Failed to create reservation. Please try again.");
      }
    } catch (error) {
      console.log("💥 RESERVATION DEBUG: API call failed with error:");
      console.error("📋 Error object:", error);
      console.error("📋 Error message:", error?.message);
      console.error("📋 Error response:", error?.response);
      console.error("📋 Error response data:", error?.response?.data);
      console.error("📋 Error response status:", error?.response?.status);
      setErrorMessage("Something went wrong, please try again later.");
    } finally {
      console.log("🔚 RESERVATION DEBUG: Form submission completed, setting loading to false");
      setLoading(false);
    }
  };
  const handleChange = (e) => {
    const { name, value, type, checked } = e.target;

    if (type === "checkbox") {
      setFormData((prevFormData) => ({
        ...prevFormData,
        classes: checked
          ? [...prevFormData.classes, value]
          : prevFormData.classes.filter((item) => item !== value),
      }));
    } else {
      let newValue = value;

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

      setFormData((prevFormData) => ({
        ...prevFormData,
        [name]: newValue,
      }));
    }
  };
  const restaurantOpeningDate = new Date("2025-02-28");
  const minBookingDateFor10598428 = new Date(restaurantOpeningDate);
  const maxBookingDateFor10598428 = new Date(restaurantOpeningDate);
  maxBookingDateFor10598428.setDate(restaurantOpeningDate.getDate() + 15);
  return (
    <div className="relative">
      {/* Modal for Reservation */}
      <div className="w-full h-auto min-h-screen page-height career-page">
      <Helmet>
<title>Bastian Reservations - Book a Table</title>
<meta 
name="description" 
content="Reserve your table at Bastian and enjoy an unforgettable dining experience." 
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
        <div className="w-full text-text-primary relative mb-6 text-center">
          <p className="text-white xl:text-[20px] sm:text-[16px]">
            Fill in the form to join Bastian's exclusive community of
            indulgence.
          </p>
        </div>

        <div className="header-popup max-w-[90%] mx-auto md:max-w-[500px] w-full bg-black/90 backdrop-blur-sm border border-text-primary rounded-md p-2 md:py-6 mb-12">
          <form className="w-full" onSubmit={handleSubmit}>
            <div className="flex flex-col justify-center gap-[20px] mt-2">
              <div className="flex justify-center items-center gap-2 p-2 py-0">
                <div className="inner-data-form w-full">
                  <div className="form-group w-full custom-icon relative">
                    <select
                      name="restaurant_id"
                      className={`bg-[#101010] text-white border border-text-primary w-full max-w-[350px] p-2 px-1 outline-none !text-[14px] appearance-none ${
                        formData.restaurant_id
                          ? "!text-text-primary"
                          : "text-[#a9a9a9]"
                      }`}
                      value={formData.restaurant_id}
                      onChange={handleChange}
                      required
                      disabled={restaurantsLoading}
                    >
                      <option value="">
                        {restaurantsLoading ? "Loading restaurants..." :
                         restaurantsError ? "Failed to fetch restaurants" :
                         "Select Restaurant"}
                      </option>
                      {!restaurantsLoading && !restaurantsError && getRestaurants().map(restaurant => (
                        <option key={restaurant.id} value={restaurant.id}>
                          {restaurant.attributes.name}
                        </option>
                      ))}
                    </select>
                  </div>
                </div>
              </div>
              <div className="flex justify-center items-center gap-2 p-2 py-0">
                <div className="w-full" style={{ zIndex: "70" }}>
                  <DatePicker
                    selected={formData.booking_date}
                    onChange={handleDateChange}
                    className={`bg-[#101010] border border-text-primary w-full p-2 px-1 text-sm outline-none ${
                      formData.booking_date
                        ? "text-text-primary"
                        : "text-[#6d6969]"
                    }`}
                    placeholderText="dd-mm-yyyy"
                    dateFormat="dd-MMM-yyyy"
                    minDate={
                      formData.restaurant_id === "511915371"
                        ? minBookingDateFor10598428
                        : new Date()
                    }
                    maxDate={
                      formData.restaurant_id === "511915371"
                        ? maxBookingDateFor10598428
                        : new Date(
                            new Date().setDate(new Date().getDate() + 15)
                          )
                    }
                    filterDate={(date) =>
                      !(
                        ["43383004", "51191537", "10598428"].includes(formData.restaurant_id) &&
                        date.getDay() === 1
                      )
                    } // Disables Mondays for selected restaurants
                    required
                  />
                </div>
                <div className="relative w-full">
                  <IoPeopleSharp className="absolute left-[10px] text-[20px] top-[10px] text-[#6d6969]" />
                  <input
                    type="number"
                    name="pax"
                    placeholder="People"
                    value={formData.pax}
                    onChange={handleChange}
                    required
                    className="bg-[#101010] border border-text-primary p-2 px-1 pl-[40px] text-sm text-text-primary outline-none w-full min-h-[41px]"
                  />
                </div>
              </div>
              
              {/* Time Slot Selection */}
              <div className="flex justify-center items-center gap-2 p-2 py-0">
                <div className="w-full">
                  <select
                    name="booking_time"
                    className={`bg-[#101010] text-white border border-text-primary w-full p-2 px-1 outline-none !text-[14px] appearance-none ${
                      formData.booking_time
                        ? "!text-text-primary"
                        : "text-[#a9a9a9]"
                    }`}
                    value={formData.booking_time}
                    onChange={handleChange}
                    required
                    disabled={loadingTimeSlots || availableTimeSlots.length === 0}
                  >
                    <option value="">
                      {loadingTimeSlots ? "Loading time slots..." :
                       availableTimeSlots.length === 0 ? "Select date, restaurant & people first" :
                       "Select Time Slot"}
                    </option>
                    {availableTimeSlots.map((slot, index) => {
                      const startTime = new Date(slot.attributes.start_time);
                      const timeString = startTime.toLocaleTimeString('en-US', {
                        hour: '2-digit',
                        minute: '2-digit',
                        hour12: true
                      });
                      const timeValue = startTime.toTimeString().slice(0, 8); // HH:MM:SS format
                      
                      return (
                        <option key={index} value={timeValue}>
                          {timeString}
                        </option>
                      );
                    })}
                  </select>
                </div>
              </div>
              
              <div className="flex justify-center items-center gap-2 p-2 py-0 relative">
                <input
                  type="text"
                  name="full_name"
                  placeholder="Full Name"
                  value={formData.full_name}
                  onChange={handleChange}
                  required
                  className="bg-[#101010] border border-text-primary w-full p-2 px-1 pl-[30px] text-sm text-text-primary outline-none"
                />
                <ImUser className="absolute left-[10px] text-[20px] text-[#6d6969]" />
                <input
                  type="hidden"
                  value={formData.form_id}
                  name="form_id"
                  required
                />
              </div>
              <div className="flex justify-center items-center gap-2 p-2 py-0 relative">
                <input
                  type="email"
                  name="email"
                  placeholder="Email ID"
                  value={formData.email}
                  onChange={handleChange}
                  required
                  className="bg-[#101010] border border-text-primary w-full p-2 px-1 pl-[30px] text-sm text-text-primary outline-none"
                />
                <SiMinutemailer className="absolute left-[10px] text-[20px] text-[#6d6969]" />
                <input type="hidden" value={formData.form_id} name="form_id" />
              </div>
              <div className="flex justify-center items-center gap-2 p-2 py-0 relative">
                <input
                  type="text"
                  value={"+" + 91}
                  className="absolute w-[30px] left-[35px] bg-transparent border-0 outline-none text-[#6d6969]"
                />
                <input
                  type="number"
                  name="mobile"
                  placeholder="Contact Number"
                  value={formData.mobile}
                  onChange={handleChange}
                  required
                  className="bg-[#101010] border border-text-primary w-full p-2 px-1 pl-[60px] text-sm text-text-primary outline-none"
                />
                <BsFillPhoneFill className="absolute left-[10px] text-[20px] text-[#6d6969]" />
              </div>
              <div className="flex justify-center items-center gap-2 p-2 py-0">
                <select
                  name="age"
                  className={`bg-[#101010] border border-text-primary w-full p-2 px-1 text-sm outline-none ${
                    formData.age ? "text-text-primary" : "text-[#a9a9a9]"
                  }`}
                  value={formData.age}
                  onChange={handleChange}
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
                  value={formData.pincode}
                  onChange={handleChange}
                  required
                  className="bg-[#101010] border border-text-primary w-full p-2 px-1 text-sm text-text-primary outline-none"
                />
              </div>

              <div className="p-2">
                <ReCAPTCHA
                  sitekey="6LcKi3kqAAAAAC3y8p4RlrxPBgf42qRInxRghNTP"
                  onChange={handleRecaptchaChange}
                />
                <button
                  type="submit"
                  disabled={loading} // Disable the button if loading is true
                  className={`text-white bg-[#F2CA99] p-2 rounded-md mt-4 w-full ${
                    loading ? "cursor-not-allowed" : ""
                  }`}
                >
                  {loading ? "Sending..." : "Submit Request"}
                </button>
                {errorMessage && (
                  <p className="text-red-500 w-full text-center text-[20px]">
                    {errorMessage}
                  </p>
                )}
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  );
};

export default Header;
