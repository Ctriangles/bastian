/**
 * Reusable validation utilities for the Bastian reservation system
 */

// Email validation regex
const EMAIL_REGEX = /^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,}$/i;

// Phone validation regex (10 digits)
const PHONE_REGEX = /^[0-9]{10}$/;

// Name validation regex (letters and spaces only)
const NAME_REGEX = /^[A-Za-z\s]{2,50}$/;

/**
 * Validate email address
 * @param {string} email - Email to validate
 * @returns {object} - {isValid: boolean, error: string}
 */
export const validateEmail = (email) => {
  if (!email) {
    return { isValid: false, error: "Email is required" };
  }
  if (!EMAIL_REGEX.test(email)) {
    return { isValid: false, error: "Please enter a valid email address" };
  }
  return { isValid: true, error: "" };
};

/**
 * Validate phone number
 * @param {string} phone - Phone number to validate
 * @returns {object} - {isValid: boolean, error: string}
 */
export const validatePhone = (phone) => {
  if (!phone) {
    return { isValid: false, error: "Phone number is required" };
  }
  const cleanPhone = phone.replace(/\D/g, '');
  if (!PHONE_REGEX.test(cleanPhone)) {
    return { isValid: false, error: "Please enter a valid 10-digit phone number" };
  }
  return { isValid: true, error: "" };
};

/**
 * Validate name (first name or last name)
 * @param {string} name - Name to validate
 * @param {string} fieldName - Field name for error message
 * @returns {object} - {isValid: boolean, error: string}
 */
export const validateName = (name, fieldName = "Name") => {
  if (!name) {
    return { isValid: false, error: `${fieldName} is required` };
  }
  if (name.length < 2) {
    return { isValid: false, error: `${fieldName} must be at least 2 characters long` };
  }
  if (!NAME_REGEX.test(name)) {
    return { isValid: false, error: `${fieldName} can only contain letters and spaces` };
  }
  return { isValid: true, error: "" };
};

/**
 * Validate required field
 * @param {any} value - Value to validate
 * @param {string} fieldName - Field name for error message
 * @returns {object} - {isValid: boolean, error: string}
 */
export const validateRequired = (value, fieldName) => {
  if (!value || (typeof value === 'string' && value.trim() === '')) {
    return { isValid: false, error: `${fieldName} is required` };
  }
  return { isValid: true, error: "" };
};

/**
 * Validate date (must be today or future)
 * @param {Date} date - Date to validate
 * @returns {object} - {isValid: boolean, error: string}
 */
export const validateDate = (date) => {
  if (!date) {
    return { isValid: false, error: "Date is required" };
  }
  
  const today = new Date();
  today.setHours(0, 0, 0, 0);
  const selectedDate = new Date(date);
  selectedDate.setHours(0, 0, 0, 0);
  
  if (selectedDate < today) {
    return { isValid: false, error: "Please select today's date or a future date" };
  }
  
  return { isValid: true, error: "" };
};

/**
 * Validate number of guests/covers
 * @param {number|string} covers - Number of covers to validate
 * @returns {object} - {isValid: boolean, error: string}
 */
export const validateCovers = (covers) => {
  const numCovers = parseInt(covers);
  if (!covers || isNaN(numCovers)) {
    return { isValid: false, error: "Number of guests is required" };
  }
  if (numCovers < 1 || numCovers > 20) {
    return { isValid: false, error: "Number of guests must be between 1 and 20" };
  }
  return { isValid: true, error: "" };
};

/**
 * Sanitize input by removing potentially harmful characters
 * @param {string} input - Input to sanitize
 * @returns {string} - Sanitized input
 */
export const sanitizeInput = (input) => {
  if (typeof input !== 'string') return input;
  
  // Remove HTML tags and potentially harmful characters
  return input
    .replace(/<[^>]*>/g, '') // Remove HTML tags
    .replace(/[<>'"&]/g, '') // Remove potentially harmful characters
    .trim();
};

/**
 * Format phone number for display
 * @param {string} phone - Phone number to format
 * @returns {string} - Formatted phone number
 */
export const formatPhone = (phone) => {
  const cleanPhone = phone.replace(/\D/g, '');
  if (cleanPhone.length === 10) {
    return `(${cleanPhone.slice(0, 3)}) ${cleanPhone.slice(3, 6)}-${cleanPhone.slice(6)}`;
  }
  return phone;
};

/**
 * Comprehensive form validation for reservation data
 * @param {object} formData - Form data to validate
 * @param {boolean} requireRecaptcha - Whether reCAPTCHA is required
 * @returns {object} - {isValid: boolean, errors: object}
 */
export const validateReservationForm = (formData, requireRecaptcha = true) => {
  const errors = {};
  let isValid = true;

  // Validate restaurant selection
  const restaurantValidation = validateRequired(formData.restaurant_id, "Restaurant");
  if (!restaurantValidation.isValid) {
    errors.restaurant_id = restaurantValidation.error;
    isValid = false;
  }

  // Validate date
  const dateValidation = validateDate(formData.booking_date);
  if (!dateValidation.isValid) {
    errors.booking_date = dateValidation.error;
    isValid = false;
  }

  // Validate covers
  const coversValidation = validateCovers(formData.covers);
  if (!coversValidation.isValid) {
    errors.covers = coversValidation.error;
    isValid = false;
  }

  // Validate time slot
  const timeValidation = validateRequired(formData.start_time, "Time slot");
  if (!timeValidation.isValid) {
    errors.start_time = timeValidation.error;
    isValid = false;
  }

  // Validate first name
  const firstNameValidation = validateName(formData.first_name, "First name");
  if (!firstNameValidation.isValid) {
    errors.first_name = firstNameValidation.error;
    isValid = false;
  }

  // Validate last name
  const lastNameValidation = validateName(formData.last_name, "Last name");
  if (!lastNameValidation.isValid) {
    errors.last_name = lastNameValidation.error;
    isValid = false;
  }

  // Validate email
  const emailValidation = validateEmail(formData.email);
  if (!emailValidation.isValid) {
    errors.email = emailValidation.error;
    isValid = false;
  }

  // Validate phone
  const phoneValidation = validatePhone(formData.phone);
  if (!phoneValidation.isValid) {
    errors.phone = phoneValidation.error;
    isValid = false;
  }

  // Validate reCAPTCHA if required
  if (requireRecaptcha && !formData.recaptcha) {
    errors.recaptcha = "Please complete the reCAPTCHA verification";
    isValid = false;
  }

  return { isValid, errors };
};
