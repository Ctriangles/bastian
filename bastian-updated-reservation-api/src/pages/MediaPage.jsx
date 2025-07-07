import { useState } from "react";
import bg from "../assets/Images/award-desktop-banner.png";
import bg2 from "../assets/Images/award-mob-banner.png";
import HeroSection from "../components/HeroSection";
import img1 from "../assets/Images/mediaCard1.png";
import img2 from "../assets/Images/mediaCard2.png";
import img3 from "../assets/Images/mediaCard3.png";
import img4 from "../assets/Images/mediaCard4.png";
import img5 from "../assets/Images/mediaCard5.png";
import img6 from "../assets/Images/mediaCard6.png";
import img7 from "../assets/Images/mediaCard7.png";
import img8 from "../assets/Images/mediaCard8.png";
import Card1 from "../components/Card1";
import bgGredientImage from "../assets/Images/homeBannerGradient.png";
import { IoIosArrowDown } from "react-icons/io";
import { Helmet } from 'react-helmet';

export default function MediaPage() {
  const HeroImgText = {
    heading1: "Media Coverage",
    changeStyle: true,
  };

  const cardData = [
    { img: img1, date: "Nov 30, 2023", heading: "Bastian - At The Top Is A Swish New Dining Address In Mumbai", long: true, link: "https://www.travelandleisureasia.com/in/dining/review-of-bastian-at-the-top-new-restaurant-in-mumbai/amp/" },
    { img: img2, date: "Nov 27, 2023", heading: "Here’s everything you need to know about Shilpa Shetty’s new rooftop restaurant", long: false, link: "https://www.harpersbazaar.in/travel-food/story/heres-everything-you-need-to-know-about-shilpa-shettys-new-roof-top-restaurant-714961-2023-11-25" },
    { img: img3, date: "Nov 15, 2023", heading: "Bastian at the Top whisks guests away to a rustic cave in arid desert lands", long: false, link: "https://www.vogue.in/content/bastian-at-the-top-whisks-guests-away-to-a-rustic-cave-in-arid-desert-lands" },
    { img: img4, date: "Dec 27, 2022", heading: "New in town: Comfort food at Bizza by Bastian in Mumbai ", long: true, link: "https://luxebook.in/new-in-town-comfort-food-at-bizza-by-bastian-in-mumbai/" },
    { img: img5, date: "Dec 23, 2022", heading: "New In Mumbai: A Live Jazz Restaurant, A Hip Pizza Outpost And More", long: true, link: "https://www.designpataki.com/new-in-mumbai-a-pizza-outpost-by-bastian-and-more/" },
    { img: img6, date: "Nov 28, 2022", heading: "Bizza is Mumbai’s newest pizza spot by the folks behind Bastian", long: false, link: "https://www.cntraveller.in/story/bizza-is-mumbais-newest-pizza-spot-by-the-folks-behind-bastian/" },
    { img: img7, date: "Dec 16, 2020", heading: "Inside Shilpa Shetty Kundra-Raj Kundra’s high-end restaurant, Bastian, with all-new luxurious interiors", long: false, link: "https://www.hindustantimes.com/more-lifestyle/inside-shilpa-shetty-kundra-raj-kundra-s-high-end-restaurant-bastian-with-all-new-luxurious-interiors/story-2vLL4XKIb302jVRHU8g9LL.html" },
    { img: img8, date: "Dec 04, 2020", heading: "The Stunning Interiors Of Shilpa Shetty's New Mumbai Restaurant. Coming Soon", long: true, link: "https://www.ndtv.com/entertainment/the-stunning-interiors-of-shilpa-shettys-new-mumbai-restaurant-coming-soon-2334087" },
  ];

  const sortedCardData = cardData.sort((a, b) => new Date(b.date) - new Date(a.date));

  const [visibleCards, setVisibleCards] = useState(4);

  const handleLoadMore = () => {
    setVisibleCards((prevVisibleCards) => prevVisibleCards + 4);
  };

  return (
    <div className="w-full h-auto min-h-screen page-height pb-20">
      <Helmet>
<title>Bastian in Media - Press Highlights</title>
<meta 
name="description" 
content="Read about Bastian Hospitality's features and stories in leading media outlets." 
/>
</Helmet>
      <div className="award-banner media-page">
        <HeroSection bg={bg} bg2={bg2} HeroImgText={HeroImgText} bgGredientImage={bgGredientImage} />
      </div>

      <div className="w-full h-auto flex justify-center items-center">
        <div className="w-full max-w-[1139px] mx-auto gap-10 px-[34px] md:gap-16 mt-8 media-grid-column">
          {sortedCardData.slice(0, visibleCards).map((data, index) => (
            <div key={index} className="transition-all duration-500 ease-in-out transform">
              <Card1 data={data} />
            </div>
          ))}
        </div>
      </div>

      {visibleCards < sortedCardData.length && (
        <div className="w-full flex justify-center items-center my-9 mb-0">
          <h1 onClick={handleLoadMore} className="flex justify-center items-center gap-1 text-[12px] text-text-primary md:text-[21px] cursor-pointer load-more-btn">
            Load more <IoIosArrowDown />
          </h1>
        </div>
      )}
    </div>
  );
}
