
import bg from "../assets/Images/Landscape Header - 1.jpg";
import mobBg from "../assets/Images/bastianempiremob.jpg";
import HeroSection from "../components/HeroSection";
import img1 from "../assets/Images/Interiors - 1.jpg";
import img2 from "../assets/Images/Interiors - 5.jpg";
import img3 from "../assets/Images/Interiors - 3.jpg";
import img4 from "../assets/Images/Landscape Header - 2.jpg";
import img5 from "../assets/Images/Food - 1.jpg";
import img6 from "../assets/Images/Food - 2.jpg";
import img7 from "../assets/Images/Food - 3.jpg";
import img8 from "../assets/Images/Interiors - 9.jpg";
import img10 from "../assets/Images/Interiors - 2.jpg";
import img11 from "../assets/Images/Interiors - 4.jpg";
import img12 from "../assets/Images/Interiors - 6.jpg";
import img13 from "../assets/Images/Interiors - 7.jpg";
import bgGredientImage from "../assets/Images/homeBannerGradient.png";
import Reservation from "../components/Reservation";
import { Helmet } from 'react-helmet';

export default function AtTheTopPage() {
  const HeroImgText = {
    heading1: "Bastian Empire",
    heading2: `Our latest launch in Pune, Bastian Empire depicts the inimitable blend of everything that the Bastian brand is known for: bold, striking interiors, glorious F&B offerings, and a distinctive vibe that feels exciting yet comfortable at the same time. `,
    changeStyle: true,
  };

  const gridImg = [img5, img6, img7];
  return (
    <div className="w-full h-auto min-h-screen page-height">
      <Helmet>
        <title>Best Restaurants in Pune | Top Dining Restaurant in Koregaon Park</title>
        <meta
          name="description"
          content="Best restaurants in Pune - Bastian Empire. Explore Pune famous restaurants for top-class dinning and unforgettable food experiences. Reserve your table now!"
        />
        <script type="application/ld+json">
          {`
            {
              "@context": "https://schema.org",
              "@type": "Restaurant",
              "name": "Bastian Empire",
              "image": "https://www.bastianhospitality.com/assets/logo-BW7fw7nR.png",
              "@id": "https://www.bastianhospitality.com/bastianempire",
              "url": "https://www.bastianhospitality.com/bastianempire",
              "telephone": "",
              "menu": "",
              "servesCuisine": "Veg and Non Veg Food",
              "acceptsReservations": "true",
              "address": {
                "@type": "PostalAddress",
                "streetAddress": "The Westin, 36, Mundhwa Rd, Koregaon Park Annexe, Ghorpadi",
                "addressLocality": "Pune",
                "postalCode": "411001",
                "addressCountry": "IN"
              },
              "geo": {
                "@type": "GeoCoordinates",
                "latitude": 18.5390352,
                "longitude": 73.9034055
              },
              "openingHoursSpecification": [{
                "@type": "OpeningHoursSpecification",
                "dayOfWeek": [
                  "Tuesday",
                  "Wednesday"
                ],
                "opens": "19:00",
                "closes": "01:00"
              },{
                "@type": "OpeningHoursSpecification",
                "dayOfWeek": [
                  "Thursday",
                  "Friday",
                  "Saturday",
                  "Sunday"
                ],
                "opens": "12:00",
                "closes": "01:00"
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
            alt="Bastian Logo with elegant decor"
          />
        </div>
        <div className="w-full md:w-1/2  h-[398.78px] md:h-[682px] flex flex-col justify-center items-center gap-2 md:gap-4 overflow-hidden  ">
          <div className="w-full h-[341px]  text-white">
            <img
              src={img2}
              className="w-full h-[194.71px] md:h-[341px] object-cover"
              alt="Warm-toned dining area with soft lighting"
            />
          </div>
          <div className="w-full h-[341px] text-white relative">
            <img
              src={img3}
              className="w-full h-[194.71px] md:h-[341px] object-cover"
              alt="Chic and stylish fine dining space"
            />
            <div className="w-full h-auto bg-gradient-to-r from-black/70 absolute inset-0">
              {/* <div className="absolute top-[40px] right-6 md:left-6 w-[218px] h-[210px] text-[12px] md:text-[20px] !leading-[21px] md:!leading-[30px]">
                Located in a high-rise, our 220-seater venue takes inspiration from contemporary caves, boasting a Cappadocia-inspired entrance, rustic cobblestone flooring, and a wabi-sabi aesthetic that seamlessly blends polished and raw elements for a truly global aesthetic and experience.
              </div> */}
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
              Located in a high-rise, our 220-seater venue takes inspiration from contemporary caves, boasting a Cappadocia-inspired entrance, rustic cobblestone flooring, and a wabi-sabi aesthetic that seamlessly blends polished and raw elements for a truly global aesthetic and experience.
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
            The interiors create a chic yet relaxed vibe—perfect for Instagram-worthy moments. Unparalleled nightlife elevates the energy of the space which seamlessly blend party, perfectly crafted cocktails and dining vibes for a great, world-class experience.
          </p>
        </div>
      </div>
      {/* <div className="w-full h-[313px] md:h-[423px] pt-2 md:py-4 px-4 md:py-4 md:px-8  hidden md:block">
        <div
          style={{ backgroundImage: `url(${img9})` }}
          className=" bg-cover bg-center w-full h-[290px] md:h-[390px] bg-fixed flex justify-center items-center relative"
        >
          <div className="bg-black/40 backdrop-blur-sm opacity-150 w-full absolute inset-0  h-[290px] md:h-[390px]"></div>
          <div className="absolute text-white md:w-[621px] text-center">
            <p className="text-[12px] md:text-[20px] !leading-[21px] md:!leading-[30px]">
              The interiors create a chic yet relaxed vibe—perfect for Instagram-worthy moments. Unparalleled nightlife elevates the energy of the space which seamlessly blend party, perfectly crafted cocktails and dining vibes for a great, world-class experience.
            </p>
          </div>
        </div>
      </div> */}
      <div className=" w-full h-auto pt-2 md:py-4 px-0 md:py-4 md:px-8 flex justify-center items-center form-section">
        <div className="w-full flex flex-col inner-row md:flex-row justify-center items-center gap-2 md:gap-4">
          <div className="w-full md:w-[60%] col-img grid grid-cols-2 gap-2 md:gap-4 px-4 md:px-0">
            <img
              src={img10}
              alt="Elegant restaurant interior at Bastian Empire"
              className="h-[242px] md:h-[500px] w-full object-cover mb-2 md:mb-0" // Set a fixed height
            />
            <img
              src={img11}
              alt="Elegant dining setup with artistic lighting"
              className="h-[340px] md:h-[676px] w-full object-cover" // Set a fixed height
            />
            <img
              src={img12}
              alt="Cave-inspired cozy seating"
              className="h-[220px] md:h-[478px] w-full object-cover -mt-[100px] md:-mt-[180px]" // Set a fixed height
            />
            <img
              src={img13}
              alt="Wooden louvered doors with ambient lighting"
              className="h-[118px] md:h-[300px] w-full object-cover" // Set a fixed height
            />
          </div>
          {/* <div className="w-full h-auto md:h-[423px] block md:hidden px-4">
            <div
              style={{ backgroundImage: `url(${img9})` }}
              className=" bg-cover bg-center w-full h-[290px] bg-fixed md:h-[390px] flex justify-center items-center relative"
            >
              <div className="bg-black/20 backdrop-blur-sm w-full absolute inset-0 h-[290px] md:h-[390px]"></div>
              <div className="absolute text-white md:w-[756px] text-center">
                <p className="text-[12px] md:text-[24px] !leading-[20px] md:!leading-[38px] px-4 max-w-[330px]">
                The interiors create a chic yet relaxed vibe—perfect for Instagram-worthy moments. Unparalleled nightlife elevates the energy of the space which seamlessly blend party, perfectly crafted cocktails and dining vibes for a great, world-class experience.
                </p>
              </div>
            </div>
          </div> */}

          <div className="w-full md:w-[40%] form-col h-[588px] md:h-[994px] bg-[#151515] flex flex-col justify-center items-center gap-12">
            <Reservation col={true} />
          </div>
        </div>
      </div>
    </div>
  );
}
