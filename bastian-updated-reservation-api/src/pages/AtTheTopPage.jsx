
import bg from "../assets/Images/HeroImgDs5.png";
import mobBg from "../assets/Images/bastianattopmob-banner.png";
import HeroSection from "../components/HeroSection";
import img1 from "../assets/Images/atTheTopImg1.png";
import img2 from "../assets/Images/mediaCard3.png";
import img3 from "../assets/Images/HeroImgDs2.jpg";

import img4 from "../assets/Images/mediaCard4.png";

import img5 from "../assets/grid-img2/img18.png";
import img6 from "../assets/grid-img2/attop-img04.png";
import img7 from "../assets/grid-img2/attop-img05.png";
import img8 from "../assets/grid-img2/attop-img06.png";

import img9 from "../assets/Images/atTheTopImg3.png";

import img10 from "../assets/Images/atTheTopCard1.png";
import img11 from "../assets/Images/atTheTopCard2.png";
import img12 from "../assets/Images/atTheTopCard3.png";
import img13 from "../assets/Images/atTheTopCard4.png";
import bgGredientImage from "../assets/Images/homeBannerGradient.png";
import Reservation from "../components/Reservation";
import { Helmet } from 'react-helmet';
export default function AtTheTopPage() {
  const HeroImgText = {
    heading1: "Bastian At The Top",
    heading2: `Opened in 2023 in Mumbai, Bastian At The Top redefines indulgence,  offering an elevated
dining experience you never knew you needed.`,
    changeStyle: true,
  };

  const gridImg = [img5, img6, img7];
  return (
    <div className="w-full h-auto min-h-screen page-height">
      <Helmet>
        <title>Best Restaurants in Dadar West for Dinner - Bastian Hospitality</title>
        <meta
          name="description"
          content="Best restaurants in Dadar – Bastian Hospitality. Book your table at top restaurants in Dadar West for the perfect dinner experience with elegant ambience"
        />
        <script type="application/ld+json">
          {`
          {
  "@context": "https://schema.org",
  "@type": "Restaurant",
  "name": "Bastian - At The Top",
  "image": "https://www.bastianhospitality.com/assets/logo-BW7fw7nR.png",
  "@id": "https://www.bastianhospitality.com/bastianattop",
  "url": "https://www.bastianhospitality.com/bastianattop",
  "telephone": "02250333555",
  "menu": "",
  "servesCuisine": "Veg and Non Veg Food",
  "acceptsReservations": "true",
  "address": {
    "@type": "PostalAddress",
    "streetAddress": "48th Floor, Kohinoor Square, N C. Kelkar Marg, Dadar West, Shivaji Park",
    "addressLocality": "Mumbai",
    "postalCode": "400028",
    "addressCountry": "IN"
  },
  "geo": {
    "@type": "GeoCoordinates",
    "latitude": 19.0249798,
    "longitude": 72.8389376
  },
  "openingHoursSpecification": [{
    "@type": "OpeningHoursSpecification",
    "dayOfWeek": "Tuesday",
    "opens": "00:00",
    "closes": "01:00"
  },{
    "@type": "OpeningHoursSpecification",
    "dayOfWeek": [
      "Wednesday",
      "Thursday"
    ],
    "opens": "17:00",
    "closes": "01:00"
  },{
    "@type": "OpeningHoursSpecification",
    "dayOfWeek": [
      "Friday",
      "Saturday"
    ],
    "opens": "12:00",
    "closes": "01:00"
  },{
    "@type": "OpeningHoursSpecification",
    "dayOfWeek": "Sunday",
    "opens": "12:00",
    "closes": "00:00"
  }],
  "sameAs": [
    "https://www.instagram.com/bastianmumbai/",
    "https://www.linkedin.com/company/bastian-hospitality/"
  ]
          }
        `}
        </script>
      </Helmet>
      <div className="attop-banner">
        <HeroSection bg={bg} bg2={mobBg} HeroImgText={HeroImgText} bgGredientImage={bgGredientImage} />
      </div>
      <div className="md:-mt-[30px] w-full h-auto flex flex-col md:flex-row justify-center items-center gap-2 md:gap-4 py-0 px-4 md:py-4 md:px-8 relative">
        <div className="w-full md:w-1/2 h-[398.78px] md:h-[682px]  overflow-hidden flex justify-center items-center">
          <img
            src={img1}
            className="w-full h-[398.78px] md:h-[680px] object-cover"
            alt="Bastian At The Top restaurant exterior view"
          />
        </div>
        <div className="w-full md:w-1/2  h-[398.78px] md:h-[682px] flex flex-col justify-center items-center gap-2 md:gap-4 overflow-hidden  ">
          <div className="w-full h-[341px]  text-white">
            <img
              src={img2}
              className="w-full h-[194.71px] md:h-[341px] object-cover"
              alt="Seating arrangement at Bastian At The Top"
            />
          </div>
          <div className="w-full h-[341px] text-white relative">
            <img
              src={img3}
              className="w-full h-[194.71px] md:h-[341px] object-cover"
              alt="Dinning arrangement at Bastian At The Top"
            />
            <div className="w-full h-auto bg-gradient-to-r from-black/70 absolute inset-0">
              <div className="absolute top-[40px] right-6 md:left-6 w-[218px] h-[210px] text-[12px] md:text-[20px] !leading-[21px] md:!leading-[30px]">
                Perched on the 48<sup>th</sup> floor of Kohinoor Square in Dadar, Bastian
                At The Top features a stunning rooftop dining area with
                breathtaking city views and a serene swimming pool.
              </div>
            </div>
          </div>
        </div>
      </div>
      <div className="w-full pt-2 md:py-4 px-4 md:py-4 md:px-8 ">
        <div
          style={{ backgroundImage: `url(${img4})` }}
          className=" w-full h-[499px] md:h-[1048px] bg-cover bg-fixed bg-center flex justify-center items-center"
        >
          <div className="w-[337px] h-[222px] md:w-[623px] md:h-[337px] bg-black/40 backdrop-blur-md rounded-2xl text-white text-center flex justify-center items-center p-4 md:mt-[-80px]">
            <p className="text-[12px] leading-[21px] md:text-[20px] md:leading-[28px] !leading-[21px] md:!leading-[30px]">
              Presents an unparalleled fusion of bold, captivating interiors and
              breathtaking 360-degree vistas, delectable cuisine and tantalising
              libations & the unmistakable Bastian ambiance, simultaneously
              thrilling & inviting. Weekdays cater to cosmopolitan diners
              seeking the quintessential Bastian experience, while weekends
              offer a liberating escape to Mumbai’s exclusive ‘Supper Club’
              scene with best-in-class DJs and world-renowned music.
            </p>
          </div>
        </div>
      </div>
      <div className="w-full h-auto flex justify-center items-center pt-2 pb-0 md:py-4 px-4 md:py-4 md:px-8 ">
        <div className="w-full  grid grid-cols-2 md:grid-cols-3 gap-2 md:gap-4">
          {gridImg.map((imgSrc, index) => (
            <img
              key={index}
              src={imgSrc}
              className={`w-full h-[250px] md:h-[574.8px] object-cover ${index === gridImg.length - 1 ? "col-span-2 md:col-span-1" : ""
                }`}
            />
          ))}
        </div>
      </div>
      <div className="w-full h-auto md:h-[538px] pt-2 md:py-4 px-4 md:py-4 md:px-8 ">
        <div
          style={{ backgroundImage: `url(${img8})` }}
          className="w-full h-[200.13px] md:h-[500px] bg-cover bg-fixed bg-center relative"
        >
          <div className="bg-gradient-to-r from-black/80 absolute inset-0"></div>
          <p className="absolute top-[80px] left-[20px] text-[12px] md:top-[200px] md:left-[80px] md:text-[20px] text-white max-w-[350px] !leading-[21px] md:!leading-[32px]">
            Known for its impeccable bar program, our mixologists surpass
            expectations, setting a new standard in cocktail craft, as the city
            knows it.
          </p>
        </div>
      </div>
      <div className="w-full h-[313px] md:h-[423px] pt-2 md:py-4 px-4 md:py-4 md:px-8  hidden md:block">
        <div
          style={{ backgroundImage: `url(${img9})` }}
          className=" bg-cover bg-center w-full h-[290px] md:h-[390px] bg-fixed flex justify-center items-center relative"
        >
          <div className="bg-black/40 backdrop-blur-sm opacity-150 w-full absolute inset-0  h-[290px] md:h-[390px]"></div>
          <div className="absolute text-white md:w-[621px] text-center">
            <p className="text-[12px] md:text-[20px] !leading-[21px] md:!leading-[30px]">
              The brand has become the go-to for the cities’ celebrities,
              trendsetters, & prominent business personalities as the place to
              spend every occasion - a weekday dinner out, or a thrilling
              weekend.
            </p>
          </div>
        </div>
      </div>
      <div className=" w-full h-auto pt-2 md:py-4 px-0 md:py-4 md:px-8 flex justify-center items-center form-section">
        <div className="w-full flex flex-col inner-row md:flex-row justify-center items-center gap-2 md:gap-4">
          <div className="w-full md:w-[60%] col-img grid grid-cols-2 gap-2 md:gap-4 px-4 md:px-0">
            <img
              src={img10}
              alt="Backlit ceramic shelf at Bastian At The Top"
              className="h-[242px] md:h-[500px] w-full object-cover mb-2 md:mb-0" // Set a fixed height
            />
            <img
              src={img11}
              alt="Pool View at Bastian At The Top"
              className="h-[340px] md:h-[676px] w-full object-cover" // Set a fixed height
            />
            <img
              src={img12}
              alt="Beautiful Pool View at Bastian"
              className="h-[220px] md:h-[478px] w-full object-cover -mt-[100px] md:-mt-[180px]" // Set a fixed height
            />
            <img
              src={img13}
              alt="Luxury Interior View at Bastian At The Top"
              className="h-[118px] md:h-[300px] w-full object-cover" // Set a fixed height
            />
          </div>
          <div className="w-full h-auto md:h-[423px] block md:hidden px-4">
            <div
              style={{ backgroundImage: `url(${img9})` }}
              className=" bg-cover bg-center w-full h-[290px] bg-fixed md:h-[390px] flex justify-center items-center relative"
            >
              <div className="bg-black/20 backdrop-blur-sm w-full absolute inset-0 h-[290px] md:h-[390px]"></div>
              <div className="absolute text-white md:w-[756px] text-center">
                <p className="text-[12px] md:text-[24px] !leading-[20px] md:!leading-[38px] px-4 max-w-[330px]">
                  The brand has become the go-to for the cities’ celebrities,
                  trendsetters, & prominent business personalities as the place
                  to spend every occasion - a weekday dinner out, or a thrilling
                  weekend.
                </p>
              </div>
            </div>
          </div>

          <div className="w-full md:w-[40%] form-col h-[588px] md:h-[994px] bg-[#151515] flex flex-col justify-center items-center gap-12">
            <Reservation col={true} />
          </div>
        </div>
      </div>
    </div>
  );
}
