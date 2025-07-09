import bg from "../assets/Images/awardsBg.png";
import mobBg from "../assets/Images/awardsmobbannerBg.png";
import HeroSection from "../components/HeroSection";
import img1 from "../assets/Images/awardsBg2.png";
import img2 from "../assets/Images/HeroImgDs.png";

import img3 from "../assets/Images/awardsCard1.png";
import img4 from "../assets/Images/awardsCard2.png";
import img5 from "../assets/Images/awardsCard3.png";
import img6 from "../assets/Images/awardsCard4.png";
import img7 from "../assets/Images/awardsCard5.png";
import img8 from "../assets/Images/awardsCard6.png";
import AwardSlider from "../components/AwardSlider";
import bgGredientImage from "../assets/Images/homeBannerGradient.png";
import 'aos/dist/aos.css';
import { Helmet } from 'react-helmet';

export default function AwardsPage() {
  
  const HeroImgText = {
    heading1: "Awards",
    heading2: `A celebration of culinary excellence and unparalleled service, our 20+ awards across categories reflect the 
pinnacle of luxury dining. Each accolade honors the passion, innovation, and artistry that define the Bastian experience.`,
    changeStyle: true,
  };
  return (
    <div className="w-full h-auto min-h-screen page-height award-page">
          <Helmet>
            <title>Bastian Awards - Recognitions</title>
            <meta 
              name="description" 
              content="Celebrate the accolades and honors that acknowledge Bastian's excellence in hospitality." 
            />
          </Helmet>
      <div>
        <HeroSection bg={bg} bg2={mobBg} HeroImgText={HeroImgText} bgGredientImage={bgGredientImage} />
      </div>

      <div
        style={{ backgroundImage: `url(${img1})` }}
        className="w-full h-[1200px] md:h-[623px] relative bg-cover bg-center p-4 bg-fixed overflow-hidden"
      >
        <div className="bg-black/80 backdrop-blur-[2px] absolute inset-0 w-full h-full md:h-[623px] flex justify-center items-center  ">
          <div className="flex flex-col md:flex-row justify-center  gap-8 w-[90%]" data-aos="fade-up">
            <div className="w-full md:w-[20%] flex justify-center items-center mb-[40px] md:mb-[0]">
              <h1 className="text-white text-[36px] md:text-[64px]">2024</h1>
            </div>
            <div className="w-full md:w-[40%] flex flex-col justify-center items-start gap-0 gap:md-[10] ">
              <div className="text-[16px] md:text-[18px] lg:text-[20px] mb-12 md:mb-[30px] lg:mb-[50px] flex flex-col justify-center items-center md:items-start w-full px-[20px] md:pr-[40px] md:pl-[0]">
                <h1 className="text-text-primary font-light">Nightclub of the Year</h1>
                <h4 className="text-white font-light">
                  Bastian at the Top &ndash; ET Hospitality World
                </h4>
              </div>
              <div className="text-[16px] md:text-[18px] lg:text-[20px] mb-12 md:mb-[30px] lg:mb-[50px] flex flex-col justify-center items-center md:items-start w-full px-[20px] md:pr-[40px] md:pl-[0]">
                <h1 className="text-text-primary font-light">
                  Luxury Dining Restaurant of the Year
                </h1>
                <h4 className="text-white font-light">
                  Bastian Garden City &ndash; ET Hospitality World
                </h4>
              </div>
              <div className="text-[16px] md:text-[18px] lg:text-[20px] mb-12 md:mb-[30px] lg:mb-[50px] flex flex-col justify-center items-center md:items-start w-full px-[20px] md:pr-[40px] md:pl-[0]">
                <h1 className="text-text-primary font-light">
                  Nightlife Avenue of the Year
                </h1>
                <h4 className="text-white font-light">Times Food & Nightlife Awards</h4>
              </div>
              <div className="text-[16px] md:text-[18px] lg:text-[20px] mb-12 md:mb-[30px] lg:mb-[50px] flex flex-col justify-center items-center md:items-start w-full px-[20px] md:pr-[40px] md:pl-[0]">
                <h1 className="text-text-primary font-light">
                  Best Global &mdash; Premium Dining
                </h1>
                <h4 className="text-white font-light">Times Food & Nightlife Awards</h4>
              </div>
              <div className="text-[16px] md:text-[18px] lg:text-[20px]  flex flex-col justify-center items-center md:items-start w-full">
                <h1 className="text-text-primary font-light">Best Bar &mdash; Nightlife</h1>
                <h4 className="text-white font-light">Times Food & Nightlife Awards</h4>
              </div>
            </div>
            <div className="w-full md:w-[40%] flex flex-col items-start gap-0 gap:md-[10] ">
              <div className="text-[16px] md:text-[18px] lg:text-[20px] mb-12 md:mb-[30px] lg:mb-[50px] flex flex-col justify-center items-center md:items-start w-full px-[20px] md:pr-[40px] md:pl-[0]">
                <h1 className="text-text-primary text-center md:text-left font-light">
                  Restaurant with Outstanding Ambience & Design
                </h1>
                <h4 className="text-white font-light">
                  Bastian Garden City &ndash; ET Hospitality World
                </h4>
              </div>
              <div className="text-[16px] md:text-[18px] lg:text-[20px] mb-12 md:mb-[30px] lg:mb-[50px] flex flex-col justify-center items-center md:items-start w-full px-[20px] md:pr-[40px] md:pl-[0]">
                <h1 className="text-text-primary font-light">
                  Restaurateur Icon of the Year &mdash; Mr. Ranjit Bindra
                </h1>
                <h4 className="text-white font-light">ET Hospitality World</h4>
              </div>
              <div className="text-[16px] md:text-[18px] lg:text-[20px] mb-12 md:mb-[30px] lg:mb-[50px] flex flex-col justify-center items-center md:items-start w-full px-[20px] md:pr-[40px] md:pl-[0]">
                <h1 className="text-text-primary font-light">Restaurant of the Year</h1>
                <h4 className="text-white text-center md:text-left font-light">
                  Bastian At The Top &ndash; Times Food & Nightlife Awards
                </h4>
              </div>
              <div className="text-[16px] md:text-[18px] lg:text-[20px] mb-12 md:mb-[30px] lg:mb-[50px] flex flex-col justify-center items-center md:items-start w-full px-[20px] md:pr-[40px] md:pl-[0]">
                <h1 className="text-text-primary font-light">
                  Entrepreneur of the Year &mdash; Mr. Ranjit Bindra
                </h1>
                <h4 className="text-white font-light">Times Food & Nightlife Awards</h4>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div
        style={{ backgroundImage: `url(${img2})` }}
        className="w-full h-[594px] md:h-[623px] bg-fixed overflow-hidden relative bg-cover bg-center p-4"
      >
        <div className="bg-black/80 backdrop-blur-[2px] absolute inset-0 w-full h-[594px] md:h-[623px] flex justify-center items-center  ">
          <div className="flex flex-col-reverse md:flex-row justify-center gap-0 gap:md-[10] w-full md:w-[90%]" data-aos="fade-up">
            <div className="gap-0 gap:md-[10]">
              <div className="text-[16px] md:text-[18px] lg:text-[20px] mb-12 md:mb-[30px] lg:mb-[50px] flex flex-col justify-center items-center md:items-start w-full px-[20px] md:pr-[40px] md:pl-[0]">
                <h1 className="text-text-primary font-light">Dynamic Restaurateur</h1>
                <h4 className="text-white font-light">ET FNB Leaders Awards</h4>
              </div>
              <div className="text-[16px] md:text-[18px] lg:text-[20px] mb-12 md:mb-[30px] lg:mb-[50px] flex flex-col justify-center items-center md:items-start w-full px-[20px] md:pr-[40px] md:pl-[0]">
                <h1 className="text-text-primary font-light">Restaurant of the Year</h1>
                <h4 className="text-white text-center md:text-left font-light">
                  Bastian (Worli) &ndash; Elite Magazine’s India's Top 50 Restaurants Awards 2023
                </h4>
              </div>
            </div>
            <div className="w-full md:w-[40%] flex flex-col  items-start gap-0 gap:md-[10]">
              <div className="text-[16px] md:text-[18px] lg:text-[20px] mb-12 md:mb-[30px] lg:mb-[50px] flex flex-col justify-center items-center md:items-start w-full px-[20px] md:pr-[40px] md:pl-[0]">
                <h1 className="text-text-primary font-light">
                  Most Unique Interiors & Ambience
                </h1>
                <h4 className="text-white text-center md:text-left font-light">
                  Bastian (Worli) &ndash; Elite Magazine’s Top 50 Indian Owned
                  Restaurants Awards 2023
                </h4>
              </div>
              <div className="text-[16px] md:text-[18px] lg:text-[20px] mb-12 md:mb-[30px] lg:mb-[50px] flex flex-col justify-center items-center md:items-start w-full px-[20px] md:pr-[40px] md:pl-[0]">
                <h1 className="text-text-primary font-light">Times Food & Nightlife</h1>
                <h4 className="text-white text-center md:text-left font-light">
                  Bastian (Worli) &ndash; Best Modern Asian &ndash; Premium Dining Category
                </h4>
              </div>
            </div>
            <div className="w-full md:w-[20%] flex justify-center items-center mb-[40px] md:mb-[0]">
              <h1 className="text-white text-[36px] md:text-[64px]">2023</h1>
            </div>
          </div>
        </div>
      </div>

      <div className="w-full h-auto md:h-[623px] bg-cover bg-center flex flex-col md:flex-row justify-center items-center">
        <div className="  h-[388px] md:h-[623px] w-full md:w-1/2 relative overflow-hidden">
          <img
            src={img3}
            className="w-full h-[388px] md:h-[623px] object-cover"
          />
          <div className="bg-black/80 backdrop-blur-[2px] absolute inset-0 w-full h-[388px] md:h-[623px] flex justify-center items-center">
            <div className="flex flex-col justify-center items-center md:items-start gap-0 gap:md-[10]" data-aos="fade-up">
              <h1 className="text-white text-[36px] md:text-[64px] mb-[40px] md:mb-[0]">2022</h1>
              <div className="text-[16px] md:text-[18px] lg:text-[20px] mb-12 md:mb-[30px] lg:mb-[50px] flex flex-col justify-center items-center md:items-start w-full px-[20px] md:pr-[40px] md:pl-[0]">
                <h1 className="text-text-primary font-light">Best Innovative Menu</h1>
                <h4 className="text-white font-light">Travel & Leisure Dining Awards</h4>
              </div>
              <div className="text-[16px] md:text-[18px] lg:text-[20px] mb-12 md:mb-[30px] lg:mb-[50px] flex flex-col justify-center items-center md:items-start w-full px-[20px] md:pr-[40px] md:pl-[0]">
                <h1 className="text-text-primary font-light">
                  Best International Cuisine
                </h1>
                <h4 className="text-white font-light">ET Hospitality World</h4>
              </div>
            </div>
          </div>
        </div>
        <div className="  h-[388px] md:h-[623px] w-full md:w-1/2 relative overflow-hidden">
          <img
            src={img4}
            className="w-full h-[388px] md:h-[623px] object-cover"
          />
          <div className="bg-black/80 backdrop-blur-[2px] absolute inset-0 w-full h-[388px] md:h-[623px] flex justify-center items-center">
            <div className="flex flex-col justify-center items-center md:items-start gap-0 gap:md-[10]" data-aos="fade-up">
              <h1 className="text-white text-[36px] md:text-[64px] mb-[40px] md:mb-[0]">2021</h1>
              <div className="text-[16px] md:text-[18px] lg:text-[20px] mb-12 md:mb-[30px] lg:mb-[50px] flex flex-col justify-center items-center md:items-start w-full px-[20px] md:pr-[40px] md:pl-[0]">
                <h1 className="text-text-primary font-light">Best Bars India</h1>
                <h4 className="text-white font-light">30 Best Bars India 2021</h4>
              </div>
              <div className="text-[16px] md:text-[18px] lg:text-[20px] mb-12 md:mb-[30px] lg:mb-[50px] flex flex-col justify-center items-center md:items-start w-full px-[20px] md:pr-[40px] md:pl-[0]">
                <h1 className="text-text-primary font-light">Restaurant of the Year</h1>
                <h4 className="text-white font-light">Times Food Nightlife Awards</h4>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div
        style={{ backgroundImage: `url(${img5})` }}
        className="w-full h-[207.48px] md:h-[418px] bg-cover bg-center relative bg-fixed overflow-hidden"
      >
        <div className="bg-black/80 backdrop-blur-[2px] absolute inset-0 w-full h-[207.48px] md:h-[418px] flex justify-center items-center">
          <div className="flex flex-col justify-center items-center gap-6" data-aos="fade-up">
            <h1 className="text-white text-[36px] md:text-[64px] text-center">
              2019
            </h1>
            <div className="text-[16px] md:text-[18px] lg:text-[20px] flex flex-col justify-center items-center   w-full">
              <h1 className="text-text-primary font-light text-center">Top Restaurant</h1>
              <h4 className="text-white text-center md:text-left font-light">
                Conde Nast Traveller Top Restaurant Awards
              </h4>
            </div>
          </div>
        </div>
      </div>

      <div className="w-full h-auto md:h-[623px] bg-cover bg-center flex flex-col md:flex-row justify-center items-center overflow-hidden">
        <div className="  h-[388px] md:h-[623px] w-full md:w-1/2 relative">
          <img
            src={img6}
            className="w-full h-[388px] md:h-[623px] object-cover"
          />
          <div className="bg-black/80 backdrop-blur-[2px] absolute inset-0 w-full h-[388px] md:h-[623px] flex justify-center items-center">
            <div className="flex flex-col justify-center items-center md:items-start gap-0 gap:md-[10] max-w-[300px]" data-aos="fade-up">
              <h1 className="text-white text-[36px] md:text-[64px] mb-[40px] md:mb-[0]">2018</h1>
              <div className="text-[16px] md:text-[18px] lg:text-[20px] mb-12 md:mb-[30px] lg:mb-[50px] flex flex-col justify-center items-center md:items-start w-full px-[20px] md:pr-[40px] md:pl-[0]">
                <h1 className="text-text-primary font-light">The Guide Restaurant</h1>
                <h4 className="text-white font-light">Best New Celebrity Den</h4>
              </div>
              <div className="text-[16px] md:text-[18px] lg:text-[20px] mb-12 md:mb-[30px] lg:mb-[50px] flex flex-col justify-center items-center md:items-start  w-full px-[20px] md:pr-[40px] md:pl-[0] ">
                <h1 className="text-text-primary font-light">Top Restaurant</h1>
                <h4 className="text-white text-center md:text-left font-light">
                  Conde Nast Traveller Top Restaurant Awards
                </h4>
              </div>
            </div>
          </div>
        </div>
        <div className="  h-[388px] md:h-[623px] w-full md:w-1/2 relative">
          <img
            src={img7}
            className="w-full h-[388px] md:h-[623px] object-cover"
          />
          <div className="bg-black/80 backdrop-blur-[2px] absolute inset-0 w-full h-[388px] md:h-[623px]  flex justify-center items-center">
            <div className="flex flex-col justify-center items-center md:items-start gap-0 gap:md-[10] max-w-[300px]" data-aos="fade-up">
              <h1 className="text-white text-[36px] md:text-[64px] mb-[40px] md:mb-[0]">2017</h1>
              <div className="text-[16px] md:text-[18px] lg:text-[20px] mb-12 md:mb-[30px] lg:mb-[50px] flex flex-col justify-center items-center md:items-start w-full px-[20px] md:pr-[40px] md:pl-[0]">
                <h1 className="text-text-primary font-light">INCA Awards</h1>
                <h4 className="text-white font-light">Best F&B Director</h4>
              </div>
              <div className="text-[16px] md:text-[18px] lg:text-[20px] mb-12 md:mb-[30px] lg:mb-[50px] flex flex-col justify-center items-center md:items-start w-full px-[20px] md:pr-[40px] md:pl-[0]">
                <h1 className="text-text-primary font-light">Top Restaurant</h1>
                <h4 className="text-white text-center md:text-left font-light">
                  Conde Nast Traveller Top Restaurant Awards
                </h4>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div
        style={{ backgroundImage: `url(${img8})` }}
        className="w-full h-[207.48px] md:h-[418px] bg-cover bg-center relative bg-fixed overflow-hidden"
      >
        <div className="bg-black/80 backdrop-blur-[2px] absolute inset-0 w-full h-[207.48px] md:h-[418px] flex justify-center items-center">
          <div className="flex flex-col justify-center items-center gap-6"  data-aos="fade-up">
            <div className="text-[16px] md:text-[18px] lg:text-[20px] flex flex-col justify-center items-center   w-full">
              <h1 className="text-text-primary font-light text-center">
                Peaklife Gourmet Awards
              </h1>
              <h4 className="text-white font-light">
                Favourite Cocktail Bar (Standalone)
              </h4>
            </div>
          </div>
        </div>
      </div>

      <div>
        <AwardSlider shoHeading={false}/>
      </div>
    </div>
  );
}
