<?php
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
        $this->context->smarty->assign([
            'module_dir' => $this->module->getPathUri(),
            'form_action' => $this->context->link->getAdminLink('AdminFrakIntegration'),
            'shop_name' => Configuration::get('FRAK_SHOP_NAME'),
            'logo_url' => Configuration::get('FRAK_LOGO_URL'),
            'modal_lng' => Configuration::get('FRAK_MODAL_LNG'),
            'modal_i18n' => Configuration::get('FRAK_MODAL_I18N'),
        ]);

        return $this->context->smarty->fetch($this->getTemplatePath() . 'configure.tpl');
    }

    public function postProcess()
    {
        if (Tools::isSubmit('submitFrakIntegration')) {
            $shopName = strval(Tools::getValue('FRAK_SHOP_NAME'));
            $logoUrl = strval(Tools::getValue('FRAK_LOGO_URL'));
            $modalLng = strval(Tools::getValue('FRAK_MODAL_LNG'));
            $modalI18n = strval(Tools::getValue('FRAK_MODAL_I18N'));

            if (!$shopName || empty($shopName) || !Validate::isGenericName($shopName)) {
                $this->errors[] = $this->l('Invalid Shop Name');
            } elseif (!$logoUrl || empty($logoUrl) || !Validate::isUrl($logoUrl)) {
                $this->errors[] = $this->l('Invalid Logo URL');
            } elseif (!empty($modalI18n) && !json_decode($modalI18n)) {
                $this->errors[] = $this->l('Invalid i18n JSON');
            } else {
                Configuration::updateValue('FRAK_SHOP_NAME', $shopName);
                Configuration::updateValue('FRAK_LOGO_URL', $logoUrl);
                Configuration::updateValue('FRAK_MODAL_LNG', $modalLng);
                Configuration::updateValue('FRAK_MODAL_I18N', $modalI18n, true);
                $this->confirmations[] = $this->l('Settings updated');
            }
        }
    }
}
