import React, { useEffect, useRef } from "react";
import gsap from "gsap";
import { ScrollTrigger } from "gsap/ScrollTrigger";

// Register ScrollTrigger plugin
gsap.registerPlugin(ScrollTrigger);

const RevealAnimation = ({ children }) => {
  const revealRef = useRef(null);

  useEffect(() => {
    const fronDiv = revealRef.current.querySelector(".front");

    // Create GSAP timeline with ScrollTrigger for reveal effect
    let tl = gsap.timeline({
      repeatDelay: 2,
      scrollTrigger: {
        trigger: revealRef.current,
        toggleActions: "restart none none reset",
      },
    });

    tl.to(fronDiv, {
      xPercent: 100,
      ease: "Power2.out",
      duration: 1,
    });

    // Cleanup on component unmount
    return () => {
      if (tl.scrollTrigger) tl.scrollTrigger.kill();
      tl.kill();
    };
  }, []);

  // Hover effect with smooth 3D tilt
  const handleMouseMove = (e) => {
    const rect = revealRef.current.getBoundingClientRect();
    const x = e.clientX - rect.left;
    const y = e.clientY - rect.top;
    const centerX = rect.width / 3;
    const centerY = rect.height / 3;
    const rotateX = ((y - centerY) / centerY) * 8; // Reduced multiplier for subtle effect
    const rotateY = ((centerX - x) / centerX) * 8;

    gsap.to(revealRef.current, {
      rotationX: rotateX,
      rotationY: rotateY,
      transformPerspective: 800, // Increased perspective for smoothness
      ease: "power3.out", // Smoother easing function
      duration: 0.5, // Increased duration for smoother transitions
    });
  };

  // Reset smoothly on mouse leave
  const handleMouseLeave = () => {
    gsap.to(revealRef.current, {
      rotationX: 0,
      rotationY: 0,
      ease: "power3.out",
      duration: 0.7, // Slightly longer reset duration for smooth return
    });
  };

  return (
    <div
      className="reveal"
      ref={revealRef}
      onMouseMove={handleMouseMove}
      onMouseLeave={handleMouseLeave}
    >
      {children}
    </div>
  );
};

export default RevealAnimation;
