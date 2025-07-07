import HeroSection from "../components/HeroSection";
import Reservation from "../components/Reservation";
import bg from "../assets/Images/HeroImgDs7.png";
import mobBg from "../assets/Images/bastiangarden-mob-banner.png";

import img1 from "../assets/Images/HeroImgDs.png";
import img2 from "../assets/Images/HeroImgMob.png";
import img3 from "../assets/Images/bastianGarden1.png";
import bgGredientImage from "../assets/Images/homeBannerGradient.png";
import img4 from "../assets/Images/bastianGarden2.png";
import img5 from "../assets/Images/bastianGarden3.png";
import img6 from "../assets/Images/bastianGarden4.png";
import img7 from "../assets/Images/bastianGarden5.png";
import img8 from "../assets/Images/bastianGarden6.png";
import img9 from "../assets/Images/bastianGarden7.png";
import img10 from "../assets/Images/bastianGarden8.png";
import img11 from "../assets/Images/bastianGarden9.png";
import img12 from "../assets/Images/bastianGarden10.png";
import gardencity01 from "../assets/grid-img/gardencitydesk01.png";
import gardencity02 from "../assets/grid-img/gardencitydesk02.png";
import gardencity03 from "../assets/grid-img/gardencitydesk03.png";
import gardencity04 from "../assets/grid-img/gardencitydesk04.png";
import gardencity05 from "../assets/grid-img/gardencitydesk05.png";
import gardencity06 from "../assets/grid-img/gardencitydesk06.png";
import gardencity07 from "../assets/grid-img/gardencitydesk07.png";
import gardencity08 from "../assets/grid-img/gardencitydesk08.png";
import gardencity09 from "../assets/grid-img/gardencitydesk09.png";
import bastianMob01 from "../assets/Images/bastiangardenmob-img01.png";
import bastianMob02 from "../assets/Images/bastiangardenmob-img02.png";
import bastianMob03 from "../assets/Images/bastiangardenmob-img03.png";
import bastianMob04 from "../assets/Images/bastiangardenmob-img04.png";
import bastianMob05 from "../assets/Images/bastiangardenmob-img05.png";
import bastianMob06 from "../assets/Images/bastiangardenmob-img06.png";
import { Helmet } from 'react-helmet';

const imgGrid = [
  {
    src: img4,
  },
  {
    src: img5,
    text: true,
    heading: "Your Destination for Indulgence",
    subheading: `Housed in a luxurious Bengaluru bungalow, Bastian Garden City feels
like a chic holiday spot. Inspired by global trends and tailored to local tastes, it blends our signature vibe with regional ingredients. Every visit offers a unique
yet familiar Bastian experience, the perfect city escape.`,
  },
  {
    src: img6,
  },
  {
    src: img7,
  },
  {
    src: img8,
  },
  {
    text: true,
    bg: false,
    heading: "Unique Dining & F&B Experience",
    subheading: `With an extensive wine menu and unique food, our latest offers an F&B experience the city hasn’t seen before – an innovative vegan menu, a one-of-a-kind bakery, a curated coffee program, and a Sunday brunch that transports you to your favourite international destination.`,
  },
  {
    src: img9,
  },
  {
    src: img10,
  },
  {
    src: img11,
  },
  {
    src: img12,
  },
  {
    src: img8,
  },
  {
    src: img6,
  },
];

