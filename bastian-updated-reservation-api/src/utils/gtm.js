import TagManager from 'react-gtm-module';

export const initGTM = () => {
  const tagManagerArgs = {
    gtmId: 'GTM-MS9PHFRP', // Replace with your actual GTM ID if different
  };

  TagManager.initialize(tagManagerArgs);
};
