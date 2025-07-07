/* eslint-disable react/prop-types */
 

export default function SectionHeading({headingText}) {
  return (
    <div className="w-full h-auto p-3 md:p-6 py-6 md:py-8 flex flex-col justify-center items-center gap-3 md:gap-4 inner-text overflow-hidden" >
        <h1 className="text-text-primary text-[24px] md:text-[48px]" data-aos="fade-up">{headingText.heading}</h1>
        <h4 className="text-white text-center text-[12px] md:text-xl text-wrap mx-w-[350px] md:w-full" data-aos="fade-up"> 
            {headingText.text}
        </h4>
      </div>
  )
}
