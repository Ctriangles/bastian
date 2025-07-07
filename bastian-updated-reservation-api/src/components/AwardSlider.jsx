/* eslint-disable react/prop-types */
import "slick-carousel/slick/slick.css";
import "slick-carousel/slick/slick-theme.css";
import Slider from "react-slick";

import img1 from "../assets/Images/a1.png";
import img2 from "../assets/Images/a2.png";
import img3 from "../assets/Images/a3.png";

import { MdOutlineNavigateNext } from "react-icons/md";
import { GrFormPrevious } from "react-icons/gr";
import { useRef } from "react";
import { FaArrowRight } from "react-icons/fa";
import SectionHeading from "./SectionHeading";
import { Link } from "react-router-dom";

export default function AwardSlider({ shoHeading }) {
  const slider = useRef(null);
  const headingText = {
    heading: "Awards",
    text: `Bastian Hospitality in the Spotlight - Celebrating our journey to
excellence with prestigious awards, accolades, and media recognition.`,
  };
  const settings = {
    dots: true,
    infinite: true,
    speed: 1000,
    slidesToShow: 4,
    slidesToScroll: 1,
    initialSlide: 0,
    autoplay: true,
    responsive: [
      {
        breakpoint: 1024,
        settings: {
          slidesToShow: 3,
          dots: true,
        },
      },
      {
        breakpoint: 600,
        settings: {
          slidesToShow: 2,
          initialSlide: 2,
        },
      },
      {
        breakpoint: 580,
        settings: {
          slidesToShow: 2.3,
          infinite: false,
          slidesToScroll: 1,
          autoplay: false,
        },
      },
    ],
  };
  return (
    <div className="award-slider-sec">
        <SectionHeading headingText={headingText} />
      <div className="py-6 pt-0 relative award-slider">
        <div className={`${shoHeading?'block':'hidden'}`}>
        </div>
        <div className="slider-container mt-8 md:mt-12 w-[100%] m-auto overflow-hidden award-slider">
          <Slider ref={slider} {...settings}>
            <div className="px-1 md:px-4">
              <img src={img1} className="w-full h-auto rounded-3xl" alt="Certificate from the Times of India acknowledging Bastian" />
            </div>
            <div className="px-1 md:px-4">
              <img src={img2} className="w-full h-auto" alt="Award winners with certificates in Bombay Times News" />
            </div>
            <div className="px-1 md:px-4">
              <img src={img3} className="w-full h-auto rounded-[10px]" alt="Times of India Certificate for Ranjit D Bindra" />
            </div>
            <div className="px-1 md:px-4">
              <img src={img1} className="w-full h-auto rounded-[10px]" alt="Certificate from the Times of India acknowledging Bastian" />
            </div>
          </Slider>
        </div>
        <div className="w-full flex justify-center items-center">
          <div className="w-full md:w-[10%] flex justify-center items-center gap-8 md:mt-16 mb-4 md:opacity-40 ">
            <GrFormPrevious
              onClick={() => slider?.current?.slickPrev()}
              className="w-[45px] h-auto absolute left-[20px] md:left-[0] md:relative top-[38%] transform -translate-y-1/2 md:top-auto md:transform-none cursor-pointer  border-2 border-[#F2CA99] text-[#F2CA99] rounded-full"
            />
            <MdOutlineNavigateNext
              onClick={() => slider?.current?.slickNext()}
              className="w-[45px] h-auto cursor-pointer right-[10px] md:right-[0] absolute md:relative top-[38%] transform -translate-y-1/2 md:top-auto md:transform-none border-2 border-[#F2CA99] text-[#F2CA99] rounded-full"
            />
          </div>
        </div>
      </div>
      <div className="w-full flex justify-center items-center -mt-[10px] md:mt-1 mb-[50px] md:mb-[90px] lg:mb-[130px]">
        <Link to="/awards" className="text-[#F2CA99] text-sm flex items-center gap-1">Know more <FaArrowRight className="text-[10px]" /> </Link>
      </div>
    </div>
    
  );
}
