import React, { useEffect } from "react";
import img1 from "../assets/grid-img/img1.png";
import img2 from "../assets/grid-img/img2.png";
import img3 from "../assets/grid-img/img3.png";
import img4 from "../assets/grid-img/img4.png";
import img6 from "../assets/grid-img/img6.png";
import img7 from "../assets/grid-img/img7.png";
import img8 from "../assets/grid-img/img8.png";
import img9 from "../assets/grid-img/img9.png";
import img10 from "../assets/grid-img/img10.png";
import img11 from "../assets/grid-img/img11.png";
import img12 from "../assets/grid-img/img12.png";
import img13 from "../assets/grid-img/img13.png";
import img14 from "../assets/grid-img/img14.png";
import img151 from "../assets/grid-img/imagecup-with-stick.png";
import imgMOb1 from "../assets/grid-img/imgMOb1.png";
import imgMOb2 from "../assets/grid-img/imgMOb2.png";
import imgMOb3 from "../assets/grid-img/imgMOb3.png";
import imgMOb4 from "../assets/grid-img/imgMOb4.png";
import imgMOb5 from "../assets/grid-img/imgMOb5.png";
import imgMOb6 from "../assets/grid-img/imgMOb6.png";
import imgMOb7 from "../assets/grid-img/imgMOb7.png";
import imgMOb8 from "../assets/grid-img/imgMOb8.png";
import imgMOb9 from "../assets/grid-img/imgMOb9.png";
import imgMOb10 from "../assets/grid-img/imgMOb10.png";
import imgMOb11 from "../assets/grid-img/imgMOb11.png";
import imgMOb12 from "../assets/grid-img/imgMOb12.png";
import imgMOb13 from "../assets/grid-img/imgMOb13.png";
import imgMOb14 from "../assets/grid-img/imgMOb14.png";
import { FaArrowRight } from "react-icons/fa";
import SectionHeading from "./SectionHeading";
import { Link } from "react-router-dom";
import RevealAnimation from "./RevealAnimation";
/* import gsap from "gsap";
import { ScrollTrigger } from "gsap/ScrollTrigger"; */

