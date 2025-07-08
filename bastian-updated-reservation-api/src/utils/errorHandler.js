/**
 * Centralized error handling utilities for the Bastian reservation system
 */

/**
 * Error types for better categorization
 */
export const ERROR_TYPES = {
  VALIDATION: 'validation',
  NETWORK: 'network',
  API: 'api',
  AUTHENTICATION: 'authentication',
  AUTHORIZATION: 'authorization',
  SERVER: 'server',
  UNKNOWN: 'unknown'
};

/**
 * HTTP status code to error type mapping
 */
const STATUS_CODE_MAP = {
  400: ERROR_TYPES.VALIDATION,
  401: ERROR_TYPES.AUTHENTICATION,
  403: ERROR_TYPES.AUTHORIZATION,
  404: ERROR_TYPES.API,
  422: ERROR_TYPES.VALIDATION,
  429: ERROR_TYPES.API,
  500: ERROR_TYPES.SERVER,
  502: ERROR_TYPES.SERVER,
  503: ERROR_TYPES.SERVER,
  504: ERROR_TYPES.SERVER
};

/**
 * User-friendly error messages
 */
const ERROR_MESSAGES = {
  [ERROR_TYPES.VALIDATION]: "Please check your input and try again.",
  [ERROR_TYPES.NETWORK]: "Please check your internet connection and try again.",
  [ERROR_TYPES.API]: "Service temporarily unavailable. Please try again later.",
  [ERROR_TYPES.AUTHENTICATION]: "Authentication failed. Please refresh the page.",
  [ERROR_TYPES.AUTHORIZATION]: "You don't have permission to perform this action.",
  [ERROR_TYPES.SERVER]: "Server error. Please try again later.",
  [ERROR_TYPES.UNKNOWN]: "An unexpected error occurred. Please try again."
};

/**
 * Parse and categorize API errors
 * @param {Error} error - The error object from axios or other sources
 * @returns {object} - Parsed error information
 */
export const parseError = (error) => {
  // Default error structure
  const parsedError = {
    type: ERROR_TYPES.UNKNOWN,
    message: ERROR_MESSAGES[ERROR_TYPES.UNKNOWN],
    details: null,
    statusCode: null,
    originalError: error
  };

  // Handle network errors
  if (!error.response && error.request) {
    parsedError.type = ERROR_TYPES.NETWORK;
    parsedError.message = ERROR_MESSAGES[ERROR_TYPES.NETWORK];
    return parsedError;
  }

  // Handle API response errors
  if (error.response) {
    const { status, data } = error.response;
    parsedError.statusCode = status;
    parsedError.type = STATUS_CODE_MAP[status] || ERROR_TYPES.UNKNOWN;

    // Handle specific error cases
    switch (status) {
      case 400:
        if (data?.message?.includes('partner')) {
          parsedError.message = "Please select a restaurant to make a reservation.";
        } else {
          parsedError.message = data?.message || ERROR_MESSAGES[ERROR_TYPES.VALIDATION];
        }
        break;

      case 422:
        if (data?.validations && Array.isArray(data.validations)) {
          const validationErrors = data.validations
            .map(v => `${v.key}: ${v.message}`)
            .join(', ');
          parsedError.message = validationErrors;
          parsedError.details = data.validations;
        } else {
          parsedError.message = "Please check your reservation details.";
        }
        break;

      case 429:
        parsedError.message = "Too many requests. Please wait a moment and try again.";
        break;

      default:
        parsedError.message = data?.message || ERROR_MESSAGES[parsedError.type];
    }
  }

  return parsedError;
};

/**
 * Handle reservation-specific errors
 * @param {Error} error - The error object
 * @returns {string} - User-friendly error message
 */
export const handleReservationError = (error) => {
  const parsedError = parseError(error);
  
  // Log error for debugging (in development)
  if (import.meta.env.DEV) {
    console.error('Reservation Error:', {
      type: parsedError.type,
      message: parsedError.message,
      statusCode: parsedError.statusCode,
      details: parsedError.details,
      originalError: error
    });
  }

  return parsedError.message;
};

/**
 * Handle API errors with retry logic
 * @param {Error} error - The error object
 * @param {number} retryCount - Current retry count
 * @param {number} maxRetries - Maximum number of retries
 * @returns {object} - Error handling result
 */
export const handleAPIError = (error, retryCount = 0, maxRetries = 3) => {
  const parsedError = parseError(error);
  
  // Determine if error is retryable
  const retryableTypes = [ERROR_TYPES.NETWORK, ERROR_TYPES.SERVER];
  const retryableStatusCodes = [500, 502, 503, 504];
  
  const shouldRetry = (
    retryCount < maxRetries &&
    (
      retryableTypes.includes(parsedError.type) ||
      (parsedError.statusCode && retryableStatusCodes.includes(parsedError.statusCode))
    )
  );

  return {
    error: parsedError,
    shouldRetry,
    retryAfter: shouldRetry ? Math.min(1000 * Math.pow(2, retryCount), 10000) : 0 // Exponential backoff
  };
};

/**
 * Create a standardized error response
 * @param {string} message - Error message
 * @param {string} type - Error type
 * @param {any} details - Additional error details
 * @returns {object} - Standardized error object
 */
export const createError = (message, type = ERROR_TYPES.UNKNOWN, details = null) => {
  return {
    type,
    message,
    details,
    timestamp: new Date().toISOString()
  };
};

/**
 * Validate and sanitize error messages for display
 * @param {string} message - Error message to sanitize
 * @returns {string} - Sanitized error message
 */
export const sanitizeErrorMessage = (message) => {
  if (typeof message !== 'string') {
    return ERROR_MESSAGES[ERROR_TYPES.UNKNOWN];
  }

  // Remove potentially harmful content
  const sanitized = message
    .replace(/<[^>]*>/g, '') // Remove HTML tags
    .replace(/[<>'"&]/g, '') // Remove potentially harmful characters
    .trim();

  // Ensure message is not empty
  return sanitized || ERROR_MESSAGES[ERROR_TYPES.UNKNOWN];
};

/**
 * Error boundary helper for React components
 * @param {Error} error - The error that occurred
 * @param {object} errorInfo - Additional error information
 */
export const logError = (error, errorInfo = {}) => {
  const errorData = {
    message: error.message,
    stack: error.stack,
    timestamp: new Date().toISOString(),
    userAgent: navigator.userAgent,
    url: window.location.href,
    ...errorInfo
  };

  // In development, log to console
  if (import.meta.env.DEV) {
    console.error('Application Error:', errorData);
  }

  // In production, you might want to send to an error tracking service
  // Example: sendToErrorTrackingService(errorData);
};

/**
 * Retry function with exponential backoff
 * @param {Function} fn - Function to retry
 * @param {number} maxRetries - Maximum number of retries
 * @param {number} baseDelay - Base delay in milliseconds
 * @returns {Promise} - Promise that resolves with the function result
 */
export const retryWithBackoff = async (fn, maxRetries = 3, baseDelay = 1000) => {
  let lastError;

  for (let i = 0; i <= maxRetries; i++) {
    try {
      return await fn();
    } catch (error) {
      lastError = error;
      
      if (i === maxRetries) {
        throw error;
      }

      const { shouldRetry, retryAfter } = handleAPIError(error, i, maxRetries);
      
      if (!shouldRetry) {
        throw error;
      }

      // Wait before retrying
      await new Promise(resolve => setTimeout(resolve, retryAfter || baseDelay * Math.pow(2, i)));
    }
  }

  throw lastError;
};
