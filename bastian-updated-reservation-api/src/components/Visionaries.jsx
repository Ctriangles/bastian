import Slider from "react-slick";
import "slick-carousel/slick/slick.css";
import "slick-carousel/slick/slick-theme.css";
import { FaArrowRight } from "react-icons/fa";
import img1 from "../assets/Images/visionaries-img-first.jpg";
import img2 from "../assets/Images/visionaries-img-second.jpg";
import img3 from "../assets/Images/visionaries-img-third.jpg";
import SectionHeading from "./SectionHeading";
import { MdOutlineNavigateNext } from "react-icons/md";
import { GrFormPrevious } from "react-icons/gr";
import { useRef } from "react";
import { Link } from "react-router-dom";

export default function Visionaries() {
  const slider = useRef(null);
  const headingText = {
    heading: "Our Visionaries",
    text: "Redefining the Future of Luxury Dining with Innovation & Excellence",
  };
  const settings = {
    dots: true,
    infinite: true,
    speed: 1000,
    slidesToShow: 1,
    slidesToScroll: 1,
    arrows: false,
    centerMode: true,
    centerPadding: '30%',
    dotsClass: "slick-dots custom-dots",
    responsive: [
      {
        breakpoint: 991,
        settings: {
          centerPadding: '20%',
        },
      },
      {
        breakpoint: 768,
        settings: {
          centerMode: false,
          slidesToShow: 1,
          dots: true,
          arrows: false,
          centerPadding: '0%',
        },
      },
    ],
  };
  
  return (
    <div className="w-full founder-team-text">
      <SectionHeading headingText={headingText} />

      <div className="visionaries-sec" data-aos="zoom-in">

          <div className="w-full ">
            <Slider  ref={slider} {...settings}>
              <div className="relative">
                <img src={img2} alt="RANJIT BINDRA - Founder & CEO" />
                <div className="sliderImgText z-10 absolute bottom-0 left-0">
                  <h4>FOUNDER & CEO</h4>
                  <h3>RANJIT BINDRA</h3>
                  <Link to="/visionaries" className="text-[#F2CA99] text-sm flex items-center gap-1 mt-4">Know more <FaArrowRight className="text-[10px]" /> </Link>
                </div>
                <div className="textLayer w-full h-[350px] absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/100"></div>
              </div>
              <div className="relative">
                <img src={img3} alt="Shilpa Shetty Kundra - Co-Founder" />
                <div className="sliderImgText z-10 absolute bottom-0 left-0">
                  <h4>CO - FOUNDER</h4>
                  <h3>SHILPA SHETTY KUNDRA</h3>
                  <Link to="/visionaries" className="text-[#F2CA99] text-sm flex items-center gap-1 mt-4">Know more <FaArrowRight className="text-[10px]" /> </Link>
                </div>
                <div className="textLayer w-full h-[350px] absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/100"></div>
              </div>
              <div className="relative">
                <img src={img1} alt="Kunal Jani - Co-Founder" />
                <div className="sliderImgText z-10 absolute bottom-0 left-0">
                  <h4>CO - FOUNDER</h4>
                  <h3>KUNAL JANI</h3>
                  <Link to="/visionaries" className="text-[#F2CA99] text-sm flex items-center gap-1 mt-4">Know more <FaArrowRight className="text-[10px]" /> </Link>
                </div>
                <div className="textLayer w-full h-[350px] absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/100"></div>
              </div>
            </Slider>
          </div>
      </div>
      <div className="w-full flex justify-center items-center mt-[40px] opacity-50 hidden md:flex">
        <div className="w-full md:w-[10%] flex justify-center items-center gap-8 mt-6 mb-6">
          <GrFormPrevious
            onClick={() => slider?.current?.slickPrev()}
            className="w-[45px] h-auto cursor-pointer  border-2 border-[#F2CA99] text-[#F2CA99] rounded-full"
          />
          <MdOutlineNavigateNext
            onClick={() => slider?.current?.slickNext()}
            className="w-[45px] h-auto cursor-pointer border-2 border-[#F2CA99] text-[#F2CA99] rounded-full"
          />
        </div>
      </div>
    </div>
  );
}
