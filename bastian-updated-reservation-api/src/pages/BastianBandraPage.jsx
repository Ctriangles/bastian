import React from 'react';
import bg from "../assets/Images/HeroImgDs6.png";
import HeroSection from "../components/HeroSection";
import img1 from "../assets/Images/BastianBandra1.png";
import img2 from "../assets/Images/BastianBandra2.png";
import img3 from "../assets/Images/BastianBandra3.png";
import img4 from "../assets/Images/BastianBandra4.png";
import img5 from "../assets/Images/BastianBandra5.png";
import bgGredientImage from "../assets/Images/homeBannerGradient.png";
import img6 from "../assets/Images/BastianBandra6.png";
import img7 from "../assets/Images/BastianBandra7.png";
import mobImgOne from "../assets/Images/bastia-mob-img01.png";
import mobImgTwo from "../assets/Images/bastia-mob-img02.png";
import mobImgThree from "../assets/Images/bastia-mob-img03.png";
import img8 from "../assets/Images/BastianBandra8.png";
import Reservation from "../components/Reservation";
import RevealAnimation from "../components/RevealAnimation";
import { Helmet } from 'react-helmet';

export default function BastianBandraPage() {
  const HeroImgText = {
    heading1: "Bastian Bandra",
    heading2: `Bastian Bandra, our flagship since 2016, features a laid back vibe as expected from your favourite neighbourhood bar, with all the bells and whistles of a luxury global dining destination. The brand gets its name from <em>Sebastian The Crab</em> in the well known film, <em>The Little Mermaid</em>. Our recently renovated venue offers a casual yet vibrant space, perfect for those who want to enjoy an unparalleled meal or craft cocktails with friends.`,
    changeStyle: true,
  };  

  return (
    <div className="w-full h-auto min-h-screen page-height">

    <Helmet>
      <title>Top Restaurants in Bandra | Best Dinner Places in Mumbai</title>
      <meta 
        name="description" 
        content="Restaurants in Bandra - Bastian Hospitality. Book your table for luxury fine dine in Mumbai. Enjoy tasty dinner at top places with style, flavor, and ambience." 
      />
      <script type="application/ld+json">
        {`
          {
            "@context": "https://schema.org",
            "@type": "Restaurant",
            "name": "Bastian, Bandra",
            "image": "https://www.bastianhospitality.com/assets/logo-BW7fw7nR.png",
            "@id": "https://www.bastianhospitality.com/bastianbandra",
            "url": "https://www.bastianhospitality.com/bastianbandra",
            "telephone": "02250333555",
            "menu": "",
            "servesCuisine": "Seafood, Vegetarian Food",
            "acceptsReservations": "true",
            "address": {
              "@type": "PostalAddress",
              "streetAddress": "Kamal Building, B/1, New, Linking Rd, next to Burger King, Bandra West",
              "addressLocality": "Mumbai",
              "postalCode": "400050",
              "addressCountry": "IN"
            },
            "geo": {
              "@type": "GeoCoordinates",
              "latitude": 19.0635302,
              "longitude": 72.8322972
            },
            "openingHoursSpecification": [
              {
                "@type": "OpeningHoursSpecification",
                "dayOfWeek": [
                  "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"
                ],
                "opens": "12:00",
                "closes": "16:30"
              },
              {
                "@type": "OpeningHoursSpecification",
                "dayOfWeek": [
                  "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"
                ],
                "opens": "19:00",
                "closes": "01:00"
              }
            ],
            "sameAs": [
              "https://www.instagram.com/bastianmumbai/",
              "https://www.linkedin.com/company/bastian-hospitality/"
            ]
          }
        `}
      </script>
    </Helmet>
      {/* Hero Section */}
      <div className="attop-banner bastianbandra-banner">
        <HeroSection
          bg={bg}
          bg2={bg}
          HeroImgText={HeroImgText}
          bgGredientImage={bgGredientImage}
        />
      </div>

      {/* Content below the hero section */}
      <div className="-mt-[20px] md:-mt-[30px] w-full h-[194px] md:h-[683px] flex justify-center items-center pt-10 pb-2 px-4 md:pb-4 md:px-8 relative">
        <div className="w-full h-auto flex flex-row gap-1 md:gap-4">
          <div className="w-[40%]">
            <RevealAnimation>
              <div className="front"></div>
              <img
                src={img1}
                className="w-full h-[194px] md:h-[680px] object-cover"
                alt="Cozy corner dining area with patterned curtains"
              />
            </RevealAnimation>
          </div>
          <div className="w-[60%]">
            <RevealAnimation>
              <div className="front"></div>
              <img
                src={img2}
                className="w-full h-[194px] md:h-[680px] object-cover"
                alt="Luxury interior decoration of Bastian Bandra"
              />
            </RevealAnimation>
          </div>
        </div>
      </div>

      {/* Additional content sections */}
      <div className="w-full h-auto md:h-[903px] flex justify-center items-center py-2 px-4 md:py-4 md:px-8 mt-6">
        <div className="w-full h-auto flex flex-col md:flex-row justify-center items-center gap-4">
          <div
            style={{ backgroundImage: `url(${img3})` }}
            className="w-full md:w-[70%] bg-cover bg-center h-[386px] md:h-[903px] flex justify-center items-center"
          >
            <div className="w-[300px] h-[270px] md:w-[550px] md:h-[530px] bg-black/70 backdrop-blur-md rounded-2xl text-center md:text-left text-white flex justify-center items-center p-[13px] md:p-12">
              <div>
                <h1 className="text-text-primary text-[12px] md:text-[24px] mb-2 md:mb-4">
                  Seafood-Centric Excellence
                </h1>
                <p className="text-[12px] leading-[21px] md:text-[20px] md:leading-[31px] !leading-[21px] md:!leading-[31px]">
                  {`At the heart of Bastian Bandra is its seafood-forward menu, featuring the finest seafood reimagined by our expert chefs. With a focus on bold flavors and generous portions, each dish offers a signature twist that elevates the dining experience. Vegetarian and vegan options are equally celebrated, ensuring there's something for everyone.`}
                </p>
              </div>
            </div>
          </div>
          <div className="w-full md:w-[30%] flex flex-row md:flex-col gap-4 justify-center items-center">
            <div className="w-[40%] md:w-full">
              <RevealAnimation>
                <div className="front"></div>
                <img
                  src={img4}
                  className="w-full h-[177.19px] md:h-[440px]"
                  alt="Mac and cheese dish"
                />
              </RevealAnimation>
            </div>
            <div className="w-[60%] md:w-full">
              <RevealAnimation>
                <div className="front"></div>
                <img
                  src={img5}
                  className="w-full h-[177.19px] md:h-[440px]"
                  alt="Grilled cheesee lobster topped drizzled with lime juice"
                />
              </RevealAnimation>
            </div>
          </div>
        </div>
      </div>

      {/* Mobile Layout */}
      <div className="w-full h-auto mt-2 flex justify-center items-center block md:hidden px-4">
        <div className="w-full h-auto flex flex-col md:flex-row justify-center items-center gap-4">
          <div className="w-full flex flex-row md:flex-col gap-4 justify-center items-center">
            <div className="w-[59%] md:w-full">
              <RevealAnimation>
                <div className="front"></div>
                <img
                  src={mobImgThree}
                  className="w-full h-auto object-cover"
                  alt="Iced drink with orange slice"
                />
              </RevealAnimation>
            </div>
            <div className="w-[41%] md:w-full">
              <RevealAnimation>
                <div className="front"></div>
                <img
                  src={mobImgTwo}
                  className="w-full h-auto object-cover mb-3"
                  alt="Chocolate dessert"
                />
              </RevealAnimation>
              <RevealAnimation>
                <div className="front"></div>
                <img
                  src={mobImgOne}
                  className="w-full h-auto object-cover"
                  alt="People toasting with two colorful cocktails"
                />
              </RevealAnimation>
            </div>
          </div>
        </div>
      </div>

      {/* Craft Cocktails & Decadent Desserts */}
      <div className="w-full h-auto md:h-[724px] flex justify-center items-center mt-0 py-0 px-4 md:py-4 md:px-8 md:mt-4">
        <div className="w-full h-auto flex flex-col md:flex-row justify-center items-center gap-4">
          <div className="w-full md:w-[30%] flex flex-row md:flex-col gap-4 justify-center items-center">
            <div className="w-[40%] md:w-full">
              <RevealAnimation>
                <div className="front"></div>
                <img
                  src={img6}
                  className="w-full h-[177.19px] md:h-[726px] object-cover hidden md:block"
                  alt="Iced drink with orange slice"
                />
              </RevealAnimation>
            </div>
          </div>
          <div
            style={{ backgroundImage: `url(${img7})` }}
            className="w-full md:w-[70%] bg-cover bg-center h-full p-0 mt-0 md:h-[724px] flex justify-center items-end bg-removebox"
          >
            <div className="w-full md:min-h-[190px] bg-black/70 backdrop-blur-md text-center md:text-left text-white flex justify-center items-center max-w-[450px] md:max-w-full mt-0 pb-[10px] px-6 md:p-4 md:px-10">
              <div>
                <h1 className="text-text-primary text-[12px] md:text-[24px]">
                  Crafted Cocktails & Decadent Desserts
                </h1>
                <p className="text-[12px] !leading-[21px] md:text-[20px] md:!leading-[31px]">
                  {`Complementing the hearty portions are our carefully crafted cocktails and truly indulgent desserts. Known for our ‘more is more’ philosophy, we invite diners to unwind, enjoy, and indulge in a memorable meal where every detail is curated for ultimate satisfaction.`}
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>

      {/* Reservation Section */}
      <div className="w-full h-auto md:h-[926px] flex justify-center items-center py-2 px-0 pb-0 md:py-4 md:px-8 md: mt-4 md:mb-6">
        <div className="w-full h-auto flex flex-col md:flex-row gap-4">
          <div
            style={{ backgroundImage: `url(${img8})` }}
            className="w-full md:w-[60%] h-[568px] md:h-[926px] bg-cover bg-center relative max-w-[96%] mx-auto md:max-w-[100%]"
          >
            <div className="bg-black/50 absolute inset-0 text-white flex justify-center items-center">
              <p className="text-[16px] !leading-[1.7] max-w-[240px] text-center md:text-left md:text-[32px] md:max-w-[600px] px-4 font-light">
                At Bastian Bandra, every meal is an experience. With a laid-back vibe, indulgent flavors, and unforgettable moments, come for the food, stay for the vibe, and leave with lasting memories.
              </p>
            </div>
          </div>
          <div className="w-full md:w-[40%] flex justify-center items-center bg-[#151515]">
            <Reservation col={true} />
          </div>
        </div>
      </div>
    </div>
  );
}
