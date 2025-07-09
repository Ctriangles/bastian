/* eslint-disable react/prop-types */ 

export default function HeroSection({ bg, bg2, HeroImgText, bgGredientImage }) {
  return (
    <>
      <div
        className={`heroBanner w-full ${HeroImgText.changeStyle ? "h-[783px]" : "h-[783px]"} relative`}
      >
        {/* Desktop Background */}
        <img
          src={bg}
          alt="...BG"
          className="w-full h-full object-cover hidden md:block"
        />
        
        {/* Mobile Background */}
        <img
          src={bg2}
          alt="...BG"
          className="w-full h-[783px] object-cover md:hidden inner-mob-banner"
        />
        
        {/* Gradient Image */}
        <div className="w-full h-100 absolute bottom-[-3px] left-0 right-0">
          <img
            src={bgGredientImage}
            alt="Gradient Background"
            className="w-full h-[1000px] object-cover"
          />
        </div>
        
        {/* Banner Content */}
        <div className="w-full text-center absolute bannerContent left-0 right-0 text-white px-6">
          {/* Main Heading (h1) */}
          <h1 
            data-aos="fade-up"
            className={`${
              HeroImgText.changeStyle
                ? "text-[32px] md:text-[48px] text-text-primary leading-[1.8] top-text font-light mb-6"
                : "text-[20px] md:text-[48px] leading-[1.8] font-light top-text"
            }`}
          >
            {HeroImgText.heading1}
          </h1>
          
          {/* Secondary Heading (h2) for SEO Improvement */}
          <h2 
            data-aos="fade-up"
            className={`${
              HeroImgText.changeStyle
                ? "text-[14px] md:text-[24px] text-white leading-[30px] leading-[1.4] md:leading-[1.6] font-light small-text"
                : "text-[20px] md:text-[48px] leading-[1.4] md:leading-[1.6] font-light bottom-text"
            }`}
            // Using dangerouslySetInnerHTML to render the HTML content
            dangerouslySetInnerHTML={{
              __html: HeroImgText.heading2,
            }}
          />
        </div>
      </div>
    </>
  );
}
