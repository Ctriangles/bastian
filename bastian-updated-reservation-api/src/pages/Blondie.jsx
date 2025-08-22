import React, { useState } from "react";
import HeroSection from "../components/HeroSection";
import bg from "../assets/Images/bolandi-banner.png";
import fullbg from "../assets/Images/bolandifullbg.png";
import event2 from "../assets/Images/inka-event2.png";
import event1 from "../assets/Images/inka-event1.png";
import event3 from "../assets/Images/inka-event3.png";
import pdf1 from "../assets/Images/bloandi-bar.pdf";
import pdf2 from "../assets/Images/bloandi-food.pdf";
import pdf3 from "../assets/Images/bloandi-beverages.pdf";
import inkaGallery1 from "../assets/Images/bolandi-gallery-img01.png";
import inkaGallery2 from "../assets/Images/bolandi-gallery-img02.png";
import inkaGallery3 from "../assets/Images/bolandi-gallery-img03.png";
import inkaGallery4 from "../assets/Images/bolandi-gallery-img04.jpg";
import inkaGallery5 from "../assets/Images/blondie-drink-img01.jpg";
import inkaGallery6 from "../assets/Images/blondie-drink-img02.jpg";
import inkaGallery7 from "../assets/Images/blondie-drink-img03.jpg";
import inkaGallery8 from "../assets/Images/blondie-drink-img04.jpg";
import inkaGallery9 from "../assets/Images/blondie-drink-img05.jpg";
import inkaGallery10 from "../assets/Images/blondie-drink-img06.jpg";
import inkaEvent1 from "../assets/Images/inka-event1.png";
import inkaEvent2 from "../assets/Images/inka-event2.png";
import inkaEvent3 from "../assets/Images/inka-event3.png";
import discoverevent from "../assets/Images/bolandie-discover01.png";
import discoverevent2 from "../assets/Images/bolandie-discover02.png";
import discoverevent3 from "../assets/Images/bolandie-discover03.png";
import Slider from "react-slick";
import "slick-carousel/slick/slick.css";
import "slick-carousel/slick/slick-theme.css";
import bgGredientImage from "../assets/Images/homeBannerGradient.png";
import Reservation from "../components/Reservation";
import { Helmet } from "react-helmet";