export default function ImageGrid() {
  /* useEffect(() => {
    gsap.registerPlugin(ScrollTrigger);
    let revealimgBoxsToRight = document.querySelectorAll(".reveal");
    revealimgBoxsToRight.forEach((imgBox) => {
      let fronDiv = imgBox.querySelector(".front");
      let tl = gsap.timeline({
        repeatDelay: 2,
        scrollTrigger: {
          trigger: imgBox,
          toggleActions: "restart none none reset",
        },
      });

      tl.to(fronDiv, {
        xPercent: 100,
        ease: "Power2.out",
        duration: 1,
      });
    });
  }, []); */

  const headingText = {
    heading: "Curation",
    text: "Explore the Elegance & Craftsmanship Behind Bastian Hospitality's Culinary & Spatial Creations",
  };

  return (
    <div className="w-full md:mt-[100px] home-gallery">
      <SectionHeading headingText={headingText} />
      <div className="desktopGallery w-full justify-center items-center py-8">
        <div className="image-gallery-wrp">
          <div className="col-left">
            <div className="imageWrap">
              <div className="imgBox">
                <RevealAnimation>
                  <div className="front"></div>
                  <img src={img1} alt="Cheers with food & wine" />
                </RevealAnimation>
              </div>
            </div>
            <div className="imageWrap">
              <div className="imgBox">
                <RevealAnimation>
                  <div className="front"></div>
                  <img src={img3} alt="Woman eating breakfast" />
                </RevealAnimation>
              </div>
            </div>
            <div className="imageWrap">
              <div className="imgBox">
                <RevealAnimation>
                  <div className="front"></div>
                  <img src={img6} alt="Plated food variety" />
                </RevealAnimation>
              </div>
            </div>
            <div className="imageWrap">
              <div className="imgBox">
                <RevealAnimation>
                  <div className="front"></div>
                  <img src={img8} alt="Floral drink on table" />
                </RevealAnimation>
              </div>
            </div>
            <div className="imageWrap">
              <div className="imgBox">
                <RevealAnimation>
                  <div className="front"></div>
                  <img src={img10} alt="Beautiful dessert plate" />
                </RevealAnimation>
              </div>
            </div>
          </div>
          <div className="col-right">
            <div className="imageWrap">
              <div className="imgBox">
                <RevealAnimation>
                  <div className="front"></div>
                  <img src={img14} alt="Woman holding burger" />
                </RevealAnimation>
              </div>
            </div>
            <div className="imageWrap">
              <div className="imgBox">
                <RevealAnimation>
                  <div className="front"></div>
                  <img src={img13} alt="Cheesecake slice on plate" />
                </RevealAnimation>
              </div>
            </div>
            <div className="imageWrap">
              <div className="imgBox">
                <RevealAnimation>
                  <div className="front"></div>
                  <img src={img2} alt="Smoky cocktail & garnish" />
                </RevealAnimation>
              </div>
            </div>
            <div className="imageWrap">
              <div className="imgBox">
                <RevealAnimation>
                  <div className="front"></div>
                  <img src={img4} alt="Person holding spoon to eat chocolate dessert" />
                </RevealAnimation>
              </div>
            </div>
            <div className="imageWrap">
              <div className="imgBox">
                <RevealAnimation>
                  <div className="front"></div>
                  <img src={img7} alt="Colorful food & Juice spread on table" />
                </RevealAnimation>
              </div>
            </div>
            <div className="imageWrap">
              <div className="imgBox">
                <RevealAnimation>
                  <div className="front"></div>
                  <img src={img9} alt="Indian feast on table" />
                </RevealAnimation>
              </div>
            </div>
            <div className="imageWrap">
              <div className="imgBox">
                <RevealAnimation>
                  <div className="front"></div>
                  <img src={img151} alt="A glass bowl filled with yellow liquid & white foam" />
                </RevealAnimation>
              </div>
            </div>
            <div className="imageWrap">
              <div className="imgBox">
                <RevealAnimation>
                  <div className="front"></div>
                  <img src={img11} alt="Rice plate with veggies and other dishes" />
                </RevealAnimation>
              </div>
            </div>
            <div className="imageWrap">
              <div className="imgBox">
                <RevealAnimation>
                  <div className="front"></div>
                  <img src={img12} alt="Lemon squeezed on prawns" />
                </RevealAnimation>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div className="mobileGallery w-full justify-center items-center py-6 md:py-8">
        <div className="mobile-gallery-wrap">
          <div className="col-left">
            <div className="imgWrap">
              <div className="imgBox">
                <RevealAnimation>
                  <div className="front"></div>
                  <img src={imgMOb1} alt="Two hands clink colorful cocktails" />
                </RevealAnimation>
              </div>
            </div>
            <div className="imgWrap">
              <div className="imgBox">
                <RevealAnimation>
                  <div className="front"></div>
                  <img src={imgMOb3} alt="Elegant restaurant interior featuring a large Buddha statue" />
                </RevealAnimation>
              </div>
            </div>
          </div>
          <div className="col-right">
            <div className="imgWrap">
              <div className="imgBox">
                <RevealAnimation>
                  <div className="front"></div>
                  <img src={imgMOb2} alt="A women holding burger" />
                </RevealAnimation>
              </div>
            </div>
            <div className="imgWrap">
              <div className="imgBox">
                <RevealAnimation>
                  <div className="front"></div>
                  <img src={imgMOb4} alt="Smoky cocktail" />
                </RevealAnimation>
              </div>
            </div>
          </div>
        </div>
        <div className="mobile-gallery-wrap reverse">
          <div className="col-left">
            <div className="imgWrap">
              <div className="imgBox">
                <RevealAnimation>
                  <div className="front"></div>
                  <img src={imgMOb5} alt="Whimsical cocktail glass and a decorative butterfly" />
                </RevealAnimation>
              </div>
            </div>
            <div className="imgWrap">
              <div className="imgBox">
                <RevealAnimation>
                  <div className="front"></div>
                  <img src={imgMOb7} alt="Fried chicken meal plate" />
                </RevealAnimation>
              </div>
            </div>
            <div className="imgWrap">
              <div className="imgBox">
                <RevealAnimation>
                  <div className="front"></div>
                  <img src={imgMOb9} alt="Cutting egg on pancake" />
                </RevealAnimation>
              </div>
            </div>
            <div className="imgWrap">
              <div className="imgBox">
                <RevealAnimation>
                  <div className="front"></div>
                  <img src={imgMOb11} alt="Creamy dessert with berries" />
                </RevealAnimation>
              </div>
            </div>
            <div className="imgWrap">
              <div className="imgBox">
                <RevealAnimation>
                  <div className="front"></div>
                  <img src={imgMOb13} alt="Chocolate dessert bowl" />
                </RevealAnimation>
              </div>
            </div>
          </div>
          <div className="col-right">
            <div className="imgWrap">
              <div className="imgBox">
                <RevealAnimation>
                  <div className="front"></div>
                  <img src={imgMOb6} alt="A hand squeezes lime on lobster alongside pasta bowl" />
                </RevealAnimation>
              </div>
            </div>
            <div className="imgWrap">
              <div className="imgBox">
                <RevealAnimation>
                  <div className="front"></div>
                  <img src={imgMOb8} alt="Cozy restaurant interior with warm lighting" />
                </RevealAnimation>
              </div>
            </div>
            <div className="imgWrap">
              <div className="imgBox">
                <RevealAnimation>
                  <div className="front"></div>
                  <img src={imgMOb10} alt="A vibrant spread of tacos topped with fresh ingredients" />
                </RevealAnimation>
              </div>
            </div>
            <div className="imgWrap">
              <div className="imgBox">
                <RevealAnimation>
                  <div className="front"></div>
                  <img src={imgMOb12} alt="A stylish, earthy dining space with patterned walls" />
                </RevealAnimation>
              </div>
            </div>
            <div className="imgWrap">
              <div className="imgBox">
                <RevealAnimation>
                  <div className="front"></div>
                  <img src={imgMOb14} alt="Indian cuisine, featuring savory rolls in a rich sauce" />
                </RevealAnimation>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div className="w-full flex justify-center items-center mb-8">
        <Link
          to="/curation"
          className="text-[#F2CA99] text-sm flex items-center gap-1 mt-4"
        >
          View more <FaArrowRight className="text-[10px]" />{" "}
        </Link>
      </div>
    </div>
  );
}
