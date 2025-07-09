import { useState, useEffect } from "react";
import DatePicker from "react-datepicker";
import "react-datepicker/dist/react-datepicker.css";
import ReCAPTCHA from "react-google-recaptcha";
import success from "../assets/logo/success-icon.svg";
import { useSecureRestaurants, checkAvailability, createFullReservation } from "../API/secure-reservation.jsx";
import React from "react";
import { QRCodeSVG } from 'qrcode.react';


const ReservationsEatApp = () => {
  // Step management
  const [currentStep, setCurrentStep] = useState(1);
  const [loading, setLoading] = useState(false);
  const [error, setError] = useState("");
  const [recaptchaValue, setRecaptchaValue] = useState(null);

  // Form data state
  const [formData, setFormData] = useState({
    restaurant_id: "",
    booking_date: new Date(),
    covers: "2",
    start_time: "",
    first_name: "",
    last_name: "",
    email: "",
    phone: "",
    notes: "",
    agerange: "25-35",
    pincode: "",
  });

  // API data states
  const { restaurants, error: restaurantsError, loading: restaurantsLoading, getRestaurants } = useSecureRestaurants();
  const [availableSlots, setAvailableSlots] = useState([]);
  const [reservationSuccess, setReservationSuccess] = useState(false);
  const [response, setResponse] = useState(null);
  const restaurantAddress = ""; // not provided by api, but it should be based on the restaurant selection

  // Field-specific errors state
  const [fieldErrors, setFieldErrors] = useState({
    first_name: "",
    last_name: "",
    email: "",
    phone: "",
    recaptcha: ""
  });

  const fetchAvailability = async () => {
    if (!formData.restaurant_id || !formData.booking_date || !formData.covers) {
      setError("Please select restaurant, date and number of guests");
      return;
    }

    try {
      setFormData(preState => ({
        ...preState,
        start_time: ''
      }));

      setLoading(true);

      const availabilityData = {
        restaurant_id: formData.restaurant_id,
        earliest_start_time: formData.booking_date.toISOString().split('T')[0] + "T12:00:00",
        latest_start_time: formData.booking_date.toISOString().split('T')[0] + "T22:00:00",
        covers: parseInt(formData.covers),
      };

      const result = await checkAvailability(availabilityData);

      if (result.success && result.data?.data?.attributes?.available) {
        // Format the time slots to be more user-friendly
        const formattedSlots = result.data.data.attributes.available.map(time => ({
          value: time, // Keep original ISO time
          display: new Date(time).toLocaleTimeString('en-US', {
            hour: 'numeric',
            minute: '2-digit',
            hour12: true
          })
        }));
        setAvailableSlots(formattedSlots);
      } else {
        setAvailableSlots([]);
        if (result.error) {
          setError(result.error);
        }
      }
    } catch (error) {
      console.error('Availability fetch error:', error);
      setError("Failed to fetch available time slots. Please try again.");
    } finally {
      setLoading(false);
    }
  };

  const handleSubmitReservation = async () => {
    if (!validateStep2()) return;

    try {
      setLoading(true);

      // Prepare reservation data for our secure API
      const reservationData = {
        restaurant_id: formData.restaurant_id,
        booking_date: formData.booking_date.toISOString().split('T')[0],
        booking_time: formData.start_time.split('T')[1],
        full_name: formData.first_name + " " + formData.last_name,
        first_name: formData.first_name,
        last_name: formData.last_name,
        email: formData.email,
        mobile: formData.phone,
        pax: formData.covers,
        age: formData.agerange,
        pincode: formData.pincode,
        comments: formData.notes,
        start_time: formData.start_time
      };

      const result = await createFullReservation(reservationData);

      if (result.success && result.data?.data?.attributes?.key) {
        // Create response object in the expected format
        setResponse({
          data: result.data,
          status: 201
        });
        setReservationSuccess(true);
      } else {
        // Handle validation errors
        if (result.validations) {
          const validationErrors = result.validations
            .map(v => `${v.key}: ${v.message}`)
            .join(', ');
          setError(validationErrors);
        } else {
          setError(result.message || "Failed to make reservation");
        }
      }
    } catch (error) {
      console.error('Reservation error:', error);
      setError("Failed to submit reservation. Please try again.");
    } finally {
      setLoading(false);
    }
  };

  const handleChange = (e) => {
    const { name, value } = e.target;

    if (name === 'first_name' || name === 'last_name') {
      // Allow only letters and spaces
      const formattedValue = value.replace(/[^A-Za-z\s]/g, '');
      setFormData(prev => ({
        ...prev,
        [name]: formattedValue
      }));
    } else if (name === 'notes') {
      // Limit special requests to 200 characters
      const maxLength = 200;
      setFormData(prev => ({
        ...prev,
        [name]: value.slice(0, maxLength)
      }));
    } else {
      setFormData(prev => ({
        ...prev,
        [name]: value
      }));
    }

    // Clear the error for this field when user starts typing
    if (fieldErrors[name]) {
      setFieldErrors(prev => ({
        ...prev,
        [name]: ""
      }));
    }
  };

  const handleDateChange = (date) => {
    setFormData(prev => ({
      ...prev,
      booking_date: date
    }));
  };

  const validateStep1 = () => {
    if (!formData.restaurant_id || !formData.booking_date || !formData.covers) {
      setError("Please fill in all required fields");
      return false;
    }
    if (!formData.start_time) {
      setError("Please select a time slot");
      return false;
    }
    return true;
  };
  const validateStep2 = () => {
    let isValid = true;
    const newFieldErrors = {
      first_name: "",
      last_name: "",
      email: "",
      phone: "",
      recaptcha: ""
    };

    // First name validation
    if (!formData.first_name) {
      newFieldErrors.first_name = "First name is required";
      isValid = false;
    } else if (formData.first_name.length < 2) {
      newFieldErrors.first_name = "First name must be at least 2 characters long";
      isValid = false;
    } else if (!/^[A-Za-z\s]{2,50}$/.test(formData.first_name)) {
      newFieldErrors.first_name = "First name can only contain letters and spaces";
      isValid = false;
    }

    // Last name validation
    if (!formData.last_name) {
      newFieldErrors.last_name = "Last name is required";
      isValid = false;
    } else if (formData.last_name.length < 2) {
      newFieldErrors.last_name = "Last name must be at least 2 characters long";
      isValid = false;
    } else if (!/^[A-Za-z\s]{2,50}$/.test(formData.last_name)) {
      newFieldErrors.last_name = "Last name can only contain letters and spaces";
      isValid = false;
    }

    // Email validation
    if (!formData.email) {
      newFieldErrors.email = "Email is required";
      isValid = false;
    } else if (!/^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,}$/i.test(formData.email)) {
      newFieldErrors.email = "Please enter a valid email address";
      isValid = false;
    }

    // Phone validation
    if (!formData.phone) {
      newFieldErrors.phone = "Phone number is required";
      isValid = false;
    } else if (!/^[0-9]{10}$/.test(formData.phone.replace(/\D/g, ''))) {
      newFieldErrors.phone = "Please enter a valid 10-digit phone number";
      isValid = false;
    }

    // reCAPTCHA validation
    if (!recaptchaValue) {
      newFieldErrors.recaptcha = "Please complete the reCAPTCHA verification";
      isValid = false;
    }

    setFieldErrors(newFieldErrors);
    return isValid;
  };

  const handleNextStep = () => {
    setError("");
    if (currentStep === 1 && validateStep1()) {
      setCurrentStep(2);
    } else if (currentStep === 2 && validateStep2()) {
      handleSubmitReservation()
    }
  };

  const handlePrevStep = () => {
    setCurrentStep(prev => prev - 1);
    setError("");
  };

  // Show error if restaurants fetch fails
  useEffect(() => {
    if (restaurantsError) {
      setError(restaurantsError);
    }
  }, [restaurantsError]);

  useEffect(() => {
    if (formData.restaurant_id && formData.booking_date) {
      fetchAvailability();
    }
  }, [formData.restaurant_id, formData.booking_date, formData.covers]);

  // Add LoadingOverlay component at the top of the file
  const LoadingOverlay = () => (
    <div role="status" className="absolute inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
      <div className="animate-spin rounded-full border-4 border-gray-300 border-t-gray-900 h-10 w-10" data-id="3"></div>
      <span className="sr-only">Loading...</span>
    </div>
  );


  const FieldErrorMessage = ({ message, className = '' }) => {
    if (!message) return null;
    return (
      <div className={`text-red-500 text-xs mt-1 ${className}`}>
        {message}
      </div>
    );
  };

  return (
    <div className={`form-wrapper mt-2 ${loading ? 'relative' : ''}`}>
      {loading && <LoadingOverlay />}
      {!reservationSuccess ? (
        <>
          {/* Step 1: Restaurant & Date Selection with Time Slots */}
          {currentStep === 1 && (
            <div className="step-1">
              <div className="searh-form-box p-4">
                <form onSubmit={(e) => { e.preventDefault(); handleNextStep(); }}>
                  <div className="inner-form-wrapper grid grid-cols-9 gap-2	 md:gap-8">

                    <div className="col-span-4 md:col-span-4">
                      <label className="block text-grey-700 text-xs font-medium mb-1">
                        Restaurant
                      </label>
                      <select
                        name="restaurant_id"
                        value={formData.restaurant_id}
                        onChange={handleChange}
                        required
                        className="w-full p-2 border border-text-primary bg-[#101010]"
                        disabled={restaurantsLoading}
                      >
                        <option value="">
                          {restaurantsLoading ? "Loading restaurants..." :
                           restaurantsError ? "Failed to fetch restaurants" :
                           "Select Restaurant"}
                        </option>
                        {!restaurantsLoading && !restaurantsError && getRestaurants().map(restaurant => (
                          <option key={restaurant.id} value={restaurant.id}>
                            {restaurant.attributes.name}
                          </option>
                        ))}
                      </select>
                    </div>

                    <div className="col-span-2">
                      <label className="block text-grey-700 text-xs font-medium mb-1">
                        Guests
                      </label>
                      <select
                        name="covers"
                        value={formData.covers}
                        onChange={handleChange}
                        required
                        className="w-full p-2 border border-text-primary bg-[#101010]"
                      >
                        {[1, 2, 3, 4, 5, 6, 7, 8].map(num => (
                          <option key={num} value={num}>{num}</option>
                        ))}
                      </select>
                    </div>

                    <div className="col-span-3 md:col-span-3">
                      <label className="block text-grey-700 text-xs font-medium mb-1">
                        Date
                      </label>
                      <DatePicker
                        selected={formData.booking_date}
                        onChange={handleDateChange}
                        minDate={new Date()}
                        maxDate={new Date(new Date().setDate(new Date().getDate() + 30))}
                        className="w-full p-2 border border-text-primary"
                        dateFormat="dd-MMM-yyyy"
                        required
                      />
                    </div>
                  </div>

                  {/* Time Slots Section */}
                  <div className="mt-8">
                    <h2 className="text-center mb-">Available Time Slots</h2>
                    {/* <div className="text-center text-gray-500 mb-4">Please select time slots to continue</div> */}
                    {!formData.restaurant_id ? (
                      <div className="text-center text-gray-500 mb-8">Please select a restaurant to see available time slots</div>
                    ) : availableSlots.length === 0 ? (
                      <div className="text-center text-gray-500 mb-8">No available time slots for the selected date / guests</div>
                    ) : (
                      <div className="timeslots pt-4 pb-6 grid gap-4 grid-cols-3 md:grid-cols-4">
                        {availableSlots.map((slot, index) => (
                          <div key={index} className="flex justify-center items-center relative">
                            <input
                              type="radio"
                              name="start_time"
                              id={`slot-${index}`}
                              value={slot.value}
                              onChange={handleChange}
                              className="hidden"
                              disabled={loading}
                            />
                            <label
                              htmlFor={`slot-${index}`}
                              className={`slot bg-widget !mx-0 h-12 w-full text-center select-none cursor-pointer hover:bg-black hover:text-white transition-colors ${formData.start_time === slot.value ? 'bg-black text-white' : ''
                                } ${loading ? 'opacity-50 cursor-not-allowed' : ''}`}
                            >
                              {slot.display}
                            </label>
                          </div>
                        ))}
                      </div>
                    )}
                  </div>

                  {error && (
                    <div className="text-red-500 text-center p-2">
                      {error}
                    </div>
                  )}
                  <div className="mt-4">
                    <button
                      type="submit"
                      className="w-full bg-[#000000] text-white p-2 rounded-md leading-relaxed disabled:bg-gray-400 disabled:cursor-not-allowed h-12"
                      disabled={loading || !formData.booking_date || availableSlots.length == 0}
                    >
                      Continue
                    </button>
                  </div>
                </form>
              </div>
            </div>
          )}

          {/* Step 2: Personal Details */}
          {currentStep === 2 && (
            <div className="step-2">
              <div className="reservation-detail p-4 pb-0">
                <h2 className="mb-2">Reservation details</h2>
                <div className="restaurant-name">
                  <span>{getRestaurants().find(r => r.id === formData.restaurant_id)?.attributes.name}</span>
                </div>
                <div className="select-date">
                  <span>
                    {formData.booking_date.toLocaleDateString('en-US', {
                      weekday: 'long',
                      month: 'long',
                      day: 'numeric'
                    })}, at {new Date(formData.start_time).toLocaleTimeString('en-US', {
                      hour: 'numeric',
                      minute: '2-digit',
                      hour12: true
                    })}
                  </span>
                </div>
                <div className="user-number">
                  <span>{formData.covers} {parseInt(formData.covers) === 1 ? 'person' : 'people'}</span>
                </div>

              </div>
              <div className="personal-detail p-4">
                <h2 className="mb-4">Personal details</h2>
                <form onSubmit={(e) => { e.preventDefault(); handleNextStep(); }}>
                  <div className="form-box-wrapper flex flex-col gap-4">
                    <div className="grid grid-cols-2 gap-4">
                      <div className="form-group w-full">
                        <label>First name</label>
                        <input
                          type="text"
                          name="first_name"
                          value={formData.first_name}
                          onChange={handleChange}
                          className={`w-full p-2 border ${fieldErrors.first_name ? 'border-red-500' : 'border-text-primary'}`}
                        />
                        {fieldErrors.first_name && (
                          <FieldErrorMessage message={fieldErrors.first_name} />
                        )}
                      </div>
                      <div className="form-group">
                        <label>Last name</label>
                        <input
                          type="text"
                          name="last_name"
                          value={formData.last_name}
                          onChange={handleChange}
                          className={`w-full p-2 border ${fieldErrors.last_name ? 'border-red-500' : 'border-text-primary'}`}
                        />
                        <FieldErrorMessage message={fieldErrors.last_name} />
                      </div>

                      <div className="form-group">
                        <label>Email</label>
                        <input
                          type="text"
                          name="email"
                          value={formData.email}
                          onChange={handleChange}
                          className={`w-full p-2 border ${fieldErrors.email ? 'border-red-500' : 'border-text-primary'}`}
                        />
                        <FieldErrorMessage message={fieldErrors.email} />
                      </div>
                      <div className="form-group">
                        <label>Phone</label>
                        <input
                          type="text"
                          name="phone"
                          value={formData.phone}
                          onChange={handleChange}
                          className={`w-full p-2 border ${fieldErrors.phone ? 'border-red-500' : 'border-text-primary'}`}
                        />
                        <FieldErrorMessage message={fieldErrors.phone} />
                      </div>

                      <div className="form-group">
                        <label>
                          Age Range
                        </label>
                        <select
                          name="agerange"
                          value={formData.agerange}
                          onChange={handleChange}
                          required
                          className="w-full p-2 border border-text-primary bg-[#101010]"
                        >
                          {["25-35", "36-45", "46-55", "55+"].map(num => (
                            <option key={num} value={num}>{num}</option>
                          ))}
                        </select>
                      </div>
                      <div className="form-group">
                        <label>Pincode</label>
                        <input
                          type="text"
                          name="pincode"
                          value={formData.pincode}
                          onChange={handleChange}
                          className={`w-full p-2 border  border-text-primary`}
                        />

                      </div>


                      <div className="form-group col-span-2">
                        <label>Special requests (optional)</label>
                        <textarea
                          name="notes"
                          value={formData.notes}
                          onChange={handleChange}
                          className="w-full p-2 border"
                        />
                        <div className="text-xs text-gray-500 mt-1 text-right">
                          {formData.notes.length}/200 characters
                        </div>
                      </div>
                    </div>
                    <div className="form-group">
                      <ReCAPTCHA
                        sitekey="6LcKi3kqAAAAAC3y8p4RlrxPBgf42qRInxRghNTP"
                        onChange={(value) => setRecaptchaValue(value)}
                      />
                      <FieldErrorMessage message={fieldErrors.recaptcha} />
                    </div>
                    {error && (
                      <div className="text-red-500 text-center p-2">
                        {error}
                      </div>
                    )}
                    <div className="flex gap-4">
                      <button
                        type="button"
                        onClick={handlePrevStep}
                        className="w-1/2 bg-gray-500 text-white p-2 rounded-md leading-none h-12"
                        disabled={loading}
                      >
                        Back
                      </button>
                      <button
                        type="submit"
                        className="w-1/2 bg-black text-white p-2 rounded-md leading-none h-12"
                        disabled={loading}
                      >
                        {loading ? "Processing..." : "Confirm Reservation"}
                      </button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          )}

        </>
      ) : (
        <section id="confirmation" className="pt-4 md:mb-5">
          <div className="px-4 text-grey-700 center">
            <div className="grid place-items-center text-sm">
              <img
                alt="Reservation confirmed!"
                src={success}
                className="w-24 h-24"
              />
              <span className="mt-0 mb-3 text-xl font-bold">
                Reservation confirmed!
              </span>
              <span>
                {formData.booking_date.toLocaleDateString('en-US', {
                  weekday: 'long',
                  month: 'long',
                  day: 'numeric'
                })}, at {new Date(formData.start_time).toLocaleTimeString('en-US', {
                  hour: 'numeric',
                  minute: '2-digit',
                  hour12: true
                })}
              </span>
              <span className="pt-1">
                {formData.covers} {parseInt(formData.covers) === 1 ? 'person' : 'people'}
              </span>

              <div className="mt-6">
                Eat ID: <span className="font-semibold text-custom-primary">{response.data.data.attributes.key}</span>
              </div>

              <span className="my-6 mx-10 text-center qr-code">
                <QRCodeSVG
                  value={`com.eatapp://${response.data.data.attributes.key}`}
                  size={128}
                  level="H"
                  includeMargin={false}
                  className="mx-auto"
                />
              </span>

              <div className="my-8">
                <span className="block text-center font-semibold text-lg">
                  Add to calendar
                </span>
                <div className="flex justify-center space-x-4">
                  <a
                    target="_blank"
                    className="text-primary"
                    href={`https://eatapp.co/reserve/${response.data.data.attributes.key}/apple_calendar`}
                  >
                    Apple
                  </a>
                  <a
                    target="_blank"
                    className="text-primary"
                    href={`https://calendar.google.com/calendar/render?action=TEMPLATE&dates=${formData.start_time}/${formData.end_time}&details=Your+reservation+at+${encodeURIComponent(getRestaurants().find(r => r.id === formData.restaurant_id)?.attributes.name)}+is+confirmed!&location=${encodeURIComponent(restaurantAddress)}&text=Reservation+at+${encodeURIComponent(getRestaurants().find(r => r.id === formData.restaurant_id)?.attributes.name)}`}
                  >
                    Google
                  </a>
                  <a
                    target="_blank"
                    className="text-primary"
                    href={`https://outlook.live.com/calendar/0/action/compose?body=Your+reservation+at+${encodeURIComponent(getRestaurants().find(r => r.id === formData.restaurant_id)?.attributes.name)}+is+confirmed!&enddt=${formData.end_time}&location=${encodeURIComponent(restaurantAddress)}&path=/calendar/action/compose&rru=addevent&startdt=${formData.start_time}&subject=Reservation+at+${encodeURIComponent(getRestaurants().find(r => r.id === formData.restaurant_id)?.attributes.name)}`}
                  >
                    Outlook
                  </a>
                </div>
              </div>

              <div className="mb-4">
                <button
                  type="button"
                  className=" bg-black text-white py-2 px-10  rounded-md flex items-center space-x-2 h-12"
                  style={{ backgroundColor: 'transparent !important', display: 'flex' }}
                  onClick={() => {
                    const shareText = `I've just made a reservation at ${getRestaurants().find(r => r.id === formData.restaurant_id)?.attributes.name}! Details: ${formData.covers} people, ${formData.booking_date.toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' })} @ ${new Date(formData.start_time).toLocaleTimeString('en-US', { hour: 'numeric', minute: '2-digit', hour12: true })}, ${getRestaurants().find(r => r.id === formData.restaurant_id)?.attributes.name}, ${restaurantAddress}`;
                    navigator.share({
                      title: `Reservation at ${getRestaurants().find(r => r.id === formData.restaurant_id)?.attributes.name}`,
                      text: shareText
                    });
                  }}
                >
                  <span className="text-primary">Share with others</span>
                </button>
              </div>


            </div>
          </div>
        </section>
      )}
    </div>
  );
};

export default ReservationsEatApp;
