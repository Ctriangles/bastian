import "./App.css";
import React, { useEffect } from 'react';
import { BrowserRouter as Router, Routes, Route, Navigate, useLocation } from "react-router-dom";
import { Helmet } from "react-helmet";

import Home from "./pages/Home";
import VisionariesPage from "./pages/VisionariesPage";
import Header from "./components/Header";
import Footer from "./components/Footer";
import AwardsPage from "./pages/AwardsPage";
import MediaPage from "./pages/MediaPage";
import CurationPage from "./pages/CurationPage";
import AtTheTopPage from "./pages/AtTheTopPage";
import BastianBandraPage from "./pages/BastianBandraPage";
import BastianGardenCity from "./pages/BastianGardenCity";
import BastianEmpirePage from "./pages/BastianEmpirePage";
import BastianInka from "./pages/BastianInka";
import Blondie from "./pages/Blondie";
import Career from "./pages/Career";
import Thankyou from "./pages/Thankyou";
import Reservations from "./pages/Reservations";
import TermsAndConditions from "./pages/TermsAndConditions";
import AOS from 'aos';
import 'aos/dist/aos.css';
import { initFacebookPixel } from './utils/facebookPixel';
import { initGTM } from './utils/gtm';
import ReservationsNew from "./pages/ReservationsNew";

// ✅ Canonical Tag Component
const CanonicalTag = () => {
  const location = useLocation();
  const canonicalUrl = `https://www.bastianhospitality.com${location.pathname}`;

  return (
    <Helmet>
      <link rel="canonical" href={canonicalUrl} />
    </Helmet>
  );
};

function AppRoutes() {
  return (
    <>
      <CanonicalTag /> {/* Injects dynamic canonical tag */}
      <Routes>
        <Route path="/" element={<Home />} />
        <Route path="/visionaries" element={<VisionariesPage />} />
        <Route path="/awards" element={<AwardsPage />} />
        <Route path="/mediacoverage" element={<MediaPage />} />
        <Route path="/curation" element={<CurationPage />} />
        <Route path="/bastianattop" element={<AtTheTopPage />} />
        <Route path="/bastianbandra" element={<BastianBandraPage />} />
        <Route path="/bastiangarden" element={<BastianGardenCity />} />
        <Route path="/bastianempire" element={<BastianEmpirePage />} />
        <Route path="/bastianinka" element={<BastianInka />} />
        <Route path="/blondie" element={<Blondie />} />
        <Route path="/career" element={<Career />} />
        <Route path="/thank-you" element={<Thankyou />} />
        <Route path="/reservations" element={<Reservations />} />
        <Route path="/reservations-new" element={<ReservationsNew />} />
        <Route path="/tcs" element={<TermsAndConditions />} />
        <Route path="*" element={<Navigate to="/" replace />} />
      </Routes>
    </>
  );
}

function App() {
  useEffect(() => {
    AOS.init({ duration: 1000, once: false });
    initFacebookPixel();
    initGTM();
  }, []);

  return (
    <Router>
      <Header />
      <AppRoutes />
      <Footer />
    </Router>
  );
}

export default App;
