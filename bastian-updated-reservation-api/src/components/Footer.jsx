import logo from "../assets/logo/logo.png";
import { FaLinkedin } from "react-icons/fa6";
import { useEffect } from "react";
import { IoLogoInstagram } from "react-icons/io5";
import { FaRegCopyright } from "react-icons/fa6";
import { Link, useLocation } from "react-router-dom";

const Footer = () => {
  const location = useLocation();

  useEffect(() => {
    window.scrollTo({
      top: 0,
      behavior: "smooth",
    });
  }, [location]);

  return (
    <footer className="w-full">
      <div className="w-full bg-[#1A1A1A] md:h-[400px] md:flex md:justify-center md:items-center">
        <div className="w-full md:w-[25%] flex flex-col justify-center items-center gap-2 p-6 pt-20 md:p-6">
          <Link to="/">
            <img src={logo} alt="logo" className="h-[40px] md:h-[70px]" />
          </Link>
          <div className="flex justify-center items-center gap-2">
            <a href="https://www.linkedin.com/company/bastian-hospitality/" target="_blank"><FaLinkedin className="text-white text-2xl hover:text-[#F2CA99] transition-colors" /></a>
            <a href="https://www.instagram.com/bastianmumbai/" target="_blank"><IoLogoInstagram className="text-white text-2xl hover:text-[#F2CA99] transition-colors" /></a>
          </div>
        </div>
        <div className="w-full md:w-[75%] flex justify-center md:block">
          <div className="w-[320px] md:w-full md:flex md:justify-evenly grid grid-cols-2 gap-12 md:gap-8 p-6 py-10 lg:pr-24">
            <div className="flex flex-col">
              <h1 className="text-[#F2CA99] text-sm mb-4"><Link to="/">Home</Link></h1>
            </div>
            <div className="flex flex-col">
              <h1 className="text-[#F2CA99] text-sm mb-4"><Link to="/visionaries">Our Story</Link></h1>
            </div>
            <div className="flex flex-col">
              <h1 className="text-[#F2CA99] text-sm mb-4">The Buzz</h1>
              <ul className="flex flex-col gap-4 text-gray-200 text-xs">
                <Link to="/awards">Awards</Link>
                <Link to="/mediacoverage">Media Coverage</Link>
                <Link to="/curation">Curation</Link>
              </ul>
            </div>
            <div className="flex flex-col">
              <h1 className="text-[#F2CA99] text-sm mb-4">Brands</h1>
              <ul className="flex flex-col gap-4 text-gray-200 text-xs">
                <Link to="/bastianbandra">Bastian Bandra</Link>
                <Link to="/bastianattop">Bastian At The Top</Link>
                <Link to="/bastiangarden">Bastian Garden City</Link>
                <Link to="/bastianempire">Bastian Empire</Link>
              </ul>
            </div>
            <div className="flex flex-col">
              <h1 className="text-[#F2CA99] text-sm mb-4">Resources</h1>
              <ul className="flex flex-col gap-4 text-gray-200 text-xs">
                <Link to="/career">Careers</Link>
                <Link to="/reservations">Reservation</Link>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <div className="w-full h-auto bg-[#242424] flex flex-col-reverse gap-2 justify-center items-center md:flex-row md:justify-between md:items-center px-6 font-normal py-2">
        <h4 className="flex items-center text-[8px] md:text-[8px] text-gray-300 gap-1">
          <FaRegCopyright />
          2025 Bastian Hospitality. All rights reserved. Crafted by <Link to="https://www.ninetriangles.com/" target="_blank">Nine triangles</Link>
        </h4>
        <h4 className="text-xs md:text-[8px] text-gray-300">
          <Link to="/">Privacy Policy / </Link>
          <Link to="/tcs"> Terms & Conditions</Link>
        </h4>
      </div>
    </footer>
  );
};

export default Footer;
