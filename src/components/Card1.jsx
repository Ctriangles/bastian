/* eslint-disable react/prop-types */
import { FaArrowRightLong } from "react-icons/fa6";

export default function Card1({ data }) {
  return (
    <div className="rounded-xl inner-card" data-aos="fade-up">
      <img src={data.img} alt="" className=" rounded-xl w-full object-cover" />
      <div className="flex flex-col justify-center items-start gap-4 md:gap-2 pt-10 pb-10 md:px-8 md:py-10 md:pb-20">
        <span className="text-text-primary text-[12px] md:text-[15px]">
          {data.date}
        </span>
        <h1 className="text-white text-[16px] md:text-[24px]">
          {data.heading}
        </h1>
        <span className="text-white text-[12px] md:text-[16px] -mt-[10px] md:mt-0">
          <a href={data.link} target="_blank"  rel="noopener noreferrer" className="flex flex items-center gap-2 ">
            Read More  <FaArrowRightLong />
          </a>
        </span>
        
      </div>
    </div>
  );
}
