import bg from "../assets/Images/HeroImgDs.png";
import bg2 from "../assets/Images/HeroImgMob.png";
import bgGredientImage from "../assets/Images/homeBannerGradient.png";
import HeroSection from "../components/HeroSection";
import BrandSlider from "../components/BrandSlider";
import Visionaries from "../components/Visionaries";
import ImageGrid from "../components/ImageGrid";
import AwardSlider from "../components/AwardSlider";
import Reservation from "../components/Reservation";
import HeroHeading from "../components/HeroHeading";
import { Helmet } from 'react-helmet';
import ReservationsEatApp from "../components/ReservationEatApp";

export default function Home() {
  const HeroImgText = {
    heading1: '“Bastian promises to be your ultimate escape, ',
    heading2: 'no matter the occasion or time of the day - every single time”',
  };
  const heroText = {
    heading: "Bastian Hospitality Group",
    text: `Redefining luxurious dining & nightlife with a vision of innovation,
      quality & expansion.`,
  };
  return (
    <div className="home-page w-full h-auto min-h-screen page-height p-0">
      <Helmet>
        <title>Best Restaurants in Mumbai | Luxury Private Dinning Restaurant</title>
        <meta
          name="description"
          content="Best restaurants in Mumbai - Bastian Hospitality. Reserve your private table for fine dining and luxury nightlife at our upscale restaurants, where celebrities dine."
        />
        <script type="application/ld+json">
          {`
          {  
            "@context": "https://schema.org",  
            "@type": "WebPage",  
            "url": "https://www.bastianhospitality.com/",  
            "name": "Bastian Hospitality",  
            "description": "Bastian Hospitality provides a deluxe escape for luxurious dining and nightlife, with a vision of innovation, quality & expansion.",  
            "about": {  
              "@type": "Organization",  
              "name": "Bastian Hospitality",  
              "url": "https://www.bastianhospitality.com/",  
              "logo": "https://www.bastianhospitality.com/assets/logo-BW7fw7nR.png",  
              "sameAs": [  
                "https://www.linkedin.com/company/bastian-hospitality/",  
                "https://www.instagram.com/bastianmumbai/"  
              ],  
              "department": [  
                {  
                  "@type": "Restaurant",  
                  "name": "Bastian Bandra",  
                  "url": "https://www.bastianhospitality.com/bastianbandra",  
                  "address": {  
                    "@type": "PostalAddress",  
                    "streetAddress": "Kamal Building, B/1, New, Linking Rd, next to Burger King, Bandra West",  
                    "addressLocality": "Mumbai",  
                    "addressRegion": "MH",  
                    "postalCode": "400050",  
                    "addressCountry": "IN"  
                  }  
                },  
                {  
                  "@type": "Restaurant",  
                  "name": "Bastian At The Top",  
                  "url": "https://www.bastianhospitality.com/bastianattop",  
                  "address": {  
                    "@type": "PostalAddress",  
                    "streetAddress": "48th Floor, Kohinoor Square, N C. Kelkar Marg, Dadar West, Shivaji Park",  
                    "addressLocality": "Mumbai",  
                    "addressRegion": "MH",  
                    "postalCode": "400028",  
                    "addressCountry": "IN"  
                  }  
                },  
                {  
                  "@type": "Restaurant",  
                  "name": "Bastian Garden City",  
                  "url": "https://www.bastianhospitality.com/bastiangarden",  
                  "address": {  
                    "@type": "PostalAddress",  
                    "streetAddress": "4, St Mark's Rd, Shanthala Nagar, Ashok Nagar",  
                    "addressLocality": "Bengaluru",  
                    "addressRegion": "KA",  
                    "postalCode": "560001",  
                    "addressCountry": "IN"  
                  }  
                },  
                {  
                  "@type": "Restaurant",  
                  "name": "Bastian Empire",  
                  "url": "https://www.bastianhospitality.com/bastianempire",  
                  "address": {  
                    "@type": "PostalAddress",  
                    "streetAddress": "The Westin, 36, Mundhwa Rd, Koregaon Park Annexe, Ghorpadi",  
                    "addressLocality": "Pune",  
                    "addressRegion": "MH",  
                    "postalCode": "411001",  
                    "addressCountry": "IN"  
                  }  
                }  
              ]  
            }  
          }

        `}
        </script>
      </Helmet>
      <div className="overflow-hidden">
        <HeroSection
          bg={bg}
          bg2={bg2}
          HeroImgText={HeroImgText}
          heroText={heroText}
          bgGredientImage={bgGredientImage}
        />
      </div>
      <div className="home-text-bottom" data-aos="fade-up">
        <HeroHeading heroText={heroText} />
      </div>
      <div>
        <BrandSlider />
      </div>
      <div>
        <Visionaries />
      </div>
      <div>
        <ImageGrid />
      </div>
      <div>
        <AwardSlider shoHeading={true} />
      </div>
      <div className="w-full h-auto bg-[#101010] reservation-sec py-14">
        {/* <Reservation col={false}/> */}
        <h1 className="text-[#F2CA99] text-[24px] md:text-[34px] lg:text-[48px] text-center mb-8">
          Make A Reservation
        </h1>
        <ReservationsEatApp />
      </div>
      {/* <div className="w-full h-auto bg-[#151515] md:hidden lg:hidden">
        <Reservation col={true} />
      </div> */}
    </div>
  );
}
