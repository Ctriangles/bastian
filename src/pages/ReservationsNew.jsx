import { useState, useEffect } from "react";
import bg from "../assets/Images/careerbg.png";
import HeroSection from "../components/HeroSection";
import bgGredientImage from "../assets/Images/homeBannerGradient.png";
import { IoMdClose } from "react-icons/io";
import DatePicker from "react-datepicker";
import "react-datepicker/dist/react-datepicker.css";
import ReCAPTCHA from "react-google-recaptcha";
import success from "../assets/logo/success-icon.svg";
import { useRestaurants } from "../API/user-reservation.jsx";
import React from "react";
import { Helmet } from "react-helmet";
import axios from 'axios';
import { QRCodeSVG } from 'qrcode.react';
import { EATAPP, EATAPP_API_HEADERS } from "../API/api_url";
import ReservationsEatApp from "../components/ReservationEatApp.jsx";


const HeroImgText = {
  heading1: "Make A Reservation",
};

const ReservationsNew = () => {

  return (
    <div className="relative">
      
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
        <ReservationsEatApp />
      </div>
    </div>
  );
};

export default ReservationsNew;
