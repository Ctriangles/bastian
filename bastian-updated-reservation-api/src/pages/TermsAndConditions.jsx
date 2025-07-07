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
    heading1: "Bastian Hospitality Reservations T&Cs",
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
<title>Bastian Terms & Conditions</title>
<meta 
name="description" 
content="Review the terms and conditions governing the use of Bastian Hospitality's services." 
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
      <div>
        <div className="w-full mt-4 mb-8 md:mb-16 px-4">
          <div>
            <p className="text-white text-[16px] md:text-[20px] lg:text-[24px] text-center">Please take the time to read through these important reservations T&Cs.</p>
          </div>
          <div className="p-6 text-white text-center md:text-left">
            
            <div className="mb-8">
              <h2 className="text-xl font-bold mb-2">Admission & Conduct</h2>
              <p className="mb-2">The Right of Admission is Reserved. The Company/Management retain the right to refuse entry.</p>
              <p>We operate a zero-tolerance policy towards abuse aimed at our staff or guests.</p>
            </div>

            <div className="mb-8">
              <h2 className="text-xl font-bold mb-2">Deposits/Minimum Spend</h2>
              <ul className="list-disc list-inside">
                <li>
                  <span className="font-semibold">Bastian At The Top, Mumbai,</span> requires a reservation confirmation deposit of
                  <span className="font-semibold"> 2,000 INR</span> per person as per the minimum spend policy.
                </li>
                <li>
                  <span className="font-semibold">Bastian, Garden City, Bangalore,</span> requires a reservation confirmation deposit of
                  <span className="font-semibold"> 1,500 INR</span> per person.
                </li>
                <li>
                  <span className="font-semibold">Bastian Empire, Pune,</span> requires a reservation confirmation deposit of
                  <span className="font-semibold"> 1,000 INR</span> per person.
                </li>
                <li>Bastian Bandra, Mumbai may require a confirmation deposit. Information available on booking.</li>
              </ul>
            </div>

            <div className="mb-8">
              <h2 className="text-xl font-bold mb-2">Cancellation Policy</h2>
              <ul className="list-disc list-inside">
                <li>24 hrs. from date & time of Booking - <span class="font-semibold">100% refund</span></li>
                <li>12 hrs. from date & time of Booking - <span class="font-semibold">50% refund</span></li>
                <li>Less than 12 hrs. from date & time of booking - <span class="font-semibold">forfeit of entire deposit</span></li>
              </ul>
            </div>

            <div className="mb-8">
              <h2 className="text-xl font-bold mb-2">Table Timings</h2>
              <ul className="list-disc list-inside">
                <li>We operate a strict 2-hour maximum table time policy.</li>
                <li>
                  We will always endeavor to accommodate you if you are late for your initial reservation time.
                  Please be patient and bear with us whilst we try and meet your expectations.
                </li>
                <li>
                  We will hold your table for 20 minutes after your scheduled reservation time.
                  If you do not arrive in that time, we will place your reservation on the waitlist and accommodate you at the next earliest available table.
                </li>
              </ul>
            </div>

            <div className="mb-8">
              <h2 className="text-xl font-bold mb-2">Dress Code</h2>
              <ul className="list-disc list-inside">
                <li>Smart Casual. Men, please note regrettably no open sandals/shoes.</li>
                <li>Shorts may be worn on the occasion of Brunch.</li>
              </ul>
            </div>

            
            <div className="mb-8">
              <h2 className="text-xl font-bold mb-2">Kids/Children Policy</h2>
              <ul className="list-disc list-inside">
                <li>Bastian At The Top - Children below 15 yrs of age are not allowed near the poolside.</li>
                <li>Inka by Bastian - Kindly note Kids are re not allowed after 10pm on all days.</li>
                <li>All Other venues : Children below 15 yrs of age are not permitted on Friday and Saturday after 10pm.</li>
              </ul>
            </div>

            
            <div className="mb-8">
              <h2 className="text-xl font-bold mb-2">Valet Parking</h2>
              <ul className="list-disc list-inside">
                <li>We operate a chargeable Valet Parking service.</li>
                <li>
                  Please note that there is limited street parking at our Bandra / Bangalore venues, so we advise using a Driver/UBER/Valet service.
                </li>
              </ul>
            </div>

            
            <div className="mb-8">
              <h2 className="text-xl font-bold mb-2">Outside Catering/Food/Desserts/Cakes</h2>
              <ul className="list-disc list-inside">
                <li>We do not permit the consumption of any food. Cakes, desserts from outside suppliers and providers</li>
                <li>We offer an incredible selection of cakes and desserts for all occasions. Feel free to call us and we will happily share our selection.</li>
              </ul>
            </div>

            
            <div className="mb-8">
              <h2 className="text-xl font-bold mb-2">Disability Access</h2>
              <ul className="list-disc list-inside">
                <li>Bandra Bastian does not have a disability lift/elevator.</li>
                <li>Bastian At The Top has disability access from the ground floor to the Top.</li>
                <li>We do not have disability access toilet facilities at our venues.</li>
              </ul>
            </div>

            
            <div className="mb-8">
              <h2 className="text-xl font-bold mb-2">General Information</h2>
              <p className="mb-4">
                <span className="font-semibold">Reservations Office Operating Hours:</span> Our reservations team are available between the hours of
                <span className="font-semibold"> 10am and 10pm</span>, Monday through to Sunday. On certain special occasion days, public and religious holidays,
                these timings may be subject to change.
              </p>
              <p className="mb-2"><span class="font-semibold">Opening Hours:</span></p>
              <ul className="list-none">
                <li>
                     Bastian, Bandra, Mumbai:
                  <a href="https://bit.ly/Bastian_Bandra" target="_blank" class="text-[#F2CA99]">
                  &nbsp;https://bit.ly/Bastian_Bandra
                  </a>
                </li>
                <li>
                     Bastian At The Top, Mumbai:
                  <a href="https://bit.ly/Bastian_At_The_Top" target="_blank" class="text-[#F2CA99]">
                  &nbsp;https://bit.ly/Bastian_At_The_Top
                  </a>
                </li>
                <li>
                     Bastian, Garden City, Bangalore:
                  <a href="https://bit.ly/Bastian_Garden_City" target="_blank" class="text-[#F2CA99]">
                  &nbsp;https://bit.ly/Bastian_Garden_City
                  </a>
                </li>
                <li>
                     Bastian Empire, Pune: 
                  <a href="https://bit.ly/Bastian_Empire" target="_blank" class="text-[#F2CA99]">
                  &nbsp;https://bit.ly/Bastian_Empire
                  </a>
                </li>
              </ul>
            </div>
          </div>


        </div>
      </div>
    </div>
  );
}
