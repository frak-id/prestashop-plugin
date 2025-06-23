<?php
if (!defined('_PS_VERSION_')) {
    exit;
}

class FrakIntegration extends Module
{
    public function __construct()
    {
        $this->name = 'frakintegration';
        $this->tab = 'front_office_features';
        $this->version = '1.0.0';
        $this->author = 'Frak';
        $this->need_instance = 0;
        $this->ps_versions_compliancy = [
            'min' => '1.7',
            'max' => _PS_VERSION_
        ];
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('Frak Integration');
        $this->description = $this->l('Integrates Frak services with PrestaShop.');

        $this->confirmUninstall = $this->l('Are you sure you want to uninstall?');
    }

    public function install()
    {
        if (parent::install() &&
            $this->registerHook('header') &&
            $this->registerHook('displayBeforeBodyClosingTag') &&
            $this->registerHook('displayFooter') &&
            $this->registerHook('displayProductAdditionalInfo')) {
            Configuration::updateValue('FRAK_SHOP_NAME', Configuration::get('PS_SHOP_NAME'));
            Configuration::updateValue('FRAK_LOGO_URL', $this->context->link->getMediaLink(_PS_IMG_ . Configuration::get('PS_LOGO')));
            Configuration::updateValue('FRAK_MODAL_LNG', 'default');
            Configuration::updateValue('FRAK_MODAL_I18N', '{}', true);
            return true;
        }
        return false;
    }

    public function uninstall()
    {
        if (parent::uninstall() &&
            $this->unregisterHook('header') &&
            $this->unregisterHook('displayBeforeBodyClosingTag') &&
            $this->unregisterHook('displayFooter') &&
            $this->unregisterHook('displayProductAdditionalInfo')) {
            Configuration::deleteByName('FRAK_SHOP_NAME');
            Configuration::deleteByName('FRAK_LOGO_URL');
            Configuration::deleteByName('FRAK_MODAL_LNG');
            Configuration::deleteByName('FRAK_MODAL_I18N');
            return true;
        }
        return false;
    }

    public function hookHeader()
    {
        $this->context->controller->addJS('https://cdn.jsdelivr.net/npm/@frak-labs/components', null, ['defer' => true]);

        $this->context->smarty->assign([
            'shop_name' => Configuration::get('FRAK_SHOP_NAME'),
            'logo_url' => Configuration::get('FRAK_LOGO_URL'),
            'modal_lng' => Configuration::get('FRAK_MODAL_LNG'),
            'modal_i18n' => Configuration::get('FRAK_MODAL_I18N'),
            'css_url' => $this->_path . 'views/css/customizations.css',
        ]);

        return $this->display(__FILE__, 'views/templates/hook/head.tpl');
    }

    public function hookDisplayBeforeBodyClosingTag()
    {
        if ($this->context->controller->php_self == 'order-confirmation') {
            $this->context->controller->addJS($this->_path . 'views/js/post-checkout.js');
        }
    }

    public function hookDisplayFooter()
    {
        return $this->display(__FILE__, 'views/templates/hook/floatingButton.tpl');
    }

    public function hookDisplayProductAdditionalInfo()
    {
        return $this->display(__FILE__, 'views/templates/hook/sharingButton.tpl');
    }

    public function getContent()
    {
        require_once dirname(__FILE__) . '/classes/FrakIntegrationAdmin.php';
        $admin = new FrakIntegrationAdmin($this);
        $output = $admin->processForm();
        if (Tools::isSubmit('submit' . $this->name)) {
            Tools::redirectAdmin($this->context->link->getAdminLink('AdminModules') . '&configure=' . $this->name . '&conf=4');
        }
        return $output;
    }


}
