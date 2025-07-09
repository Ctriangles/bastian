import bg from "../assets/Images/HeroImgDs2.jpg";
import mobBg from "../assets/Images/visionmob-banner.png";
import HeroSection from "../components/HeroSection";
import backgroundImg from "../assets/Images/bgImgV.png";
import vslide1 from "../assets/Images/vslide1.png";
import vslide2 from "../assets/Images/vslide2.png";
import vslide3 from "../assets/Images/vslide3.png";
import vslide4 from "../assets/Images/vslide4.png";
import vslide5 from "../assets/Images/vslide5.png";
import vslide6 from "../assets/Images/vslide6.png";
import { useState, useRef } from "react";
import Slider from "react-slick";
import "slick-carousel/slick/slick.css";
import "slick-carousel/slick/slick-theme.css";
import { MdOutlineNavigateNext } from "react-icons/md";
import { GrFormPrevious } from "react-icons/gr";
import bgGredientImage from "../assets/Images/homeBannerGradient.png";
import v1 from "../assets/Images/v1remove.png";
import v2 from "../assets/Images/v2remove.png";
import v3 from "../assets/Images/v3remove.png";

import card1 from "../assets/Images/vacrd1.jpeg";
import card2 from "../assets/Images/vcard2.png";

import logo from "../assets/logo/logo.png";
import 'aos/dist/aos.css';
import { Helmet } from 'react-helmet';
export default function VisionariesPage() {
  // State array to handle hover state of each card
  const [hoveredCard, setHoveredCard] = useState(null);
  const [hoveredCard2, setHoveredCard2] = useState(null);
  const slider = useRef(null);
  const HeroImgText = {
    heading1: "Our Story",
    heading2:
      "Founded in 2014 by Ranjit Bindra, Bastian Hospitality has built a strong brand portfolio including A Bar Called Life, Arth, One Street, Binge, and its iconic Bastian. The brand has now expanded pan-India with Bastian Garden City in Bangalore and Bastian Empire in Pune. Further, Bastian also launched its second Bastian Mumbai outlet - At The Top, which is an iconic & unmissable rooftop location in the middle of Mumbai, on the 48th floor, with a restaurant, lounge, club and pool, which has quickly become the most coveted dining and nightlife spot in the city. Future projects include Inka by Bastian and a casual coffee concept - Blondie.",
    changeStyle: true,
  };

  const settings = {
    infinite: false,
    speed: 1000,
    slidesToShow: 2.7,
    slidesToScroll: 1,
    autoplay: false,
    arrows: false,

    responsive: [
      {
        breakpoint: 1024,
        settings: {
          slidesToShow: 2,
        },
      },
      {
        breakpoint: 600,
        settings: {
          slidesToShow: 1.05,
          autoplay: false,
        },
      },
    ],
  };

  return (
    <div className="w-full h-auto min-h-screen page-height visionaries-page">
      <Helmet>
<title>Bastian Visionaries - Our Leaders</title>
<meta 
name="description" 
content="Meet the visionaries behind Bastian Hospitality, driving innovation in the culinary world." 
/>
</Helmet>
      <div className="common-banner">
        <div className="relative">
          <div>
            <HeroSection
              bg={bg}
              bg2={mobBg}
              HeroImgText={HeroImgText}
              bgGredientImage={bgGredientImage}
            />
          </div>
          <div
            style={{ backgroundImage: `url(${backgroundImg})` }}
            className="relative w-full h-[793px] md:h-[700px] bg-cover bg-center lagecy-slider" data-aos="fade-up"
          >
            <div className="absolute inset-0 bg-black/60 backdrop-blur-md z-10"></div>

            {/* Adjusting the content to ensure it's above the overlay */}
            <div className="absolute inset-0 flex justify-center md:items-center z-20 pt-[60px] md:p-0">
              <div className="w-full text-white flex flex-col md:flex-row justify-start pl-0 md:pl-14 lg:pl-28 items-center gap-12 md:gap-2 ">
                <div className="w-full text-center pr-0 md:pr-10 lg:pr-20 md:text-left md:w-[34%]">
                  <h1 className="text-[24px] md:text-[44px] lg:text-[64px] text-text-primary leading-[1.1] mb-6  md:mb-9">
                    Our legacy
                  </h1>
                  <p className="text-[12px] px-6 md:px-0 md:text-[20px] max-w-[350px] mx-auto md:max-w-[100%] text-center md:text-left leading-[1.8] md:leading-[1.4] !leading-[1.8] md:!leading-[1.4]">
                    Exquisite elegance and culinary mastery define us. Each
                    chapter of our journey showcases extraordinary dining
                    experiences that elevate luxury.
                  </p>
                </div>
                <div className="w-full md:w-[66%] gap-4 pl-7 md:pl-0">
                  <Slider ref={slider} className=" relative" {...settings}>
                    {/* First Card */}
                    <div
                      onMouseEnter={() => setHoveredCard(1)}
                      onMouseLeave={() => setHoveredCard(null)}
                      className="h-[415px] w-[305px] relative"
                    >
                      <img src={vslide1} className="w-full h-[415px]" alt="" />
                      <div
                        className={`absolute inset-0 h-[415px] ${
                          hoveredCard === 1
                            ? "bg-[#EECB9F] opacity-60"
                            : "bg-black/65  "
                        } duration-300 z-10 text-[48px] flex justify-center items-center`}
                      >
                        {hoveredCard === 1 ? (
                          <p className="text-[18px] text-black text-center font-medium max-w-[240px] leading-[1.4] !leading-[1.4]">
                            Bastian opens its doors in Bengaluru, at Garden City
                          </p>
                        ) : (
                          "2024"
                        )}
                      </div>
                    </div>

                    {/* Second Card */}
                    <div
                      onMouseEnter={() => setHoveredCard(2)}
                      onMouseLeave={() => setHoveredCard(null)}
                      className="h-[415px] w-[305px] relative"
                    >
                      <img src={vslide2} className="w-full h-[415px]" alt="" />
                      <div
                        className={`absolute h-[415px] inset-0   ${
                          hoveredCard === 2
                            ? "bg-[#EECB9F] opacity-60"
                            : "bg-black/65  "
                        } duration-300 z-10 text-[48px] flex justify-center items-center`}
                      >
                        {hoveredCard === 2 ? (
                          <p className="text-[18px] text-black text-center font-medium max-w-[240px] leading-[1.4] !leading-[1.4]">
                            Bastian Worli relocates to an iconic rooftop
                            location. Bastian Bandra gets a fantastic facelift!
                          </p>
                        ) : (
                          "2023"
                        )}
                      </div>
                    </div>

                    {/* Third Card */}
                    <div
                      onMouseEnter={() => setHoveredCard(3)}
                      onMouseLeave={() => setHoveredCard(null)}
                      style={{ backgroundImage: `url(${vslide3})` }}
                      className="h-[415px] w-[305px]  relative  "
                    >
                      <img src={vslide3} className="w-full h-[415px]" alt="" />
                      <div
                        className={`h-[415px] absolute inset-0 ${
                          hoveredCard === 3
                            ? "bg-[#EECB9F] opacity-60"
                            : "bg-black/65  "
                        } duration-300 z-10 text-[48px] flex justify-center items-center`}
                      >
                        {hoveredCard === 3 ? (
                          <p className="text-[18px] text-black text-center font-medium max-w-[240px] leading-[1.4] !leading-[1.4]">
                            Bastian Worli, the second outpost of the wildly
                            successful brand, launches in South Mumbai.
                          </p>
                        ) : (
                          "2020"
                        )}
                      </div>
                    </div>
                    {/* Fourth Card */}
                    <div
                      onMouseEnter={() => setHoveredCard(4)}
                      onMouseLeave={() => setHoveredCard(null)}
                      style={{ backgroundImage: `url(${vslide4})` }}
                      className="h-[415px] w-[305px]  relative  "
                    >
                      <img src={vslide4} className="w-full h-[415px]" alt="" />
                      <div
                        className={`h-[415px] absolute inset-0 ${
                          hoveredCard === 4
                            ? "bg-[#EECB9F] opacity-60"
                            : "bg-black/65  "
                        } duration-300 z-10 text-[48px] flex justify-center items-center`}
                      >
                        {hoveredCard === 4 ? (
                          <p className="text-[18px] text-black text-center font-medium max-w-[240px] leading-[1.4] !leading-[1.4]">
                            Aallia Hospitality joins forces with Shilpa
                            Shetty-Kundra to form Bastian Hospitality Private
                            Limited (BHPL) to further expand the brand
                            portfolio.
                          </p>
                        ) : (
                          "2019"
                        )}
                      </div>
                    </div>
                    {/* Fifth Card */}
                    <div
                      onMouseEnter={() => setHoveredCard(5)}
                      onMouseLeave={() => setHoveredCard(null)}
                      style={{ backgroundImage: `url(${vslide5})` }}
                      className="h-[415px] w-[305px]  relative  "
                    >
                      <img src={vslide5} className="w-full h-[415px]" alt="" />
                      <div
                        className={`h-[415px] absolute inset-0 ${
                          hoveredCard === 5
                            ? "bg-[#EECB9F] opacity-60"
                            : "bg-black/65  "
                        } duration-300 z-10 text-[48px] flex justify-center items-center`}
                      >
                        {hoveredCard === 5 ? (
                          <p className="text-[18px] text-black text-center font-medium max-w-[240px] leading-[1.4] !leading-[1.4]">
                            The group revamps its roster to offer patrons a
                            variety of stylish bar and restaurant brands with
                            Bastian Bandra as the crown jewel.
                          </p>
                        ) : (
                          "2016"
                        )}
                      </div>
                    </div>
                    {/* Sixth Card */}
                    <div
                      onMouseEnter={() => setHoveredCard(6)}
                      onMouseLeave={() => setHoveredCard(null)}
                      style={{ backgroundImage: `url(${vslide6})` }}
                      className="h-[415px] w-[305px]  relative  "
                    >
                      <img src={vslide6} className="w-full h-[415px]" alt="" />
                      <div
                        className={`h-[415px] absolute inset-0 ${
                          hoveredCard === 6
                            ? "bg-[#EECB9F] opacity-60"
                            : "bg-black/65  "
                        } duration-300 z-10 text-[48px] flex justify-center items-center`}
                      >
                        {hoveredCard === 6 ? (
                          <p className="text-[18px] text-black text-center font-medium max-w-[240px] leading-[1.4] !leading-[1.4]">
                            Aallia Hospitality (the hospitality group’s
                            erstwhile name) is established.
                          </p>
                        ) : (
                          "2010"
                        )}
                      </div>
                    </div>
                  </Slider>
                </div>
              </div>
            </div>
          </div>
          <div className="w-full flex justify-center items-center absolute bottom-[40px] md:bottom-[20px] left-0 right-0 z-50">
            <div className="w-full md:w-[10%] flex justify-center items-center gap-8 mt-4 md:mt-6 mb-6">
              <GrFormPrevious
                onClick={() => slider?.current?.slickPrev()}
                className="w-[45px] h-auto opacity-50 cursor-pointer border-2 border-text-primary text-text-primary rounded-full"
              />
              <MdOutlineNavigateNext
                onClick={() => slider?.current?.slickNext()}
                className="w-[45px] h-auto opacity-50 cursor-pointer border-2 border-text-primary text-text-primary rounded-full"
              />
            </div>
          </div>
        </div>
      </div>

      <div className="w-full md:min-h-[1924px]">
        <div className="bg-[#1C1B1B] p-8 md:p-7 md:p-14 lg:p-29 pb-0 md:pb-0 lg:pb-0 pt-6 lg:pt-10">
          <div className="w-full flex justify-center items-center">
            <h1 className="text-text-primary text-[24px] md:text-[48px] mb-[63px] md:mb-[-60px]" data-aos="fade-up">
              Our Visionaries
            </h1>
          </div>
          <div className="flex flex-col-reverse md:flex-row justify-start items-center gap-4">
            <div className="w-full md:w-[55%]  flex justify-center items-center" data-aos="fade-right">
              <img
                src={v1}
                className="h-auto md:h-[680px] object-cover"
                alt=""
              />
            </div>
            <div className="w-full md:w-[55%] p-0 md:p-6 mt-5" data-aos="fade-left">
              <h1 className="text-[20px] md:text-[36px] text-white text-center md:text-left uppercase mb-3">
                RANJIT BINDRA
              </h1>
              <h2 className="text-[20px] md:text-[24px] text-text-primary text-center md:text-left mb-[25px] mb-0 md:mb-3 ">
                Founder & CEO
              </h2>
              <p className="max-w-[660px] text-[12px] md:text-[18px] text-white leading-[30px] text-wrap text-center md:text-left">
                Bastian Hospitality (formerly Aalia Hospitality) was established by Ranjit Bindra in 2014, and has several strong brands (past and present) under its banner, including A Bar Called Life, Arth, One Street, Binge and its iconic Bastian brand. With Ranjit's vision, the brand has expanded pan-India to Bangalore & Pune with upcoming projects in Goa, among other Indian metros. Additionally, Ranjit is focusing on new culinary concepts, including a Peruvian Asian luxury dining experience - Inka.
              </p>
            </div>
          </div>
        </div>

        <div className="bg-black p-8 pt-16 md:p-7 md:p-14 lg:p-29 pb-0 md:pb-0 lg:pb-0 :lg:pt-4 lg:pt-6">
          <div className="flex flex-col md:flex-row justify-start items-center gap-4">
            <div className="w-full md:w-[55%] p-0 md:p-6" data-aos="fade-right">
              <h1 className="text-[20px] md:text-[36px] text-white text-center md:text-left uppercase mb-0 lg:mb-3">
                Shilpa Shetty Kundra
              </h1>
              <h2 className="text-[20px] md:text-[24px] text-text-primary text-center md:text-left mb-[25px] md:mb-3">
                Co-Founder
              </h2>
              <p className="max-w-[670px] text-[12px] md:text-[18px] text-white leading-[30px] text-wrap text-center md:text-left">
                Shilpa Shetty Kundra is a multifaceted personality, renowned as
                an actor, India’s pioneering celebrity YouTuber, wellness
                influencer, author, yoga practitioner, health and fitness icon,
                and entrepreneur. With an illustrious career spanning over 29
                years in the Indian film industry, she has left an indelible
                mark on television, radio, and OTT platforms. Notably, she made
                history as the first Indian to triumph on Celebrity Big Brother
                UK. Beyond her global fame, Shilpa has made significant strides
                in the health and fitness realm, introducing Yoga DVDs and her
                Her literary endeavors include two bestselling books, ‘The Great
                Indian Diet’ and ‘The Diary of a Domestic Diva,’ while her
                ‘Shilpa Shetty channel’ on YouTube showcases nutritious yet
                delectable recipes. A true epicurean, her culinary adventures
                harmonize seamlessly with her zest for exploring global
                cuisines.
              </p>
            </div>
            <div className="w-full md:w-[45%] flex justify-center items-center" data-aos="fade-left">
              <img
                src={v2}
                className="h-auto md:h-[690px] object-cover"
                alt=""
              />
            </div>
          </div>
        </div>

        <div className="bg-[#1C1B1B] p-8 pt-16 md:p-7 md:p-14 lg:p-29 pb-0 md:pb-0 lg:pb-0 md:pt-3 lg:pt-0">
          <div className="flex flex-col-reverse md:flex-row justify-start items-center gap-4">
            <div className="w-full md:w-[45%] flex justify-center items-center" data-aos="fade-right">
              <img src={v3} className="h-auto object-cover" alt="" />
            </div>
            <div className="w-full md:w-[55%] p-0 md:p-6" data-aos="fade-left">
              <h1 className="text-[20px] md:text-[36px] text-white text-center md:text-left uppercase mb-0 md:mb-3">
                Kunal Jani
              </h1>
              <h2 className="text-[20px] md:text-[24px] text-text-primary text-center md:text-left mb-[25px] md:mb-3">
                Co-Founder
              </h2>
              <p className="max-w-[630px] text-[12px] md:text-[18px] text-white leading-[30px] text-wrap text-center md:text-left">
                Kunal found his passion for food & hospitality through his
                extensive travels when he was growing up. An avid food
                enthusiast from the start, his deep-seated love for hospitality
                blossomed through the diverse culinary experiences he
                encountered across the globe. In collaboration with Ranjit
                Bindra, and later joined by Shilpa Shetty, he played an
                instrumental role in shaping and nurturing Bastian Hospitality
                into the thriving entity it is today. With his outgoing
                demeanour, warm disposition, and unwavering commitment to
                perfection, Kunal embodies the very essence of Bastian’s ethos.
              </p>
            </div>
          </div>
        </div>
      </div>

      <div className="w-full h-auto flex flex-col md:flex-row justify-center items-center p-2 py-12 px-0 gap-2 md:gap-8 md:py-16 md:my-2 relative">
        <div
          onMouseEnter={() => setHoveredCard2(1)}
          onMouseLeave={() => setHoveredCard2(null)}
          className="w-full h-[418.6px] md:w-[679px] md:h-[661px] relative img-hover" data-aos="fade-up"
        >
          <img src={card1} className="w-full h-full object-cover" alt="" />
          <div
            className={`${
              hoveredCard2 === 1 ? "bg-black/80" : "bg-black/50"
            } absolute inset-0 flex flex-col justify-center items-center`}
          >
            <h1
              className={`text-text-primary text-[36px] md:text-[44px] lg:text-[64px] leading-[1.1] transition-transform duration-500 ${
                hoveredCard2 === 1 ? "translate-y-[-60px]" : "translate-y-0"
              }`}
            >
              Vision
            </h1>
            <p
              className={`${
                hoveredCard2 === 1
                  ? "opacity-100 translate-y-0 ease-out duration-500 text-sm transition-all"
                  : "opacity-0 translate-y-10 ease-out duration-500 text-sm transition-all px-3"
              } max-w-[70%] text-center text-white px-4`}
              style={{
                height: hoveredCard2 === 1 ? "auto" : "0px",
                overflow: "hidden",
              }}
            >
              {`Bastian Hospitality Pvt. Ltd. launched in 2015, with an aim to cater to a well-traveled, knowledgeable customer base that is passionate about food and knows its beverage.`}
            </p>
          </div>
        </div>

        <div
          onMouseEnter={() => setHoveredCard2(2)}
          onMouseLeave={() => setHoveredCard2(null)}
          className="w-full h-[418.6px] md:w-[679px] md:h-[661px] relative img-hover" data-aos="fade-up"
        >
          <img src={card2} className="w-full h-full object-cover" alt="" />
          <div
            className={`${
              hoveredCard2 === 2 ? "bg-black/80" : "bg-black/50"
            } absolute inset-0 flex flex-col justify-center items-center`}
          >
            <h1
              className={`text-text-primary text-[36px] md:text-[44px] lg:text-[64px] leading-[1.1] transition-transform duration-500 ${
                hoveredCard2 === 2 ? "translate-y-[-60px]" : "translate-y-0"
              }`}
            >
              Mission
            </h1>
            <p
              className={`${
                hoveredCard2 === 2
                  ? "opacity-100 translate-y-0 ease-out duration-500 text-sm transition-all"
                  : "opacity-0 translate-y-10 ease-out duration-500 text-sm transition-all px-3"
              } max-w-[70%] text-center text-white px-4`}
              style={{
                height: hoveredCard2 === 2 ? "auto" : "0px",
                overflow: "hidden",
              }}
            >
              {`Dedicated to design and presentation, each venue under the Bastian Hospitality banner incorporates meticulous design that serves to enhance the dining experience.`}
            </p>
          </div>
        </div>

        <div
          className={`bg-black h-[150px] w-[150px] md:h-[250px] md:w-[250px] rounded-full absolute flex justify-center items-center transform duration-300 ${
            hoveredCard2 ? "scale-75" : "scale-100"
          }`}
        >
          <img src={logo} alt="" />
        </div>
      </div>
    </div>
  );
}