export default function BastianGardenCity() {
  const HeroImgText = {
    heading1: "Bastian Garden City",
    heading2: `Located in Bengaluru, Bastian Garden City brings a chic, holiday-inspired vibe with stunning décor influenced by top travel destinations. Set in an opulent city-center bungalow, it combines global trends with local flair.`,
    changeStyle: true,
  };
  return (
    <div className="w-full h-auto min-h-screen page-height">
          <Helmet>
            <title>Best Restaurants in Bangalore | Fine Dining Places in Bengaluru</title>
            <meta 
              name="description" 
              content="Best restaurants in Bangalore - Bastian Garden. Book your table at top dinner places in Bengaluru and enjoy fine dining with luxury vibes like a 5-star hotel." 
            />
            <script type="application/ld+json">
              {`
                {
  "@context": "https://schema.org",
  "@type": "Restaurant",
  "name": "Bastian Garden City",
  "image": "https://www.bastianhospitality.com/assets/logo-BW7fw7nR.png",
  "@id": "https://www.bastianhospitality.com/bastiangarden",
  "url": "https://www.bastianhospitality.com/bastiangarden",
  "telephone": "09880081644",
  "menu": "",
  "servesCuisine": "Veg and Non Veg Food",
  "acceptsReservations": "true",
  "address": {
    "@type": "PostalAddress",
    "streetAddress": "4, St Mark's Rd, Shanthala Nagar, Ashok Nagar",
    "addressLocality": "Bengaluru,",
    "postalCode": "560001",
    "addressCountry": "IN"
  },
  "geo": {
    "@type": "GeoCoordinates",
    "latitude": 12.9696834,
    "longitude": 77.5976599
  },
  "openingHoursSpecification": {
    "@type": "OpeningHoursSpecification",
    "dayOfWeek": [
      "Monday",
      "Tuesday",
      "Wednesday",
      "Thursday",
      "Friday",
      "Saturday",
      "Sunday"
    ],
    "opens": "12:00",
    "closes": "01:00"
  },
  "sameAs": [
    "https://www.instagram.com/bastianmumbai/",
    "https://www.linkedin.com/company/bastian-hospitality/"
  ] 
                }
              `}
            </script>
          </Helmet>
      <div className="attop-banner bastianbandra-banner">
        <HeroSection
          bg={bg}
          bg2={mobBg}
          HeroImgText={HeroImgText}
          bgGredientImage={bgGredientImage}
        />
      </div>

      <div className="-mt-[20px] md:-mt-[30px] w-full h-auto md:h-[683px] flex justify-center items-center p-4 pt-5 md:pt-10 pb-2 px-5 md:pb-4 md:px-8 relative">
        <div className="w-full h-auto flex flex-wrap md:flex-nowrap gap-3 md:gap-4 md:gap-4">
          <div className="w-full md:w-[60%]">
            <img
              src={img1}
              className="w-full h-auto md:h-[680px] object-cover"
              alt="Stylish indoor dining hall"
            />
          </div>
          <div className="w-full md:w-[40%]">
            <div className="w-full flex flex-wrap justify-between">
              <div className="w-[49%] md:w-[100%]">
                <img
                  src={img2}
                  className="w-full h-auto md:h-[680px] object-cover"
                  alt="Arched dining hallway"
                />
              </div>
              <div className="w-[49%] md:w-[100%] block md:hidden">
                <img
                  src={img4}
                  className="w-full h-[100%] md:h-[680px] object-cover"
                  alt="Outdoor rustic lounge"
                />
              </div>
            </div>
          </div>
        </div>
      </div>
      <div className="w-full h-auto flex justify-between items-center p-2 mt-6 md:pb-4 md:px-8 hidden md:block bastian-garden-gallery">
        <div className="desktopGallery w-full justify-center items-center ">
          <div className="image-gallery-wrp max-w-[100%] px-0">
            <div className="col-left">
              <div className="imageWrap">
                <img src={gardencity01} alt="Outdoor view of Bastian Garden" />
              </div>
              <div className="imageWrap">
                <img src={gardencity02} alt="Cozy modern restuarant interior" />
              </div>
              <div className="imageWrap">
                <div className="content max-w-[375px] py-3 md:min-h-[300px] lg:min-h-[350px]">
                  <h4 className="text-text-primary text-[20px] lg:text-[24px] pt-3">
                    Unique Dining & F&B Experience
                  </h4>
                  <p className="text-white md-[18px] lg:text-xl md:!leading-[1.6]">
                    With an extensive wine menu and unique food, our latest
                    offers an F&B experience the city hasn’t seen before – an
                    innovative vegan menu, a one-of-a-kind bakery, a curated
                    coffee program, and a Sunday brunch that transports you to
                    your favourite international destination.
                  </p>
                </div>
              </div>
              <div className="imageWrap">
                <img src={gardencity03} alt="Burger and drinks served at table" />
              </div>
            </div>
            <div className="col-right">
              <div className="imageWrap w-full bg-img">
                {/* <img src={gardencity04} alt="" /> */}
                <div
                  style={{ backgroundImage: `url(${gardencity04})` }}
                  className="w-full md:w-[100%] bg-cover bg-center flex px-5 items-end bg-removebox"
                >
                  <div className="w-full md:min-h-[350px] lg:min-h-[444px] text-center md:text-left text-white flex items-center">
                    <div>
                      <h1 className="text-text-primary text-[12px] md:text-[24px]">
                        Your Destination for Indulgence
                      </h1>

                      <p className="text-[12px] !leading-[21px] md:text-[18px] lg:text-[20px] md:!leading-[1.4] max-w-[370px] w-full">
                        {`Housed in a luxurious Bengaluru bungalow, Bastian Garden City feels
                          like a chic holiday spot. Inspired by global trends and tailored to local tastes, it blends our signature vibe with regional ingredients. Every visit offers a unique
                          yet familiar Bastian experience, the perfect city escape.`}
                      </p>
                    </div>
                  </div>
                </div>
              </div>
              <div className="imageWrap flex gap-4 p-0">
                <img src={gardencity05} alt="Multiple dishes served at table" className="w-[49%]" />
                <img src={gardencity06} alt="A table filled with various plates of food" className="w-[49%]" />
              </div>
              <div className="imageWrap flex gap-3 p-0">
                <div className="col-img">
                  <img src={gardencity07} alt="Luxury dessert served at table" className="mb-4 w-[99%]" />
                  <img src={gardencity08} alt="A woman holds a fork and knife above a donut" className="w-[99%]" />
                </div>
                <div className="right-img">
                  <img src={gardencity09} alt="A table set with a variety of foods" />
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div className="w-full block md:hidden px-5 mt-[30px] mb-[40px]">
        <div className="content-box text-center max-w-[360px] mx-auto">
          <h1 className="text-[16px] text-text-primary mb-2">
            Your Destination for Indulgence
          </h1>
          <p className="text-[12px] text-white !leading-[1.7]">
            Nestled in an opulent bungalow in the heart of Bengaluru, Bastian
            Garden City transports you to a chic holiday destination. Inspired
            by global trends, we've tailored every detail to resonate with local
            tastes, blending our signature vibe with local ingredients and
            preferences. Each visit offers a unique yet familiar Bastian
            experience, making it the perfect escape within the city.
          </p>
        </div>
      </div>
      <div className="w-full h-auto block md:hidden relative px-5">
        <div className="w-full h-auto flex flex-wrap md:flex-nowrap gap-2 md:gap-4 md:gap-4">
          <div className="w-full md:w-[60%]">
            <img
              src={bastianMob01}
              className="w-full h-auto md:h-[680px] object-cover"
              alt="Luxury interior of Bastian Garden"
            />
          </div>
          <div className="w-full md:w-[40%]">
            <div className="w-full flex flex-wrap justify-between">
              <div className="w-[49%] md:w-[100%]">
                <img
                  src={bastianMob02}
                  className="w-full h-auto md:h-[680px] object-cover"
                  alt="A table filled with various dishes"
                />
              </div>
              <div className="w-[49%] md:w-[100%] block md:hidden">
                <img
                  src={bastianMob03}
                  className="w-full h-[100%] md:h-[680px] object-cover"
                  alt="Dishes served at the table"
                />
              </div>
            </div>
          </div>
        </div>
      </div>
      <div className="w-full block md:hidden px-5 mt-[20px] mb-[30px]">
        <div className="content-box text-center max-w-[360px] mx-auto">
          <h1 className="text-[16px] text-text-primary mb-2">
            Unique Dining & F&B Experience
          </h1>
          <p className="text-[12px] text-white  !leading-[1.4]">
            With an extensive wine menu and unique food offering, our latest
            boasts an F&B experience that the city has not seen before - an
            extremely innovative vegan menu, a bakery like no other, a
            well-crafted coffee program, and a Sunday brunch that transports you
            to your favourite international destination.
          </p>
        </div>
      </div>
      <div className="w-full h-auto mt-3 flex justify-center items-center block md:hidden px-5">
        <div className="w-full h-auto flex flex-col md:flex-row justify-center items-center gap-4">
          <div className="w-full flex flex-row md:flex-col gap-[7px] justify-center items-center">
            <div className="w-[59%] md:w-full">
              <img
                src={bastianMob04}
                className="w-full h-auto object-cover"
                alt="Tasty dishes on the table"
              />
            </div>
            <div className="w-[41%] md:w-full">
              <img
                src={bastianMob05}
                className="w-full h-auto object-cover mb-2"
                alt="Juice and dishes on the table"
              />
              <img
                src={bastianMob06}
                className="w-full h-auto object-cover"
                alt="Woman holding a fork and knife over a donut"
              />
            </div>
          </div>
        </div>
      </div>

      <div className="w-full h-auto md:h-[926px] flex justify-center items-center p-0 mb-[-1px] mt-1 md:mb-4 md:pb-4 md:px-8">
        <div className="w-full h-auto flex flex-col md:flex-row gap-0 md:gap-4">
          <div
            style={{ backgroundImage: `url(${img3})` }}
            className="w-full md:w-[60%] h-[568px] md:h-[926px] bg-cover bg-center relative"
          >
            <div className="bg-black/60 absolute inset-0 text-white flex justify-center items-center">
              <p className="text-center text-[16px] md:text-[26px] lg:text-[32px] md:w-[600px] !leading-[20px] md:!leading-[1.36] lg:!leading-[1.56] max-w-[327px] md:max-w-[100%] mx-auto">
                Set in a stunning space with décor inspired by chic holiday
                destinations across the world.
              </p>
            </div>
          </div>
          <div className="w-full md:w-[40%] flex justify-center items-center bg-[#151515] h-[680px] md:h-auto">
            <Reservation col={true} />
          </div>
        </div>
      </div>
    </div>
  );
}
