<?php

class FrakIntegrationAdmin
{
    private $module;

    public function __construct($module)
    {
        $this->module = $module;
    }



    public function processForm()
    {
        $output = null;

        if (Tools::isSubmit('submit' . $this->module->name)) {
            $shopName = strval(Tools::getValue('FRAK_SHOP_NAME'));
            $logoUrl = strval(Tools::getValue('FRAK_LOGO_URL'));
            $modalLng = strval(Tools::getValue('FRAK_MODAL_LNG'));
            $modalI18n = strval(Tools::getValue('FRAK_MODAL_I18N'));

            if (!$shopName || empty($shopName) || !Validate::isGenericName($shopName)) {
                $output .= $this->module->displayError($this->module->l('Invalid Shop Name'));
            } elseif (!$logoUrl || empty($logoUrl) || !Validate::isUrl($logoUrl)) {
                $output .= $this->module->displayError($this->module->l('Invalid Logo URL'));
            } elseif (!empty($modalI18n) && !json_decode($modalI18n)) {
                $output .= $this->module->displayError($this->module->l('Invalid i18n JSON'));
            } else {
                Configuration::updateValue('FRAK_SHOP_NAME', $shopName);
                Configuration::updateValue('FRAK_LOGO_URL', $logoUrl);
                Configuration::updateValue('FRAK_MODAL_LNG', $modalLng);
                Configuration::updateValue('FRAK_MODAL_I18N', $modalI18n, true);
                $output .= $this->module->displayConfirmation($this->module->l('Settings updated'));
            }
        }

        return $output;
    }
}
