<?php

require_once _PS_MODULE_DIR_ . 'frakintegration/classes/FrakWebhookHelper.php';

class AdminFrakIntegrationController extends ModuleAdminController
{
    public function __construct()
    {
        $this->bootstrap = true;
        $this->display = 'view';
        parent::__construct();
        $this->meta_title = $this->l('Frak Integration');
    }

    public function renderView()
    {
        $productId = FrakWebhookHelper::getProductId();
        $modal_i18n_raw = Configuration::get('FRAK_MODAL_I18N');
        $modal_i18n = json_decode($modal_i18n_raw, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            $modal_i18n = [];
        }
        $this->context->smarty->assign([
            'module_dir' => $this->module->getPathUri(),
            'form_action' => $this->context->link->getAdminLink('AdminFrakIntegration'),
            'floating_button_enabled' => Configuration::get('FRAK_FLOATING_BUTTON_ENABLED'),
            'floating_button_position' => Configuration::get('FRAK_FLOATING_BUTTON_POSITION'),
            'sharing_button_enabled' => Configuration::get('FRAK_SHARING_BUTTON_ENABLED'),
            'sharing_button_text' => Configuration::get('FRAK_SHARING_BUTTON_TEXT'),
            'shop_name' => Configuration::get('FRAK_SHOP_NAME'),
            'logo_url' => Configuration::get('FRAK_LOGO_URL'),
            'modal_lng' => Configuration::get('FRAK_MODAL_LNG'),
            'modal_i18n' => $modal_i18n,
            'webhook_status' => $this->getWebhookStatus($productId),
            'webhook_secret' => Configuration::get('FRAK_WEBHOOK_SECRET'),
            'frak_product_url' => 'https://business.frak.id/product/' . $productId,
        ]);

        return $this->context->smarty->fetch($this->getTemplatePath() . 'configure.tpl');
    }

    public function postProcess()
    {
        if (Tools::isSubmit('submitFrakButtons')) {
            $floatingButtonEnabled = (bool)Tools::getValue('FRAK_FLOATING_BUTTON_ENABLED');
            $floatingButtonPosition = strval(Tools::getValue('FRAK_FLOATING_BUTTON_POSITION'));
            $sharingButtonEnabled = (bool)Tools::getValue('FRAK_SHARING_BUTTON_ENABLED');
            $sharingButtonText = strval(Tools::getValue('FRAK_SHARING_BUTTON_TEXT'));

            Configuration::updateValue('FRAK_FLOATING_BUTTON_ENABLED', $floatingButtonEnabled);
            Configuration::updateValue('FRAK_FLOATING_BUTTON_POSITION', $floatingButtonPosition);
            Configuration::updateValue('FRAK_SHARING_BUTTON_ENABLED', $sharingButtonEnabled);
            Configuration::updateValue('FRAK_SHARING_BUTTON_TEXT', $sharingButtonText);
            $this->confirmations[] = $this->l('Buttons settings updated');
        }

        if (Tools::isSubmit('submitFrakModal')) {
            $shopName = strval(Tools::getValue('FRAK_SHOP_NAME'));
            $logoUrl = strval(Tools::getValue('FRAK_LOGO_URL'));
            $modalLng = strval(Tools::getValue('FRAK_MODAL_LNG'));
            $modalI18n = Tools::getValue('FRAK_MODAL_I18N');

            if (!is_array($modalI18n)) {
                $modalI18n = [];
            }

            $filteredModalI18n = array_filter($modalI18n, function($value) {
                return $value !== '';
            });

            if (isset($filteredModalI18n['sdk.wallet.login.text_sharing'])) {
                $filteredModalI18n['sdk.wallet.login.text'] = $filteredModalI18n['sdk.wallet.login.text_sharing'];
            }

            $modalI18nJson = json_encode($filteredModalI18n);

            if ($modalI18nJson === false) {
                $this->errors[] = $this->l('Invalid i18n data');
            }

            if (!$shopName || empty($shopName) || !Validate::isGenericName($shopName)) {
                $this->errors[] = $this->l('Invalid Shop Name');
            } elseif (!$logoUrl || empty($logoUrl) || !Validate::isUrl($logoUrl)) {
                $this->errors[] = $this->l('Invalid Logo URL');
            } elseif (empty($this->errors)) {
                Configuration::updateValue('FRAK_SHOP_NAME', $shopName);
                Configuration::updateValue('FRAK_LOGO_URL', $logoUrl);
                Configuration::updateValue('FRAK_MODAL_LNG', $modalLng);
                Configuration::updateValue('FRAK_MODAL_I18N', $modalI18nJson, true);
                $this->confirmations[] = $this->l('Modal settings updated');
            }
        }

        if (Tools::isSubmit('generateFrakWebhookSecret')) {
            Configuration::updateValue('FRAK_WEBHOOK_SECRET', Tools::passwdGen(32));
            $this->confirmations[] = $this->l('New webhook secret generated');
        }
    }

    private function getWebhookStatus($productId)
    {
        global $config;
        $url = 'https://backend.frak.id/business/product/' . $productId . '/oracleWebhook/status';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        $data = json_decode($response, true);
        return isset($data['setup']) && $data['setup'];
    }
}
