import React, { useEffect } from "react";
import { IoIosArrowDown } from "react-icons/io";
import PhotoSwipeLightbox from "photoswipe/lightbox";
import "photoswipe/style.css";
import img1 from "../assets/grid-img2/img1.png";
import img2 from "../assets/grid-img2/img2.png";
import img3 from "../assets/grid-img2/img3.png";
import img4 from "../assets/grid-img2/img4.png";
import img5 from "../assets/grid-img2/img5.png";
import img6 from "../assets/grid-img2/img6.png";
import img7 from "../assets/grid-img2/img7.png";
import img8 from "../assets/grid-img2/img8.png";
import img9 from "../assets/grid-img2/img9.png";
import img10 from "../assets/grid-img2/img10.png";
import img11 from "../assets/grid-img2/img11.png";
import img12 from "../assets/grid-img2/img12.png";
import img13 from "../assets/grid-img2/img13.png";
import img14 from "../assets/grid-img2/img14.png";
import img15 from "../assets/grid-img2/img15.png";
import img16 from "../assets/grid-img2/img16.png";
import img17 from "../assets/grid-img2/img17.png";
import img18 from "../assets/grid-img2/img18.png";
import img19 from "../assets/grid-img2/img19.png";
import img20 from "../assets/grid-img2/img20.png";

const ImgCard = () => {
  useEffect(() => {
    const lightbox = new PhotoSwipeLightbox({
      gallery: '#my-gallery',
      children: 'a',
      pswpModule: () => import('photoswipe'),
    });
    lightbox.init();

    return () => {
      lightbox.destroy();
    };
  }, []);

  return (
    <div className="img-card-wrapper">
      <div className="w-full h-auto px-4 md:px-8 py-0">
        <div className="gallery-img-wrapper" id="my-gallery">
          <div className="row">
            <div className="left-img">
              <a href={img1} target="_blank" rel="noreferrer">
                <img src={img1} alt="gallery-img-1" />
              </a>
            </div>
            <div className="right-img">
              <a href={img2} target="_blank" rel="noreferrer">
                <img src={img2} alt="gallery-img-2" />
              </a>
              <a href={img3} target="_blank" rel="noreferrer">
                <img src={img3} alt="gallery-img-3" />
              </a>
            </div>
          </div>
          <div className="row row-reverse">
            <div className="left-img">
              <a href={img4} target="_blank" rel="noreferrer">
                <img src={img4} alt="gallery-img-4" />
              </a>
            </div>
            <div className="right-img">
              <a href={img5} target="_blank" rel="noreferrer">
                <img src={img5} alt="gallery-img-5" />
              </a>
              <a href={img6} target="_blank" rel="noreferrer">
                <img src={img6} alt="gallery-img-6" />
              </a>
            </div>
          </div>
          <div className="row">
            <div className="left-img">
              <a href={img7} target="_blank" rel="noreferrer">
                <img src={img7} alt="gallery-img-7" />
              </a>
            </div>
            <div className="right-img">
              <a href={img8} target="_blank" rel="noreferrer">
                <img src={img8} alt="gallery-img-8" />
              </a>
              <a href={img9} target="_blank" rel="noreferrer">
                <img src={img9} alt="gallery-img-9" />
              </a>
            </div>
          </div>
          <div className="row row-reverse">
            <div className="left-img">
              <a href={img10} target="_blank" rel="noreferrer">
                <img src={img10} alt="gallery-img-10" />
              </a>
            </div>
            <div className="right-img">
              <a href={img11} target="_blank" rel="noreferrer">
                <img src={img11} alt="gallery-img-11" />
              </a>
              <a href={img12} target="_blank" rel="noreferrer">
                <img src={img12} alt="gallery-img-12" />
              </a>
            </div>
          </div>
          <div className="row">
            <div className="left-img">
              <a href={img13} target="_blank" rel="noreferrer">
                <img src={img13} alt="gallery-img-13" />
              </a>
            </div>
            <div className="right-img">
              <a href={img14} target="_blank" rel="noreferrer">
                <img src={img14} alt="gallery-img-14" />
              </a>
              <a href={img15} target="_blank" rel="noreferrer">
                <img src={img15} alt="gallery-img-15" />
              </a>
            </div>
          </div>
          <div className="row row-reverse">
            <div className="left-img">
              <a href={img16} target="_blank" rel="noreferrer">
                <img src={img16} alt="gallery-img-16" />
              </a>
            </div>
            <div className="right-img">
              <a href={img17} target="_blank" rel="noreferrer">
                <img src={img17} alt="gallery-img-17" />
              </a>
              <a href={img18} target="_blank" rel="noreferrer">
                <img src={img18} alt="gallery-img-18" />
              </a>
            </div>
          </div>
          <div className="row">
            <div className="left-img">
              <a href={img19} target="_blank" rel="noreferrer">
                <img src={img19} alt="gallery-img-19" />
              </a>
            </div>
            <div className="right-img">
              <a href={img20} target="_blank" rel="noreferrer">
                <img src={img20} alt="gallery-img-20" />
              </a>
            </div>
          </div>
        </div>
      </div>
      <div className="w-full flex justify-center items-center mb-10 mt-10">
        <h1 className="flex justify-center items-center gap-1 text-[12px] text-text-primary md:text-[21px] cursor-pointer">
          Load more <IoIosArrowDown />
        </h1>
      </div>
    </div>
  );
};

export default ImgCard;