import bg from "../assets/Images/HeroImgDs4.png";
import mobBg from "../assets/Images/curation-mob-banner.png";
import HeroSection from "../components/HeroSection";
// import ImgCard from "../components/ImgCard";
import img1 from "../assets/grid-img2/img1.png";
import img2 from "../assets/grid-img2/img2.png";
import img3 from "../assets/grid-img2/img3.png";
import img4 from "../assets/grid-img2/img4.png";
import img5 from "../assets/grid-img2/img5.png";
import img6 from "../assets/grid-img2/img6.png";
import img7 from "../assets/grid-img2/img7.png";
import img17 from "../assets/grid-img2/img17.png";
import img16 from "../assets/grid-img2/img16.png";
import img8 from "../assets/grid-img2/img8.png";
import img9 from "../assets/grid-img2/img9.png";
import img10 from "../assets/grid-img2/img10.png";
import img11 from "../assets/grid-img2/img11.png";
import img18 from "../assets/grid-img2/img18.png";
import img19 from "../assets/grid-img2/img19.png";
import img20 from "../assets/grid-img2/img20.png";
import img12 from "../assets/grid-img2/img12.png";
import img13 from "../assets/grid-img2/img13.png";
import img14 from "../assets/grid-img2/img14.png";
import img15 from "../assets/grid-img2/img15.png";
import bgGredientImage from "../assets/Images/homeBannerGradient.png";
import RevealAnimation from "../components/RevealAnimation";
import { Helmet } from 'react-helmet';
export default function CurationPage() {
  const HeroImgText = {
    heading1: "Curated Indulgence",
    heading2:
      "Explore a collection that embodies the spirit of Bastian’s fine dining. From artfully plated creations to our beautifully crafted interiors, each frame invites you to experience a world of pure luxury.",
    changeStyle: true,
  };

  return (
    <div className="w-full h-auto min-h-screen page-height">
      <Helmet>
<title>Bastian Curation - Art of Dining</title>
<meta 
name="description" 
content="Explore the curated experiences that define Bastian's unique approach to hospitality." 
/>
</Helmet>
      <div>
        <HeroSection
          bg={bg}
          bg2={mobBg}
          HeroImgText={HeroImgText}
          bgGredientImage={bgGredientImage}
        />
      </div>

      {/* <ImgCard />  */}
      <div className="imageGalleries px-4 md:px-8 py-0">
        <div className="gallery-row-first">
          <div className="imageWrap">
            <RevealAnimation>
              <div className="front"></div>
              <img src={img1} />
            </RevealAnimation>
          </div>
          <div className="imageWrap">
            <RevealAnimation>
              <div className="front"></div>
              <img src={img2} />
            </RevealAnimation>
          </div>
          <div className="imageWrap">
            <RevealAnimation>
              <div className="front"></div>
              <img src={img3} />
            </RevealAnimation>
          </div>
        </div>
        <div className="gallery-row-second">
          <div className="col-left">
            <div className="imageWrap">
              <RevealAnimation>
                <div className="front"></div>
                <img src={img4} />
              </RevealAnimation>
            </div>
            <div className="imageWrap img-5">
              <RevealAnimation>
                <div className="front"></div>
                <img src={img5} />
              </RevealAnimation>
            </div>
          </div>
          <div className="col-right">
            <div className="imageWrap">
              <RevealAnimation>
                <div className="front"></div>
                <img src={img6} />
              </RevealAnimation>
            </div>
          </div>
        </div>
        <div className="gallery-row-second reverse">
          <div className="col-left">
            <div className="imageWrap">
              <RevealAnimation>
                <div className="front"></div>
                <img src={img16} />
              </RevealAnimation>
            </div>
            <div className="imageWrap img-5 img-8">
              <RevealAnimation>
                <div className="front"></div>
                <img src={img8} />
              </RevealAnimation>
            </div>
          </div>
          <div className="col-right">
            <div className="imageWrap">
              <RevealAnimation>
                <div className="front"></div>
                <img src={img7} />
              </RevealAnimation>
            </div>
            <div className="imageWrap">
              <RevealAnimation>
                <div className="front"></div>
                <img src={img17} />
              </RevealAnimation>
            </div>
          </div>
        </div>
        <div className="gallery-row-second big">
          <div className="col-left">
            <div className="imageWrap">
              <RevealAnimation>
                <div className="front"></div>
                <img src={img18} />
              </RevealAnimation>
            </div>
            <div className="imageWrap img-5 img-8">
              <RevealAnimation>
                <div className="front"></div>
                <img src={img9} />
              </RevealAnimation>
            </div>
          </div>
          <div className="col-right">
            <div className="imageWrap">
              <RevealAnimation>
                <div className="front"></div>
                <img src={img20} />
              </RevealAnimation>
            </div>
            <div className="imageWrap">
              <RevealAnimation>
                <div className="front"></div>
                <img src={img19} />
              </RevealAnimation>
            </div>
            <div className="inner-two-col">
              <div className="imageWrap">
                <RevealAnimation>
                  <div className="front"></div>
                  <img src={img10} />
                </RevealAnimation>
              </div>
              <div className="imageWrap">
                <RevealAnimation>
                  <div className="front"></div>
                  <img src={img11} />
                </RevealAnimation>
              </div>
            </div>
          </div>
        </div>
        <div className="gallery-row-second reverse hide-mob">
          <div className="col-left">
            <div className="imageWrap">
              <RevealAnimation>
                <div className="front"></div>
                <img src={img13} />
              </RevealAnimation>
            </div>
            <div className="imageWrap img-5 img-8">
              <RevealAnimation>
                <div className="front"></div>
                <img src={img15} />
              </RevealAnimation>
            </div>
          </div>
          <div className="col-right">
            <div className="imageWrap">
              <RevealAnimation>
                <div className="front"></div>
                <img src={img12} />
              </RevealAnimation>
            </div>
            <div className="imageWrap">
              <RevealAnimation>
                <div className="front"></div>
                <img src={img14} />
              </RevealAnimation>
            </div>
          </div>
        </div>
        {/* <Link to="/visionaries" className="text-white text-sm flex items-center gap-1 mt-8 mb-10 show-mob load-more">Load more <FaArrowRight className="text-[10px]" /> </Link> */}
      </div>
    </div>
  );
}
