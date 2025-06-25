<?php
if (!defined('_PS_VERSION_')) {
    exit;
}

require_once __DIR__ . '/vendor/autoload.php';

$config = require __DIR__ . '/config.php';

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

        $this->displayName = $this->l('Frak');
        $this->description = $this->l('Integrates Frak services with PrestaShop.');

        $this->confirmUninstall = $this->l('Are you sure you want to uninstall?');
    }

    public function install()
    {
        if (parent::install() &&
            $this->registerHook('header') &&
            $this->registerHook('displayFooter') &&
            $this->registerHook('displayProductAdditionalInfo') &&
            $this->registerHook('displayOrderConfirmation') &&
            $this->registerHook('actionOrderStatusUpdate')) {
            Configuration::updateValue('FRAK_SHOP_NAME', Configuration::get('PS_SHOP_NAME'));
            Configuration::updateValue('FRAK_LOGO_URL', $this->context->link->getMediaLink(_PS_IMG_ . Configuration::get('PS_LOGO')));
            Configuration::updateValue('FRAK_MODAL_LNG', 'default');
            Configuration::updateValue('FRAK_MODAL_I18N', '{}', true);
            Configuration::updateValue('FRAK_FLOATING_BUTTON_ENABLED', true);
            Configuration::updateValue('FRAK_SHARING_BUTTON_ENABLED', true);
            Configuration::updateValue('FRAK_SHARING_BUTTON_TEXT', 'Share with Frak');
            return true;
        }
        return false;
    }

    public function uninstall()
    {
        if (parent::uninstall() &&
            $this->unregisterHook('header') &&
            $this->unregisterHook('displayFooter') &&
            $this->unregisterHook('displayOrderConfirmation') &&
            $this->unregisterHook('displayProductAdditionalInfo')) {
            Configuration::deleteByName('FRAK_SHOP_NAME');
            Configuration::deleteByName('FRAK_LOGO_URL');
            Configuration::deleteByName('FRAK_MODAL_LNG');
            Configuration::deleteByName('FRAK_MODAL_I18N');
            Configuration::deleteByName('FRAK_FLOATING_BUTTON_ENABLED');
            Configuration::deleteByName('FRAK_SHARING_BUTTON_ENABLED');
            Configuration::deleteByName('FRAK_SHARING_BUTTON_TEXT');
            return true;
        }
        return false;
    }

    public function hookHeader()
    {
        $this->context->smarty->assign([
            'shop_name' => Configuration::get('FRAK_SHOP_NAME'),
            'logo_url' => Configuration::get('FRAK_LOGO_URL'),
            'modal_lng' => Configuration::get('FRAK_MODAL_LNG'),
            'modal_i18n' => Configuration::get('FRAK_MODAL_I18N'),
            'css_url' => $this->_path . 'views/css/customizations.css',
            'backend_host' => $this->getBackendHost(),
        ]);

        return $this->display(__FILE__, 'views/templates/hook/head.tpl');
    }


    public function hookDisplayFooter()
    {
        if (!Configuration::get('FRAK_FLOATING_BUTTON_ENABLED')) {
            return;
        }
        return $this->display(__FILE__, 'views/templates/hook/floatingButton.tpl');
    }

    public function hookDisplayProductAdditionalInfo()
    {
        if (!Configuration::get('FRAK_SHARING_BUTTON_ENABLED')) {
            return;
        }
        $this->context->smarty->assign([
            'button_text' => Configuration::get('FRAK_SHARING_BUTTON_TEXT'),
        ]);
        return $this->display(__FILE__, 'views/templates/hook/sharingButton.tpl');
    }

    public function hookActionOrderStatusUpdate($params)
    {
        $new_status = $params['newOrderStatus'];
        $status_map = [
            (int)Configuration::get('PS_OS_PAYMENT') => 'confirmed',
            (int)Configuration::get('PS_OS_CANCELED') => 'cancelled',
            (int)Configuration::get('PS_OS_REFUND') => 'refunded',
        ];

        if (array_key_exists((int)$new_status->id, $status_map)) {
            FrakWebhookHelper::send($params['id_order'], $status_map[(int)$new_status->id]);
        }
    }

    public function hookDisplayOrderConfirmation($params)
    {
        $order = $params['order'];
        if (!$order) {
            return;
        }

        $this->context->smarty->assign([
            'customer_id' => $order->id_customer,
            'order_id' => $order->id,
            'token' => $order->secure_key,
        ]);

        $this->context->controller->addJS($this->_path . 'views/js/post-checkout.js');

        return $this->display(__FILE__, 'views/templates/hook/orderConfirmation.tpl');
    }


    public function getContent()
    {
        Tools::redirectAdmin($this->context->link->getAdminLink('AdminFrakIntegration'));
    }

    private function getBackendHost()
    {
        $env = getenv('FRAK_ENV');
        if ($env === 'dev') {
            return 'https://backend.dev.frak.id';
        }
        return 'https://backend.frak.id';
    }
}
