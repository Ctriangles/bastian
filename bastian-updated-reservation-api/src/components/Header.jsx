import { useState, useEffect } from "react";
import logo from "../assets/logo/logo.png";
import { HiMiniBars3 } from "react-icons/hi2";
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
import ReservationsEatApp from "./ReservationEatApp";

const Header = () => {
  const [showMenu, setShowMenu] = useState(false);
  const [activeSubMenu, setActiveSubMenu] = useState(null);
  const [isSticky, setIsSticky] = useState(false);
  const [showModal, setShowModal] = useState(false);
  const [error, setError] = useState("");
  const [loading, setLoading] = useState(false);
  const [recaptchaValue, setRecaptchaValue] = useState(null);
  const handleToggleMenu = () => {
    setShowMenu(!showMenu);
  };
  const handleRecaptchaChange = (value) => {
    setRecaptchaValue(value);
  };

  const handleScroll = () => {
    if (window.scrollY >= 60) {
      setIsSticky(true);
    } else {
      setIsSticky(false);
    }
  };

  useEffect(() => {
    window.addEventListener("scroll", handleScroll);

    return () => {
      window.removeEventListener("scroll", handleScroll);
    };
  }, []);

  useEffect(() => {
    if (showMenu) {
      document.body.classList.add("overflow-hidden");
    } else {
      document.body.classList.remove("overflow-hidden");
    }

    return () => {
      document.body.classList.remove("overflow-hidden");
    };
  }, [showMenu]);

  const handleToggleSubMenu = (menuKey) => {
    setActiveSubMenu((prev) => (prev === menuKey ? null : menuKey));
  };

  const handleShowModal = () => {
    setShowModal(!showModal);
  };

  const handleCloseModal = () => {
    setShowModal(false);
  };

  const scrollToTop = () => {
    window.scrollTo({ top: 0, behavior: "smooth" });
  };

  const menuItems = [
    {
      label: "The Buzz",
      subMenuKey: "subMenu3",
      subMenuItems: [
        { label: "Awards", path: "/awards" },
        { label: "Media Coverage", path: "/mediacoverage" },
        { label: "Curation", path: "/curation" },
      ],
    },
    {
      label: "Brands",
      subMenuKey: "subMenu4",
      subMenuItems: [
        { label: "Bastian Bandra", path: "/bastianbandra" },
        { label: "Bastian At The Top", path: "/bastianattop" },
        { label: "Bastian Garden City", path: "/bastiangarden" },
        { label: "Bastian Empire", path: "/bastianempire" },
      ],
    },
    {
      label: "Resources",
      subMenuKey: "subMenu5",
      subMenuItems: [
        { label: "Careers", path: "/career" },
        { label: "Reservation", path: "/reservations" },
      ],
    },
  ];
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
  const [successMessage, setSuccessMessage] = useState(false);

  useEffect(() => {
    if (successMessage) {
      const timer = setTimeout(() => setSuccessMessage(false), 5000);
      return () => clearTimeout(timer);
    }
  }, [successMessage]);
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

    //  Check if mobile number is exactly 10 digits
    if (formData.mobile.length !== 10) {
      alert("Mobile number must be exactly 10 digits.");
      return;
    }
    // Check if pincode is exactly 6 digits
    if (formData.pincode.length !== 6) {
      alert("Pincode must be exactly 6 digits.");
      return;
    }

    

    if (!recaptchaValue) {
      alert("Please complete the reCAPTCHA");
      return;
    }

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
        setSuccessMessage(
          "Thank you for submitting your details. A Bastian reservation executive will call you in 24 hours."
        );
      }
    } catch (error) {
      setErrorMessage("Something went wrong, please try again later.");
    } finally {
      setLoading(false); // Set loading to false when the request is completed (either success or failure)
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
      <header
        style={{ zIndex: "99999" }}
        className={`w-full h-[80px] text-white flex justify-between items-center py-8 px-4 md:px-12 transition-all duration-300 ${
          isSticky ? "fixed top-0 bg-black shadow-lg" : "absolute"
        }`}
      >
        <Link to="/">
          <img src={logo} alt="logo" className="h-[40px] md:h-[50px]" />
        </Link>
        <div className="flex items-center justify-between gap-2 border h-[41px] border-text-primary w-[150px] rounded-md overflow-hidden">
          <span
            className="text-sm text-text-primary pl-2 cursor-pointer"
            onClick={handleShowModal}
          >
            Reservation
          </span>
          <div className="bg-text-primary p-1 cursor-pointer h-[41px] w-[47px] align-center flex justify-center">
            {showMenu ? (
              <IoMdClose
                onClick={handleToggleMenu}
                className="text-2xl text-black mt-[5px]"
              />
            ) : (
              <HiMiniBars3
                onClick={handleToggleMenu}
                className="text-2xl text-black mt-[5px]"
              />
            )}
          </div>
        </div>
      </header>
      <div
        style={{ zIndex: "9999" }}
        className={`w-full h-screen bg-black/90 flex justify-center items-center fixed top-0 left-0 right-0 ${
          showMenu ? "block" : "hidden"
        }`}
      >
        <div className="w-full px-6 lg:w-[80%] h-auto mb-[50px] md:mb-[200px] md:mb-0">
          <ul className="flex flex-col justify-center items-center gap-7 md:gap-14 md:flex-row md:justify-between md:items-center text-xl md:text-2xl text-text-primary">
            <li className="cursor-pointer relative flex flex-col justify-center items-center md:block">
              <Link
                to="/"
                onClick={() => {
                  handleToggleMenu(); // Hide menu when navigating to Home
                  scrollToTop(); // Scroll to top before navigating
                }}
              >
                <span className="flex items-center gap-1">Home</span>
              </Link>
            </li>
            <li className="cursor-pointer relative flex flex-col justify-center items-center md:block">
              <Link
                to="/visionaries"
                onClick={() => {
                  handleToggleMenu(); // Hide menu when navigating to Home
                  scrollToTop(); // Scroll to top before navigating
                }}
              >
                <span className="flex items-center gap-1">Our Story</span>
              </Link>
            </li>
            {menuItems.map(({ label, subMenuKey, subMenuItems }, index) => (
              <li
                key={index}
                onClick={() => handleToggleSubMenu(subMenuKey)}
                className="cursor-pointer relative flex flex-col justify-center items-center md:block"
              >
                <span className="flex items-center gap-1">
                  {label}
                  {activeSubMenu === subMenuKey ? (
                    <MdKeyboardArrowUp className="text-2xl" />
                  ) : (
                    <MdKeyboardArrowDown className="text-2xl" />
                  )}
                </span>
                <div
                  className={`w-[180px] static md:absolute left-[-50px] md:left-0 ${
                    activeSubMenu === subMenuKey ? "block" : "hidden"
                  }`}
                >
                  <ul className="text-white text-[16px] leading-[40px] text-center md:text-left">
                    {subMenuItems.map((item, subIndex) =>
                      item.path ? (
                        <Link
                          onClick={() => {
                            handleToggleMenu(); // Hide menu when navigating
                            scrollToTop(); // Scroll to top before navigating
                          }}
                          to={item.path}
                          key={subIndex}
                          className="flex flex-col"
                        >
                          {item.label}
                        </Link>
                      ) : (
                        <span
                          onClick={handleToggleMenu}
                          key={subIndex}
                          className="flex flex-col cursor-pointer"
                        >
                          {item.label}
                        </span>
                      )
                    )}
                  </ul>
                </div>
              </li>
            ))}
          </ul>
        </div>
      </div>
      {/* Modal for Reservation */}
      <div
        className={`${
          showModal ? "block" : "hidden"
        } fixed inset-0 bg-black bg-opacity-90 flex items-center justify-center z-[99999]`}
      >
        <div className="header-popup max-w-[90%] mx-auto md:max-w-[500px] w-full bg-black/90 backdrop-blur-sm border border-text-primary rounded-md p-2 md:py-6">
          <div className="w-full text-text-primary p-2 relative mb-4">
            {!successMessage && (
              <>
                <h1 className="text-[24px] pr-[40px] leading-[1] py-2">
                  Make A Reservation
                </h1>
                <p className="text-white text-[14px]">
                  Fill in the form to join Bastian's exclusive community of
                  indulgence.
                </p>
              </>
            )}
            <span
              onClick={handleCloseModal}
              className="cross-icon absolute right-[0] top-[2px] text-white border border-text-primary  w-[25px] h-[25px] rounded-full flex items-center justify-center cursor-pointer"
            >
              <IoMdClose className="cursor-pointer text-[16px]" />
            </span>
          </div>
          {successMessage ? (
            <p className="text-text-primary w-full text-center text-[20px]">
              {successMessage}
            </p>
          ) : (
           <ReservationsEatApp />
          )}
        </div>
      </div>
    </div>
  );
};

export default Header;
