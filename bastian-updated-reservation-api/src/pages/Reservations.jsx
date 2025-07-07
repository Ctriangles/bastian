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
    full_name: "",
    email: "",
    mobile: "",
    pax: "",
    age: "",
    pincode: "",
  });

  const handleSubmit = async (e) => {
    e.preventDefault();

    if (!recaptchaValue) {
      alert("Please complete the reCAPTCHA");
    } else {
      setErrorMessage("");
      setLoading(true);
      try {
        const data = await HeaderForms(formData);
        //console.log('Form submitted successfully:', data);
        setFormData({
          restaurant_id: "",
          booking_date: "",
          full_name: "",
          email: "",
          mobile: "",
          pax: "",
          age: "",
          pincode: "",
        });
        if (data.status === true) {
          setErrorMessage(
            "Thank you for submitting your details. A Bastian reservation executive will call you in 24 hours."
          );
        }
      } catch (error) {
        setErrorMessage("Something went wrong, please try again later.");
      } finally {
        setLoading(false); // Set loading to false when the request is completed (either success or failure)
      }
    }
     //  Check if mobile number is exactly 10 digits
     if (formData.mobile.length !== 10) {
      alert("Mobile number must be exactly 10 digits.");
      return;
    }
    //  Check if pincode is exactly 6 digits
    if (formData.pincode.length !== 6) {
      alert("Pincode must be exactly 6 digits.");
      return;
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
                    >
                      <option value="">Select Restaurant</option>
                      <option value="43383004">Bastian At The Top</option>
                      <option value="98725763">Bastian Bandra</option>
                      <option value="51191537">Inka by Bastian</option>
                      <option value="10598428">Bastian Empire (Pune)</option>
                      <option value="92788130">
                        Bastian Garden City (Bengaluru)
                      </option>
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
