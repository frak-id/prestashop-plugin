<script src="https://cdn.jsdelivr.net/npm/@frak-labs/components" defer="defer"></script>
<script type="text/javascript">
  // Precompute a few stuff
  let logoUrl = '{$logo_url}';
  const lang = '{$modal_lng}' === 'default' ? undefined : '{$modal_lng}';

  // Get i18n customizations from config
  let customI18n = {};
  try {
    customI18n = JSON.parse('{$modal_i18n}');
  } catch (error) {
    console.error('Error parsing i18n customizations:', error);
  }

  // Top level Frak SDK config
  const frakConfig = {
    walletUrl: 'https://wallet.frak.id',
    metadata: {
      // Your app name (will be displayed on some modals and in the SSO)
      name: '{$shop_name}',
      // You can also setup custom styles here
      lang,
      logoUrl,
    },
    customizations: {
      css: "{$css_url}",
      i18n: customI18n,
    },
    domain: window.location.host,
  };

  // Base config for the modals (not rly used for client side stuff)
  const baseModalConfig = {
    login: {
      allowSso: true,
      ssoMetadata: {
        logoUrl,
        homepageLink: window.location.host,
      },
    },
  };

  // Sharing config 
  const sharingConfig = { link: window.location.href };

  const modalWalletConfig = {
    metadata: {
      position: 'bottom-right',
    },
  };

  window.FrakSetup = {
    config: frakConfig,
    modalConfig: baseModalConfig,
    modalShareConfig: sharingConfig,
    modalWalletConfig,
  };
</script>