export default function Bastianbloandi() {
  const HeroImgText = {
    heading1: "Blondie",
    heading2: `Our newest venture celebrates specialty coffee, ceremonial-grade matcha, and a deep commitment to heritage, sustainability, and innovation.  `,
    changeStyle: true,
  };

  const galleryData = {
    all: [
      inkaGallery1,
      inkaGallery2,
      inkaGallery3,
      inkaGallery4,
      inkaGallery5,
      inkaGallery6,
      inkaGallery9,
    ],
    ambiance: [inkaGallery1, inkaGallery2, inkaGallery3, inkaGallery4],
    food: [inkaGallery5, inkaGallery6, inkaGallery7, inkaGallery8, inkaGallery9, inkaGallery10],
    events: [inkaEvent1, inkaEvent2, inkaEvent3],
  };

  const tabs = [
    { key: "all", label: "All" },
    { key: "ambiance", label: "Ambiance" },
    { key: "food", label: "Food & Beverages" },
    { key: "events", label: "Events" },
  ];
  const events = [
    {
      title: "Wine Tasting",
      date: "16 July 2025",
      time: "7:00 PM - 11:00 PM",
      location: "Lower Parel, Mumbai",
      image: event1,
      alt: "Event 1",
      locationType: "venue",
      description:
        "Experience an authentic Peruvian evening with live music, cultural performances, and traditional delicacies.",
      contact: "+91 98765 11111",
    },
    {
      title: "Supper Club",
      date: "16 July 2025",
      time: "8:00 PM - Late",
      location: "Lower Parel, Mumbai",
      image: event2,
      alt: "Event 2",
      locationType: "venue",
      description:
        "Dance the night away under the stars with salsa beats, cocktails, and vibrant Latin vibes.",
      contact: "+91 98765 22222",
    },
    {
      title: "Coffee Making",
      date: "16 July 2025",
      time: "6:30 PM - 10:00 PM",
      location: "Lower Parel, Mumbai",
      image: event3,
      alt: "Event 3",
      locationType: "venue",
      description:
        "An exclusive dining experience curated by our master chef, featuring a bespoke tasting menu.",
      contact: "+91 98765 33333",
    },
  ];
  // SVGs as components for reuse
  const CalendarIcon = (
    <svg
      width="16"
      height="16"
      viewBox="0 0 16 16"
      fill="none"
      xmlns="http://www.w3.org/2000/svg"
    >
      <g clip-path="url(#clip0_2031_370)">
        <path
          d="M5.725 8.9329C5.725 9.03235 5.68549 9.12774 5.61517 9.19806C5.54484 9.26839 5.44946 9.3079 5.35 9.3079H3.2875C3.18804 9.3079 3.09266 9.26839 3.02234 9.19806C2.95201 9.12774 2.9125 9.03235 2.9125 8.9329C2.9125 8.83344 2.95201 8.73806 3.02234 8.66773C3.09266 8.59741 3.18804 8.5579 3.2875 8.5579H5.35C5.44946 8.5579 5.54484 8.59741 5.61517 8.66773C5.68549 8.73806 5.725 8.83344 5.725 8.9329ZM9.03125 8.5579H6.96875C6.86929 8.5579 6.77391 8.59741 6.70359 8.66773C6.63326 8.73806 6.59375 8.83344 6.59375 8.9329C6.59375 9.03235 6.63326 9.12774 6.70359 9.19806C6.77391 9.26839 6.86929 9.3079 6.96875 9.3079H9.03125C9.13071 9.3079 9.22609 9.26839 9.29642 9.19806C9.36674 9.12774 9.40625 9.03235 9.40625 8.9329C9.40625 8.83344 9.36674 8.73806 9.29642 8.66773C9.22609 8.59741 9.13071 8.5579 9.03125 8.5579ZM12.7125 8.5579H10.65C10.5505 8.5579 10.4552 8.59741 10.3848 8.66773C10.3145 8.73806 10.275 8.83344 10.275 8.9329C10.275 9.03235 10.3145 9.12774 10.3848 9.19806C10.4552 9.26839 10.5505 9.3079 10.65 9.3079H12.7125C12.812 9.3079 12.9073 9.26839 12.9777 9.19806C13.048 9.12774 13.0875 9.03235 13.0875 8.9329C13.0875 8.83344 13.048 8.73806 12.9777 8.66773C12.9073 8.59741 12.812 8.5579 12.7125 8.5579ZM5.35 11.7141H3.2875C3.18804 11.7141 3.09266 11.7537 3.02234 11.824C2.95201 11.8943 2.9125 11.9897 2.9125 12.0891C2.9125 12.1886 2.95201 12.284 3.02234 12.3543C3.09266 12.4246 3.18804 12.4641 3.2875 12.4641H5.35C5.44946 12.4641 5.54484 12.4246 5.61517 12.3543C5.68549 12.284 5.725 12.1886 5.725 12.0891C5.725 11.9897 5.68549 11.8943 5.61517 11.824C5.54484 11.7537 5.44946 11.7141 5.35 11.7141ZM9.03125 11.7141H6.96875C6.86929 11.7141 6.77391 11.7537 6.70359 11.824C6.63326 11.8943 6.59375 11.9897 6.59375 12.0891C6.59375 12.1886 6.63326 12.284 6.70359 12.3543C6.77391 12.4246 6.86929 12.4641 6.96875 12.4641H9.03125C9.13071 12.4641 9.22609 12.4246 9.29642 12.3543C9.36674 12.284 9.40625 12.1886 9.40625 12.0891C9.40625 11.9897 9.36674 11.8943 9.29642 11.824C9.22609 11.7537 9.13071 11.7141 9.03125 11.7141ZM12.7125 11.7141H10.65C10.5505 11.7141 10.4552 11.7537 10.3848 11.824C10.3145 11.8943 10.275 11.9897 10.275 12.0891C10.275 12.1886 10.3145 12.284 10.3848 12.3543C10.4552 12.4246 10.5505 12.4641 10.65 12.4641H12.7125C12.812 12.4641 12.9073 12.4246 12.9777 12.3543C13.048 12.284 13.0875 12.1886 13.0875 12.0891C13.0875 11.9897 13.048 11.8943 12.9777 11.824C12.9073 11.7537 12.812 11.7141 12.7125 11.7141ZM16 4.16452V13.46C15.9994 14.0113 15.7801 14.5398 15.3903 14.9296C15.0005 15.3195 14.4719 15.5387 13.9207 15.5394H2.07934C1.52806 15.5387 0.999536 15.3195 0.60972 14.9296C0.219904 14.5398 0.000628592 14.0113 0 13.46L0 4.16452C0.000628592 3.61324 0.219904 3.08472 0.60972 2.6949C0.999536 2.30508 1.52806 2.08581 2.07934 2.08518H2.82028V1.24768C2.82052 1.03884 2.90359 0.838617 3.05126 0.690943C3.19894 0.543269 3.39916 0.460201 3.608 0.459961H4.53263C4.74147 0.460201 4.94169 0.543269 5.08936 0.690943C5.23704 0.838617 5.3201 1.03884 5.32034 1.24768V2.08518H10.6797V1.24768C10.68 1.03884 10.763 0.838617 10.9107 0.690943C11.0584 0.543269 11.2586 0.460201 11.4674 0.459961H12.3921C12.6009 0.460201 12.8011 0.543269 12.9488 0.690943C13.0965 0.838617 13.1795 1.03884 13.1798 1.24768V2.08518H13.9207C14.472 2.08582 15.0005 2.30511 15.3903 2.69492C15.7801 3.08474 15.9994 3.61325 16 4.16452ZM11.4297 3.67259C11.43 3.68247 11.4341 3.69186 11.4411 3.69885C11.4481 3.70585 11.4575 3.70994 11.4674 3.7103H12.392C12.4019 3.70994 12.4113 3.70585 12.4183 3.69885C12.4253 3.69186 12.4294 3.68247 12.4297 3.67259V1.24777C12.4293 1.23789 12.4253 1.22851 12.4183 1.22151C12.4113 1.21452 12.4019 1.21043 12.392 1.21005H11.4674C11.4575 1.21043 11.4481 1.21452 11.4411 1.22151C11.4341 1.22851 11.43 1.23789 11.4297 1.24777V3.67259ZM3.57028 3.67259C3.57065 3.68247 3.57474 3.69186 3.58173 3.69885C3.58873 3.70585 3.59811 3.70994 3.608 3.7103H4.53263C4.54251 3.70994 4.5519 3.70585 4.55889 3.69885C4.56589 3.69186 4.56998 3.68247 4.57034 3.67259V1.24777C4.56997 1.23789 4.56588 1.22851 4.55888 1.22151C4.55189 1.21452 4.54251 1.21043 4.53263 1.21005H3.608C3.59811 1.21043 3.58874 1.21452 3.58174 1.22151C3.57475 1.22851 3.57065 1.23789 3.57028 1.24777V3.67259ZM0.75 4.16452V6.22893H15.25V4.16452C15.2496 3.81208 15.1094 3.47419 14.8602 3.22497C14.611 2.97576 14.2731 2.83558 13.9207 2.83518H13.1797V3.67268C13.1795 3.88152 13.0964 4.08174 12.9487 4.22942C12.8011 4.37709 12.6008 4.46016 12.392 4.4604H11.4674C11.2585 4.46016 11.0583 4.37709 10.9106 4.22942C10.763 4.08174 10.6799 3.88152 10.6797 3.67268V2.83518H5.32028V3.67268C5.32004 3.88152 5.23697 4.08174 5.0893 4.22942C4.94162 4.37709 4.74141 4.46016 4.53256 4.4604H3.608C3.39916 4.46016 3.19894 4.37709 3.05126 4.22942C2.90359 4.08174 2.82052 3.88152 2.82028 3.67268V2.83518H2.07934C1.7269 2.83558 1.38901 2.97576 1.13979 3.22497C0.89058 3.47419 0.750397 3.81208 0.75 4.16452ZM15.25 13.46V6.97893H0.75V13.4602C0.750397 13.8126 0.89058 14.1505 1.13979 14.3997C1.38901 14.6489 1.7269 14.7891 2.07934 14.7895H13.9207C14.2731 14.7891 14.611 14.6489 14.8603 14.3997C15.1095 14.1504 15.2496 13.8125 15.25 13.46Z"
          fill="#E2E2E2"
        />
      </g>
      <defs>
        <clipPath id="clip0_2031_370">
          <rect width="16" height="16" fill="white" />
        </clipPath>
      </defs>
    </svg>
  );
  const LocationIcon = (
    <svg
      width="12"
      height="16"
      viewBox="0 0 12 16"
      fill="none"
      xmlns="http://www.w3.org/2000/svg"
    >
      <path
        d="M6.00005 3.19629C4.72518 3.19629 3.68799 4.23348 3.68799 5.50838C3.68799 6.78329 4.72518 7.82048 6.00005 7.82048C7.27493 7.82048 8.31211 6.78329 8.31211 5.50838C8.31211 4.23348 7.27489 3.19629 6.00005 3.19629ZM6.00005 7.18304C5.07664 7.18304 4.32543 6.43182 4.32543 5.50838C4.32543 4.58495 5.07664 3.83373 6.00005 3.83373C6.92346 3.83373 7.67468 4.58498 7.67468 5.50838C7.67468 6.43179 6.92346 7.18304 6.00005 7.18304Z"
        fill="#E2E2E2"
      />
      <path
        d="M6.00004 0C2.96273 0 0.49173 2.471 0.491699 5.50831C0.491699 7.09956 1.38098 9.33331 3.13473 12.1475C4.42714 14.2213 5.73814 15.8641 5.7512 15.8805C5.81173 15.956 5.90326 16 6.00004 16C6.09679 16 6.18836 15.956 6.24882 15.8805C6.26189 15.8641 7.57292 14.2213 8.86529 12.1475C10.6191 9.33325 11.5083 7.09953 11.5083 5.50831C11.5083 2.471 9.03732 0 6.00004 0ZM6.00004 15.1617C4.97404 13.8206 1.1292 8.58856 1.1292 5.50831C1.1292 2.8225 3.31426 0.637469 6.00004 0.637469C8.68583 0.637469 10.8709 2.8225 10.8709 5.50831C10.8709 8.58856 7.02604 13.8206 6.00004 15.1617Z"
        fill="#E2E2E2"
      />
    </svg>
  );
  const contentData = {
    1: {
      title: "Bar",
      desc: "Elevated pours, crafted for golden moments.",
      pdf: pdf1,
      bg: discoverevent,
    },
    2: {
      title: "Beverages",
      desc: "Refreshing blends, bold and timeless.",
      pdf: pdf3,
      bg: discoverevent2,
    },
    3: {
      title: "Food",
      desc: "Savours perfected with every detail.",
      pdf: pdf2,
      bg: discoverevent3,
    },
  };
  const ClockIcon = (
    <svg
      xmlns="http://www.w3.org/2000/svg"
      className="w-4 h-4"
      fill="none"
      viewBox="0 0 24 24"
      stroke="currentColor"
      strokeWidth={2}
    >
      <path
        strokeLinecap="round"
        strokeLinejoin="round"
        d="M12 6v6l4 2m6-2a10 10 0 11-20 0 10 10 0 0120 0z"
      />
    </svg>
  );
  const PhoneIcon = (
    <svg
      width="20"
      height="20"
      viewBox="0 0 20 20"
      fill="none"
      xmlns="http://www.w3.org/2000/svg"
    >
      <g clip-path="url(#clip0_803_1312)">
        <path
          d="M18.8753 13.7773C18.1214 13.2773 17.3206 12.7656 16.4261 12.2187C15.555 11.6797 14.4105 11.9297 13.848 12.789C13.7464 12.9453 13.6448 13.1015 13.5511 13.2539C13.4964 13.3437 13.4417 13.4297 13.3831 13.5156C13.1917 13.8125 13.0003 14.1132 12.805 14.4179L12.7425 14.5156C12.6839 14.6015 12.5706 14.6289 12.4808 14.5781C9.53157 12.7773 7.22688 10.4687 5.42219 7.51559C5.3675 7.42574 5.39875 7.30856 5.4886 7.24996C5.67219 7.13278 5.85578 7.01949 6.03938 6.90231C6.41438 6.66403 6.805 6.41793 7.18781 6.16793C8.07453 5.58199 8.34016 4.47653 7.8011 3.59762C7.20735 2.62496 6.69953 1.83199 6.20735 1.09762C5.46906 0.00777489 4.055 -0.32035 2.90657 0.3359C2.49641 0.566369 2.09797 0.816369 1.71516 1.09371C0.414378 2.03903 -0.163747 3.37887 0.0432844 4.9609C0.211253 6.22262 0.601878 7.50387 1.24641 8.87496C2.69563 11.9609 4.89875 14.6172 7.79328 16.7695C10.0589 18.4531 12.3636 19.4882 14.8402 19.9336C15.0823 19.9765 15.3284 20 15.5745 20C16.5706 20.0039 17.5316 19.6445 18.2777 18.9882C18.9027 18.4336 19.4027 17.6992 19.8128 16.75C20.2659 15.6875 19.8714 14.4375 18.8753 13.7773ZM19.2191 16.4922C18.848 17.3554 18.3988 18.0117 17.848 18.5039C17.0784 19.1875 15.9964 19.4843 14.9534 19.2968C12.5784 18.8711 10.3636 17.8711 8.18 16.25C5.3675 14.164 3.23469 11.5898 1.83235 8.59762C1.21516 7.28512 0.840159 6.06637 0.683909 4.87106C0.504222 3.5234 0.976878 2.42574 2.09407 1.61324C2.45735 1.35152 2.83625 1.11324 3.22688 0.8984C3.50813 0.734337 3.82844 0.6484 4.15657 0.6484C4.76203 0.6484 5.32844 0.953088 5.66438 1.4609C6.15266 2.18746 6.65266 2.97262 7.2425 3.93746C7.60188 4.5234 7.4261 5.23824 6.82453 5.63278C6.44953 5.87887 6.06282 6.12496 5.68782 6.35934C5.50422 6.47653 5.32063 6.58981 5.13313 6.7109C4.75031 6.95699 4.63313 7.46481 4.87141 7.85543C6.73078 10.8984 9.10578 13.2773 12.1409 15.1289C12.5316 15.3632 13.0355 15.2461 13.2816 14.8632L13.3441 14.7695L13.9222 13.8672C13.9808 13.7773 14.0355 13.6914 14.0902 13.6015C14.1839 13.4492 14.2816 13.2968 14.3831 13.1484C14.7542 12.582 15.512 12.4179 16.0863 12.7734C16.9769 13.3203 17.7698 13.8242 18.5159 14.3203C19.2542 14.8047 19.5511 15.7226 19.2191 16.4922Z"
          fill="white"
        />
      </g>
      <defs>
        <clipPath id="clip0_803_1312">
          <rect width="20" height="20" fill="white" />
        </clipPath>
      </defs>
    </svg>
  );

  const [selectedEvent, setSelectedEvent] = useState(null);
  const [activeCol, setActiveCol] = useState(1);
  const [activeTab, setActiveTab] = useState("all");

  return (
    <div className="w-full h-auto min-h-screen page-height inka-page">
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
      <div className="attop-banner bolandi-banner">
        <HeroSection
          bg={bg}
          bg2={bg}
          HeroImgText={HeroImgText}
          bgGredientImage={bgGredientImage}
        />
      </div>
      {/* Discover section start */}
      <section className="discover-sec">
        <div className="top-text text-center mb-5 md:mb-10">
          <h2 className="text-[28px] md:text-[48px] text-[#f2ca99] mb-2">
            Discover the Menu
          </h2>
          <p className="text-[18px] md:text-[24px] text-white">
            From vibrant small plates to indulgent mains — explore our culinary
            artistry.
          </p>
        </div>
        <div className="img-box-wrapper  max-w-[1340px] mx-auto">
          <div
            className="relative w-full overflow-hidden top-bg-img-box"
            style={{ backgroundImage: `url(${contentData[activeCol].bg})` }}
          >
            <div className="relative z-10 flex flex-row mob-col">
              {[1, 2, 3].map((col) => (
                <div
                  key={col}
                  className={`flex-1 text-center p-3 md:p-8 cursor-pointer transition-all inner-col duration-300 hover:bg-black/40 ${
                    activeCol === col ? "bg-black/50" : "bg-transparent"
                  }`}
                  onMouseEnter={() => setActiveCol(col)}
                  onClick={() => setActiveCol(col)}
                >
                  {activeCol === col && (
                    <>
                      <h3 className="text-2xl md:text-3xl text-[#f2ca99] font-semibold mb-3">
                        {contentData[col].title}
                      </h3>
                      <p className="text-white text-[16px] md:text-[18px] mb-4">
                        {contentData[col].desc}
                      </p>
                      <a
                        href={contentData[col].pdf}
                        target="_blank"
                        rel="noopener noreferrer"
                        className="inline-block px-6 py-2 text-[#f2ca99] transition border border-[#f2ca99] hover:text-[#fff] hover:bg-[#f2ca99] hover:border-[#f2ca99] hover:!bg-[#f2ca99] hover:!text-black"
                      >
                        View Menu
                      </a>
                    </>
                  )}
                </div>
              ))}
            </div>
          </div>
        </div>
      </section>

      {/* event section */}
      <section className="event-sec px-[25px]">
        <div className="w-full flex flex-col my-8 md:my-16">
          <h2 className="text-4xl text-[#f2ca99] mb-10 w-full max-w-[1340px] mx-auto">
            Events
          </h2>
          <div className="grid grid-cols-1 gap-8 w-full max-w-[1340px] mx-auto justify-center md:grid-cols-2 lg:grid-cols-3">
            {events.map((event, idx) => (
              <div
                key={idx}
                className="event-col flex flex-col items-center bg-[#181818] rounded-lg shadow-lg overflow-hidden w-full cursor-pointer"
                onClick={() => setSelectedEvent(event)}
              >
                <img
                  src={event.image}
                  alt={event.alt}
                  className="w-full object-cover"
                />
                <div className="flex flex-row justify-between items-center w-full px-2 md:px-5 py-2 bg-[#222] text-white text-base text-left">
                  <span className="text-[16px] md:text-[20px]">
                    {event.title}
                  </span>
                  <ul className="flex flex-col gap-1 text-sm">
                    <li className="flex items-center gap-2 text-[10px] md:text-[12px]">
                      {CalendarIcon}
                      {event.date}
                    </li>

                    <li className="flex items-center gap-2 text-[10px] md:text-[12px]">
                      {LocationIcon}
                      {event.location}
                    </li>
                  </ul>
                </div>
              </div>
            ))}
          </div>
        </div>
      </section>
      {selectedEvent && (
        <div
          className="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-70 event-pop-up"
          onClick={() => setSelectedEvent(null)}
        >
          <div
            className="bg-[#151515] pop-up-container text-white rounded-lg shadow-lg max-w-[1092px] p-6 md:p-[50px] lg:p-[92px] w-full flex flex-col gap-[30px] md:gap-[48px] md:flex-row overflow-hidden relative max-h-[70vh] md:max-h-auto overflow-y-auto md:overflow-y-unset"
            onClick={(e) => e.stopPropagation()}
          >
            {/* Close button */}
            <button
              className="absolute top-[20px] right-[24px] lg:top-[40px] lg:right-[48px] text-white text-4xl"
              onClick={() => setSelectedEvent(null)}
            >
              &times;
            </button>

            {/* Left side - image */}
            <div className="w-full max-w-[450px] mt-auto md:max-w-[100%] md:w-[336px] mx-auto">
              <img
                src={selectedEvent.image}
                alt={selectedEvent.alt}
                className="w-full h-full object-cover"
              />
            </div>

            {/* Right side - details */}
            <div className="w-full md:w-[516px] flex flex-col">
              <div className="text-wrapper">
                <li className="flex items-center gap-2 mb-[15px] md:mb-[30px] text-[14px]">
                  {selectedEvent.date}
                </li>
                <h3 className="text-[22px] font-normal mb-[12px]">
                  {selectedEvent.title}
                </h3>

                <ul className="flex gap-10 mb-[14px] md:mb-[24px] text-sm">
                  <li className="flex items-center gap-2">
                    {LocationIcon}
                    {selectedEvent.location}
                  </li>
                  <li className="flex items-center gap-2 text-[10px] md:text-[12px]">
                    {ClockIcon}
                    {selectedEvent.time}
                  </li>
                </ul>
                <p className="text-sm leading-relaxed text-[12px] text-[#E2E2E2] !leading-[1.35]">
                  {selectedEvent.description}
                </p>
                {/* Bottom - Contact */}
                <div className="pt-[36px] gap-[40px] gap:mb-[89px] flex">
                  <h4 className="text-[16px] text-[#F2CA99]">Contact Us</h4>
                  <p className="text-sm flex gap-[4px]">
                    {PhoneIcon} {selectedEvent.contact}
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      )}
      {/* gallery section */}
      <section className="gallery-sec">
        <div className="flex flex-col w-full gap-6">
          <div className="inline-flex flex-col gap-4 relative items-center">
            <div className="w-fit font-normal text-[#f2ca99] text-5xl text-center leading-[normal] whitespace-nowrap relative mt-[-1.00px]">
              Gallery
            </div>

            <div className="inline-flex items-center gap-4 md:gap-8 relative ">
              {tabs.map((tab) => (
                <button
                  key={tab.key}
                  onClick={() => setActiveTab(tab.key)}
                  className={`inline-flex items-center justify-center gap-2 pt-0 pb-2 px-0 relative  cursor-pointer transition-all duration-300 ${
                    activeTab === tab.key
                      ? "border-b-[0.5px] [border-bottom-style:solid] border-white"
                      : "border-b-[0.5px] [border-bottom-style:solid] border-transparent hover:border-gray-400"
                  }`}
                >
                  <div
                    className={`relative w-fit text-[14px] md:text-[16px] text-center leading-[18.6px] whitespace-nowrap transition-all duration-300 ${
                      activeTab === tab.key
                        ? "font-medium text-white mt-[-0.50px]"
                        : "font-normal text-white mt-[-2.00px] hover:text-[#f2ca99]"
                    }`}
                  >
                    {tab.label}
                  </div>
                </button>
              ))}
            </div>
          </div>

          {/* First Slider */}
          <div className="w-full">
            <Slider
              slidesToShow={3}
              slidesToScroll={1}
              // infinite={galleryData[activeTab].length > 3}
              arrows={true}
              dots={false}
              adaptiveHeight={false}
              autoplay={true}
              variableWidth={true}
              speed={1500}
              // INSERT_YOUR_CODE
              nextArrow={
                <button
                  type="button"
                  className="slick-next custom-arrow right-2 top-1/2 absolute z-10 bg-[#f2ca99] text-black rounded-full p-2 shadow-lg hover:bg-[#e2b87a] transition"
                  style={{ transform: "translateY(-50%)" }}
                  aria-label="Next"
                >
                  <svg
                    width="48"
                    height="48"
                    viewBox="0 0 48 48"
                    fill="none"
                    xmlns="http://www.w3.org/2000/svg"
                  >
                    <rect
                      x="0.5"
                      y="0.5"
                      width="47"
                      height="47"
                      rx="23.5"
                      stroke="#F2CA99"
                    />
                    <path
                      d="M29.031 24.531L21.531 32.031C21.4614 32.1007 21.3786 32.156 21.2876 32.1937C21.1965 32.2314 21.099 32.2508 21.0004 32.2508C20.9019 32.2508 20.8043 32.2314 20.7132 32.1937C20.6222 32.156 20.5395 32.1007 20.4698 32.031C20.4001 31.9614 20.3448 31.8786 20.3071 31.7876C20.2694 31.6965 20.25 31.599 20.25 31.5004C20.25 31.4019 20.2694 31.3043 20.3071 31.2132C20.3448 31.1222 20.4001 31.0395 20.4698 30.9698L27.4401 24.0004L20.4698 17.031C20.3291 16.8903 20.25 16.6994 20.25 16.5004C20.25 16.3014 20.3291 16.1105 20.4698 15.9698C20.6105 15.8291 20.8014 15.75 21.0004 15.75C21.1994 15.75 21.3903 15.8291 21.531 15.9698L29.031 23.4698C29.1008 23.5394 29.1561 23.6222 29.1938 23.7132C29.2316 23.8043 29.251 23.9019 29.251 24.0004C29.251 24.099 29.2316 24.1966 29.1938 24.2876C29.1561 24.3787 29.1008 24.4614 29.031 24.531Z"
                      fill="white"
                    />
                  </svg>
                </button>
              }
              prevArrow={
                <button
                  type="button"
                  className="slick-prev custom-arrow left-2 top-1/2 absolute z-10 bg-[#f2ca99] text-black rounded-full p-2 shadow-lg hover:bg-[#e2b87a] transition"
                  style={{ transform: "translateY(-50%)" }}
                  aria-label="Previous"
                >
                  <svg
                    width="48"
                    height="48"
                    viewBox="0 0 48 48"
                    fill="none"
                    xmlns="http://www.w3.org/2000/svg"
                  >
                    <rect
                      x="-0.5"
                      y="0.5"
                      width="47"
                      height="47"
                      rx="23.5"
                      transform="matrix(-1 0 0 1 47 0)"
                      stroke="#F2CA99"
                    />
                    <path
                      d="M18.969 24.531L26.469 32.031C26.5386 32.1007 26.6214 32.156 26.7124 32.1937C26.8035 32.2314 26.901 32.2508 26.9996 32.2508C27.0981 32.2508 27.1957 32.2314 27.2868 32.1937C27.3778 32.156 27.4605 32.1007 27.5302 32.031C27.5999 31.9614 27.6552 31.8786 27.6929 31.7876C27.7306 31.6965 27.75 31.599 27.75 31.5004C27.75 31.4019 27.7306 31.3043 27.6929 31.2132C27.6552 31.1222 27.5999 31.0395 27.5302 30.9698L20.5599 24.0004L27.5302 17.031C27.6709 16.8903 27.75 16.6994 27.75 16.5004C27.75 16.3014 27.6709 16.1105 27.5302 15.9698C27.3895 15.8291 27.1986 15.75 26.9996 15.75C26.8006 15.75 26.6097 15.8291 26.469 15.9698L18.969 23.4698C18.8992 23.5394 18.8439 23.6222 18.8062 23.7132C18.7684 23.8043 18.749 23.9019 18.749 24.0004C18.749 24.099 18.7684 24.1966 18.8062 24.2876C18.8439 24.3787 18.8992 24.4614 18.969 24.531Z"
                      fill="white"
                    />
                  </svg>
                </button>
              }
              autoplaySpeed={3000}
              className="gallery-slider"
              responsive={[
                {
                  breakpoint: 992,
                  settings: {
                    slidesToShow: 2,
                    variableWidth: false,
                  },
                },
                {
                  breakpoint: 640,
                  settings: {
                    slidesToShow: 2,
                    variableWidth: false,
                  },
                },
              ]}
            >
              {galleryData[activeTab].map((image, index) => (
                <div
                  key={`slider1-${activeTab}-${index}`}
                  className="overflow-hidden hover:shadow-xl transition-shadow duration-300 mx-2 h-full"
                  style={{
                    width: "auto",
                    minWidth: 280,
                    maxWidth: 400,
                  }}
                >
                  <img
                    src={image}
                    alt={`${activeTab} gallery image ${index + 1}`}
                    className="w-full h-full object-cover hover:scale-105 transition-transform duration-300"
                    loading="lazy"
                  />
                </div>
              ))}
            </Slider>
          </div>
        </div>
      </section>

      <div className="full-img-sextion py-4 px-2">
        <img
          src={fullbg}
          alt="Bastian Inka Banner"
          className="w-full h-auto object-cover"
        />
      </div>

      <section className="bottom-contact-sec px-[30px]">
        <div className="flex flex-col max-w-[1240px] mx-auto items-start gap-8 px-0 py-[72px] relative  border-b-[0.5px] [border-bottom-style:solid] border-[#e2e2e2b8]">
          <div className="flex flex-col h-[91px] items-center justify-between relative self-stretch w-full">
            <div className="w-fit font-normal text-white text-[32px] text-center leading-[normal] whitespace-nowrap relative mt-[-1.00px]">
              Contact Us
            </div>
            <div className="text-box">
              <p>
                Your INKA By Bastian experience awaits. Book a table, plan a
                private event, explore upcoming happenings, or get in touch for
                any enquiries.
              </p>
            </div>
          </div>

          <div className="row-wrapper flex items-center justify-between relative self-stretch w-full ">
            <div className="gap-5 inline-flex flex-col items-start relative col-left">
              <div className="inline-flex items-center gap-4 relative ">
                <div className="relative w-6 h-6 flex items-center justify-center">
                  <svg
                    width="24"
                    height="24"
                    viewBox="0 0 24 24"
                    fill="none"
                    xmlns="http://www.w3.org/2000/svg"
                  >
                    <g clipPath="url(#clip0_730_739)">
                      <path
                        fillRule="evenodd"
                        clipRule="evenodd"
                        d="M23.2226 17.7112L19.4371 15.5255C19.2612 15.4243 19.0671 15.3587 18.8659 15.3325C18.6647 15.3063 18.4603 15.32 18.2644 15.3728C18.0685 15.4256 17.8849 15.5165 17.7241 15.6403C17.5633 15.764 17.4285 15.9183 17.3273 16.0942L17.1764 16.3527C16.794 17.0075 16.2224 17.4232 15.4785 17.5755C15.1246 17.6534 14.7578 17.6526 14.4042 17.5732C14.0506 17.4938 13.7188 17.3378 13.432 17.1162C12.1941 16.1838 11.0235 15.1652 9.92912 14.0679C8.83159 12.9742 7.8129 11.804 6.88069 10.5664C6.65879 10.2795 6.50259 9.94745 6.42316 9.5936C6.34372 9.23976 6.34298 8.87278 6.42099 8.51862C6.57446 7.77368 6.98977 7.20087 7.64715 6.81912L7.90421 6.66978C8.2586 6.4645 8.51726 6.12723 8.62362 5.73173C8.72999 5.33624 8.67539 4.91472 8.47177 4.55937L6.28538 0.774356C6.1007 0.453372 5.80659 0.209639 5.45689 0.0877735C5.1072 -0.0340918 4.72531 -0.0259364 4.38113 0.110747L4.33398 0.128934C3.59701 0.412809 1.53273 1.17115 0.991788 1.71242C0.90479 1.79941 0.823185 1.89162 0.747429 1.98856C-0.558321 3.65914 0.0978819 6.37362 0.787413 8.15445C2.0574 11.4337 4.46733 14.5893 6.93741 17.0591C9.40847 19.5299 12.5624 21.9395 15.8428 23.2109C16.9802 23.6518 18.2598 24.0003 19.4878 24.0003C20.5158 24.0003 21.5401 23.7511 22.2855 23.0059C22.5314 22.7601 22.7894 22.2114 22.9349 21.8975C23.2745 21.1653 23.5718 20.4022 23.8731 19.6533L23.8918 19.6064C24.0286 19.263 24.0362 18.8816 23.913 18.533C23.7899 18.1845 23.5448 17.8925 23.2226 17.7112Z"
                        fill="white"
                      />
                    </g>
                    <defs>
                      <clipPath id="clip0_730_739">
                        <rect width="24" height="24" fill="white" />
                      </clipPath>
                    </defs>
                  </svg>
                </div>

                <a
                  href="tel:000000000"
                  className="relative w-fit font-normal text-[#e4e4e4] text-lg leading-[normal] whitespace-nowrap"
                >
                  000000000
                </a>
              </div>

              <div className="inline-flex items-center gap-4 relative ">
                <div className="relative w-6 h-6 flex items-center justify-center">
                  <svg
                    width="24"
                    height="24"
                    viewBox="0 0 24 24"
                    fill="none"
                    xmlns="http://www.w3.org/2000/svg"
                  >
                    <path
                      d="M12.7983 15.7288L24 6.49695V4.83008C24 3.79456 23.1605 2.95508 22.125 2.95508H1.875C0.839484 2.95508 0 3.79456 0 4.83008V6.49695L11.2016 15.7287C11.6642 16.11 12.3358 16.1099 12.7983 15.7288Z"
                      fill="white"
                    />
                    <path
                      d="M12 17.8878C11.2929 17.8878 10.586 17.6502 10.0091 17.1748L0 8.92578V19.1693C0 20.2048 0.839484 21.0443 1.875 21.0443H22.125C23.1605 21.0443 24 20.2048 24 19.1693V8.92578L13.9908 17.1748C13.4141 17.6501 12.707 17.8878 12 17.8878Z"
                      fill="white"
                    />
                  </svg>
                </div>
                <a
                  href="mailto:abc@gmail.com"
                  className="relative w-fit font-normal text-[#e4e4e4] text-lg leading-[normal] whitespace-nowrap"
                >
                  abc@gmail.com
                </a>
              </div>

              <div className="inline-flex items-center gap-4 relative ">
                <div className="relative w-6 h-6 flex items-center justify-center">
                  <svg
                    width="18"
                    height="24"
                    viewBox="0 0 18 24"
                    fill="none"
                    xmlns="http://www.w3.org/2000/svg"
                  >
                    <path
                      d="M8.9999 0C4.19784 0 0.291138 3.90675 0.291138 8.70877C0.291138 10.6309 0.731388 12.6173 1.59961 14.6129C2.28609 16.1906 3.24065 17.7781 4.43681 19.3311C6.46486 21.9643 8.46993 23.5767 8.55426 23.6442L8.99995 24L9.44568 23.6441C9.53001 23.5767 11.5351 21.9643 13.5631 19.3311C14.7593 17.778 15.7139 16.1906 16.4003 14.6128C17.2686 12.6173 17.7088 10.6309 17.7088 8.70872C17.7087 3.90675 13.802 0 8.9999 0ZM8.9999 11.2262C7.61175 11.2262 6.48243 10.0969 6.48243 8.70877C6.48243 7.32066 7.61179 6.1913 8.9999 6.1913C10.388 6.1913 11.5174 7.32066 11.5174 8.70877C11.5174 10.0969 10.388 11.2262 8.9999 11.2262ZM13.8986 8.70877C13.8987 6.00759 11.7011 3.81 8.99986 3.81V2.38125C12.4889 2.38125 15.3274 5.21977 15.3274 8.70877H13.8986Z"
                      fill="white"
                    />
                  </svg>
                </div>

                <p className="relative max-w-[391px] mt-[-1.00px] font-normal text-[#e4e4e4] text-lg leading-[normal]">
                  Peninsula Corporate Park, Senapati Bapat Marg, Lower Parel
                  West, Mumbai
                </p>
              </div>
            </div>

            <div className="justify-between self-stretch inline-flex flex-col col-right">
              <div className="flex max-w-[525px] items-center gap-[30px] md:gap-[180px] relative">
                <div className="relative w-fit mt-[-1.00px] font-normal text-white text-xl leading-[normal] whitespace-nowrap">
                  Mon
                </div>

                <div className="relative w-fit font-normal text-[#e4e4e4] text-base leading-[normal] whitespace-nowrap">
                  Closed
                </div>
              </div>

              <div className="inline-flex items-start gap-[30px] md:gap-[135px] relative">
                <div className="relative w-fit mt-[-1.00px] font-normal text-white text-xl leading-[normal] whitespace-nowrap">
                  Tue - Sun
                </div>

                <div className="inline-flex flex-col items-start gap-2.5 relative self-stretch ">
                  <p className="relative w-fit mt-[-1.00px] font-normal text-[#e4e4e4] text-base leading-[19.2px]">
                    First Seating - 7:30 Pm To 9:30 Pm & 8 Pm - 10 Pm
                    <br />
                    second Seating - 10 Pm - 12 Pm & 10:30 Pm - 12:30 Am
                  </p>
                </div>
              </div>

              <div className="flex max-w-[558px] items-center gap-[30px] md:gap-[106px] relative">
                <div className="inline-flex flex-col items-start gap-2.5 relative ">
                  <div className="relative self-stretch mt-[-1.00px] font-normal text-white text-xl leading-[normal]">
                    Wed, Fri, Sat
                  </div>
                </div>

                <div className="inline-flex flex-col items-start gap-2.5 relative ">
                  <div className="relative w-fit mt-[-1.00px] font-normal text-[#e4e4e4] text-base leading-[normal] whitespace-nowrap">
                    Bar Nights
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
      <section className="slot-sec px-[30px]">
        <div className="container-box max-w-[1240px] mx-auto">
          <div className="flex flex-col items-center gap-2 px-0 py-[40px] md:py-[72px] relative self-stretch w-full  backdrop-blur-sm backdrop-brightness-[100%] [-webkit-backdrop-filter:blur(4px)_brightness(100%)]">
            <div className="inline-flex flex-col items-center gap-[40px] relative w-full">
              <Reservation col={true} />

              <div className="flex flex-col items-center justify-center gap-10 relative w-full">
                <div className="flex flex-col items-center gap-10 relative w-full">
                  <div className="flex flex-col max-w-[746px] items-center gap-6 relative w-full">
                    <div className="relative self-stretch mt-[-1.00px] font-semibold text-white text-xl text-center leading-[normal]">
                      Available Time Slots
                    </div>

                    <div className="box-wrapper w-full">
                      <div className="grid-box">
                        <div className="slot-box w-full flex items-center justify-center gap-2 px-[20.5px] py-[18px] relative flex-1 grow border-[0.5px] border-solid border-[#fafafacc]">
                          <div className="relative w-fit mt-[-0.50px] ml-[-13.00px] mr-[-13.00px] font-normal text-[#fafafacc] text-lg leading-[normal] whitespace-nowrap">
                            12:30 PM
                          </div>
                        </div>
                        <div className="slot-box w-full flex items-center justify-center gap-2 px-[20.5px] py-[18px] relative flex-1 grow border-[0.5px] border-solid border-[#fafafacc]">
                          <div className="relative w-fit mt-[-0.50px] ml-[-13.00px] mr-[-13.00px] font-normal text-[#fafafacc] text-lg leading-[normal] whitespace-nowrap">
                            12:30 PM
                          </div>
                        </div>
                        <div className="slot-box w-full flex items-center justify-center gap-2 px-[20.5px] py-[18px] relative flex-1 grow border-[0.5px] border-solid border-[#fafafacc]">
                          <div className="relative w-fit mt-[-0.50px] ml-[-13.00px] mr-[-13.00px] font-normal text-[#fafafacc] text-lg leading-[normal] whitespace-nowrap">
                            12:30 PM
                          </div>
                        </div>
                        <div className="slot-box w-full flex items-center justify-center gap-2 px-[20.5px] py-[18px] relative flex-1 grow border-[0.5px] border-solid border-[#fafafacc]">
                          <div className="relative w-fit mt-[-0.50px] ml-[-13.00px] mr-[-13.00px] font-normal text-[#fafafacc] text-lg leading-[normal] whitespace-nowrap">
                            12:30 PM
                          </div>
                        </div>
                        <div className="slot-box w-full flex items-center justify-center gap-2 px-[20.5px] py-[18px] relative flex-1 grow border-[0.5px] border-solid border-[#fafafacc]">
                          <div className="relative w-fit mt-[-0.50px] ml-[-13.00px] mr-[-13.00px] font-normal text-[#fafafacc] text-lg leading-[normal] whitespace-nowrap">
                            12:30 PM
                          </div>
                        </div>
                        <div className="slot-box w-full flex items-center justify-center gap-2 px-[20.5px] py-[18px] relative flex-1 grow border-[0.5px] border-solid border-[#fafafacc]">
                          <div className="relative w-fit mt-[-0.50px] ml-[-13.00px] mr-[-13.00px] font-normal text-[#fafafacc] text-lg leading-[normal] whitespace-nowrap">
                            12:30 PM
                          </div>
                        </div>
                        <div className="slot-box w-full flex items-center justify-center gap-2 px-[20.5px] py-[18px] relative flex-1 grow border-[0.5px] border-solid border-[#fafafacc]">
                          <div className="relative w-fit mt-[-0.50px] ml-[-13.00px] mr-[-13.00px] font-normal text-[#fafafacc] text-lg leading-[normal] whitespace-nowrap">
                            12:30 PM
                          </div>
                        </div>
                        <div className="slot-box w-full flex items-center justify-center gap-2 px-[20.5px] py-[18px] relative flex-1 grow border-[0.5px] border-solid border-[#fafafacc]">
                          <div className="relative w-fit mt-[-0.50px] ml-[-13.00px] mr-[-13.00px] font-normal text-[#fafafacc] text-lg leading-[normal] whitespace-nowrap">
                            12:30 PM
                          </div>
                        </div>
                        <div className="slot-box w-full flex items-center justify-center gap-2 px-[20.5px] py-[18px] relative flex-1 grow border-[0.5px] border-solid border-[#fafafacc]">
                          <div className="relative w-fit mt-[-0.50px] ml-[-13.00px] mr-[-13.00px] font-normal text-[#fafafacc] text-lg leading-[normal] whitespace-nowrap">
                            12:30 PM
                          </div>
                        </div>
                        <div className="slot-box w-full flex items-center justify-center gap-2 px-[20.5px] py-[18px] relative flex-1 grow border-[0.5px] border-solid border-[#fafafacc]">
                          <div className="relative w-fit mt-[-0.50px] ml-[-13.00px] mr-[-13.00px] font-normal text-[#fafafacc] text-lg leading-[normal] whitespace-nowrap">
                            12:30 PM
                          </div>
                        </div>
                        <div className="slot-box w-full flex items-center justify-center gap-2 px-[20.5px] py-[18px] relative flex-1 grow border-[0.5px] border-solid border-[#fafafacc]">
                          <div className="relative w-fit mt-[-0.50px] ml-[-13.00px] mr-[-13.00px] font-normal text-[#fafafacc] text-lg leading-[normal] whitespace-nowrap">
                            12:30 PM
                          </div>
                        </div>
                        <div className="slot-box w-full flex items-center justify-center gap-2 px-[20.5px] py-[18px] relative flex-1 grow border-[0.5px] border-solid border-[#fafafacc]">
                          <div className="relative w-fit mt-[-0.50px] ml-[-13.00px] mr-[-13.00px] font-normal text-[#fafafacc] text-lg leading-[normal] whitespace-nowrap">
                            12:30 PM
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <button className="all-[unset] box-border flex max-w-[248px] h-12 items-center justify-center gap-1.5 px-4 py-[7px] relative">
                    <div className="inline-flex items-start gap-[10px] relative ">
                      <div className="relative w-fit mt-[-1.00px] font-medium text-[#f2ca99] text-xl text-center leading-[normal] whitespace-nowrap">
                        Continue
                      </div>
                      <svg
                        width="19"
                        height="16"
                        viewBox="0 0 19 16"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                      >
                        <path
                          d="M18.2806 8.53104L11.5306 15.281C11.3899 15.4218 11.199 15.5008 11 15.5008C10.801 15.5008 10.6101 15.4218 10.4694 15.281C10.3286 15.1403 10.2496 14.9494 10.2496 14.7504C10.2496 14.5514 10.3286 14.3605 10.4694 14.2198L15.9397 8.75042H1.25C1.05109 8.75042 0.860322 8.6714 0.71967 8.53075C0.579018 8.3901 0.5 8.19933 0.5 8.00042C0.5 7.8015 0.579018 7.61074 0.71967 7.47009C0.860322 7.32943 1.05109 7.25042 1.25 7.25042H15.9397L10.4694 1.78104C10.3286 1.64031 10.2496 1.44944 10.2496 1.25042C10.2496 1.05139 10.3286 0.860523 10.4694 0.719792C10.6101 0.579062 10.801 0.5 11 0.5C11.199 0.5 11.3899 0.579062 11.5306 0.719792L18.2806 7.46979C18.3504 7.53945 18.4057 7.62216 18.4434 7.71321C18.4812 7.80426 18.5006 7.90186 18.5006 8.00042C18.5006 8.09898 18.4812 8.19657 18.4434 8.28762C18.4057 8.37867 18.3504 8.46139 18.2806 8.53104Z"
                          fill="#F2CA99"
                        />
                      </svg>
                    </div>
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
  );
}
