export const initStructuredData = () => {
  const script = document.createElement('script');
  script.type = 'application/ld+json';

  const structuredData = {
    "@context": "https://schema.org",
    "@type": "WebPage",
    "url": "https://www.bastianhospitality.com/",
    "name": "Bastian Hospitality",
    "description": "Bastian Hospitality provides a deluxe escape for luxurious dining and nightlife, with a vision of innovation, quality & expansion.",
    "about": {
      "@type": "Organization",
      "name": "Bastian Hospitality",
      "url": "https://www.bastianhospitality.com/",
      "logo": "https://www.bastianhospitality.com/assets/logo-BW7fw7nR.png",
      "sameAs": [
        "https://www.linkedin.com/company/bastian-hospitality/",
        "https://www.instagram.com/bastianmumbai/"
      ],
      "department": [
        {
          "@type": "Restaurant",
          "name": "Bastian Bandra",
          "url": "https://www.bastianhospitality.com/bastianbandra",
          "address": {
            "@type": "PostalAddress",
            "streetAddress": "Kamal Building, B/1, New, Linking Rd, next to Burger King, Bandra West",
            "addressLocality": "Mumbai",
            "addressRegion": "MH",
            "postalCode": "400050",
            "addressCountry": "IN"
          }
        },
        {
          "@type": "Restaurant",
          "name": "Bastian At The Top",
          "url": "https://www.bastianhospitality.com/bastianattop",
          "address": {
            "@type": "PostalAddress",
            "streetAddress": "48th Floor, Kohinoor Square, N C. Kelkar Marg, Dadar West, Shivaji Park",
            "addressLocality": "Mumbai",
            "addressRegion": "MH",
            "postalCode": "400028",
            "addressCountry": "IN"
          }
        },
        {
          "@type": "Restaurant",
          "name": "Bastian Garden City",
          "url": "https://www.bastianhospitality.com/bastiangarden",
          "address": {
            "@type": "PostalAddress",
            "streetAddress": "4, St Mark's Rd, Shanthala Nagar, Ashok Nagar",
            "addressLocality": "Bengaluru",
            "addressRegion": "KA",
            "postalCode": "560001",
            "addressCountry": "IN"
          }
        },
        {
          "@type": "Restaurant",
          "name": "Bastian Empire",
          "url": "https://www.bastianhospitality.com/bastianempire",
          "address": {
            "@type": "PostalAddress",
            "streetAddress": "The Westin, 36, Mundhwa Rd, Koregaon Park Annexe, Ghorpadi",
            "addressLocality": "Pune",
            "addressRegion": "MH",
            "postalCode": "411001",
            "addressCountry": "IN"
          }
        }
      ]
    }
  };

  script.text = JSON.stringify(structuredData);
  document.head.appendChild(script);
};
