import sliderBg1 from "../assets/Images/brandsSlideImgOne.jpg";
import sliderBg2 from "../assets/Images/brandsSlideImgSecond.jpg";
import sliderBg3 from "../assets/Images/brandsSlideImgThird.jpg";
import bigImageGrad from "../assets/Images/big-image-gradt.png";
import smallImageGrad from "../assets/Images/small-image-gradt.png";
import SectionHeading from "./SectionHeading";
import Slider from "react-slick";
import "slick-carousel/slick/slick.css";
import "slick-carousel/slick/slick-theme.css";
import img1 from "../assets/Images/brandsSlideImgOneSmall.jpg";
import img2 from "../assets/Images/brandsSlideImgSecondSmall.jpg";
import img3 from "../assets/Images/brandsSlideImgThirdSmall.jpg";
import { FaArrowRight } from "react-icons/fa";
import { MdOutlineNavigateNext } from "react-icons/md";
import { GrFormPrevious } from "react-icons/gr";
import { useState, useRef } from "react";
import { Link } from "react-router-dom";
import 'aos/dist/aos.css';

export default function BrandSlider() {
  const slider = useRef(null);
  const [backgroundImage, setBackgroundImage] = useState(sliderBg1)
  const headingText = {
    heading: "Our Brands",
    text: "Discover Bastian Hospitality's iconic brands that elevate culinary excellence & premium dining in India.",
  };

  const slideBackgrounds = [sliderBg1, sliderBg2, sliderBg3];

  const settings = {
    dots: false,
    infinite: true,
    speed: 1000,
    slidesToShow: 1,
    slidesToScroll: 1,
    initialSlide: 0,
    beforeChange: (oldIndex, newIndex) => {
      setBackgroundImage(slideBackgrounds[newIndex]);
    },
    responsive: [
      {
        breakpoint: 1024,
        settings: {
          slidesToShow: 1, // Maintain one image on larger screens
          slidesToScroll: 1,
          infinite: true,
          dots: true,
        },
      },
      {
        breakpoint: 768,
        settings: {
          slidesToShow: 1, 
          slidesToScroll: 1,
          initialSlide: 0,
          dots: true,
        },
      },
    ],
  };

  return (
    <div
      style={{ backgroundImage: `url(${backgroundImage})` }}
      className="brnadSlider w-full h-auto relative md:h-[1030px] bg-cover bg-center bg-fixed"
    >
      {/* Black overlay with a lower z-index */}
      <div className="absolute inset-0 w-full h-[520px] sliderTopBg z-10"></div>

      <div className="absolute left-0 bottom-0 w-full">
        <img src={bigImageGrad} className="bigImgGradient w-full object-cover w-full" alt="Blank Gray Shadow Image" />
      </div>

      {/* Section heading with a higher z-index */}
      <div className=" flex flex-col justify-center items-center">
        <div className="relative z-20">
          <SectionHeading headingText={headingText} />
        </div>
        <div className="w-[80%] md:w-[71%] relative z-20">
          <Slider ref={slider} {...settings}>
            <div className="relative">
              <img src={img1} className="w-full h-[550px] md:h-[710px] object-cover -z-50" alt="Rustic cave dining spot" />
              <div className="sliderBottomText w-full text-center absolute bottom-6 z-10 text-white flex flex-col">
                <h3 className="text-[20px] md:text-[36px] text-[#F2CA99]">
                  Bastian At The Top
                </h3>
                <div>
                  <p className="text-sm">
                    {`The indulgence you didn't know you needed!`}
                  </p>
                  <p className="text-sm">
                    Bold interiors, 360 views, glorious cuisine & luscious
                    drinks.
                  </p>
                  <Link to="/bastianattop" className="text-xs text-text-primary flex justify-center items-center gap-1 mt-4">Indulge <FaArrowRight className="text-[10px]" /> </Link>
                </div>
              </div>
              <div className="absolute left-0 bottom-0 w-full">
                <img src={smallImageGrad} className="bigImgGradient w-full object-cover  w-full" alt="Black & Gray background Image" />
              </div>
            </div>
            {/* Repeat the same structure for other slides */}
            <div className="relative">
              <img src={img2} className="w-full h-[550px] md:h-[710px] object-cover -z-50 rounded-[lg]" alt="A cozy bar view" />
              <div className="sliderBottomText w-full text-center absolute bottom-6 z-10 text-white flex flex-col">
                <h3 className="text-[20px] md:text-[36px] text-[#F2CA99]">
                  Bastian Bandra
                </h3>
                <div>
                  <p className="text-sm">
                    {`Your favourite neighbourhood bar & dining destination!`}
                  </p>
                  <p className="text-sm">Globally inspired cuisine and unrivalled cocktails set the tone at our flagship venue.
                  </p>
                  <Link to="/bastianbandra" className="text-xs text-text-primary flex justify-center items-center gap-1 mt-4">Indulge <FaArrowRight className="text-[10px]" /> </Link>
                </div>
              </div>
              <div className="absolute left-0 bottom-0 w-full">
                <img src={smallImageGrad} className="bigImgGradient w-full object-cover  w-full" alt="Black & Gray background Image" />
              </div>
            </div>
            <div className="relative">
              <img src={img3} className="w-full h-[550px] md:h-[710px] object-cover -z-50 " alt="Stylish dining hall"/>
              <div className="sliderBottomText w-full text-center absolute bottom-6 z-10 text-white flex flex-col">
                <h3 className="text-[20px] md:text-[36px] text-[#F2CA99]">
                  Bastian Garden City
                </h3>
                <div>
                  <p className="text-sm">
                    {`A sanctuary of taste and style!`}
                  </p>
                  <p className="text-sm">
                    Trendy interiors, lush gardens, exquisite cuisine & handcrafted cocktails await you.
                  </p>
                  <Link to="/bastiangarden" className="text-xs text-text-primary flex justify-center items-center gap-1 mt-4">Indulge <FaArrowRight className="text-[10px]" /> </Link>
                </div>
              </div>
              <div className="absolute left-0 bottom-0 w-full">
                <img src={smallImageGrad} className="bigImgGradient w-full object-cover w-full" alt="Black & Gray background Image" />
              </div>
            </div>
          </Slider>
          <div className="absolute inset-0 flex justify-between items-center w-full z-[-1] slick-arrow">
            <GrFormPrevious
              onClick={() => slider?.current?.slickPrev()}
               className="text-[2.85rem] cursor-pointer border-2 border-[#F2CA99] text-[#F2CA99] rounded-full ml-[-133px]"
            />
            <MdOutlineNavigateNext
              onClick={() => slider?.current?.slickNext()}
              className="text-[2.85rem] cursor-pointer border-2 border-[#F2CA99] text-[#F2CA99] rounded-full mr-[-133px]"            />
          </div>
        </div>
     
      </div>
    </div>
  );
}
