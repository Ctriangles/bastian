/* eslint-disable react/prop-types */
import { FaArrowRight } from "react-icons/fa";
import { Link } from "react-router-dom";


export default function HeroHeading({heroText}) {
  return (
    
    <div className="w-full h-auto p-5 md:p-6 py-9 md:py-12 flex flex-col justify-center items-center gap-3 md:gap-4">
    <h1 className="text-text-primary text-[24px] md:text-[48px]">
      {heroText.heading}
    </h1>
    <h4 className="text-white text-center text-[12px] md:text-xl">
      {heroText.text}
    </h4>
    {/* <span className="text-text-primary text-xs flex items-center gap-1">
      Know more <FaArrowRight className="text-[10px]" />
    </span> */}
    <Link to="/visionaries" className="text-text-primary text-xs flex items-center gap-1">Know more <FaArrowRight className="text-[10px]" /> </Link>
  </div>

  )
}
