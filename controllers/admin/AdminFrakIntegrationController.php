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
        $this->context->smarty->assign([
            'module_dir' => $this->module->getPathUri(),
            'form_action' => $this->context->link->getAdminLink('AdminFrakIntegration'),
            'hooks_enabled' => Configuration::get('FRAK_HOOKS_ENABLED'),
            'shop_name' => Configuration::get('FRAK_SHOP_NAME'),
            'logo_url' => Configuration::get('FRAK_LOGO_URL'),
            'modal_lng' => Configuration::get('FRAK_MODAL_LNG'),
            'modal_i18n' => Configuration::get('FRAK_MODAL_I18n'),
            'webhook_status' => $this->getWebhookStatus($productId),
            'product_id' => $productId,
            'webhook_secret' => Configuration::get('FRAK_WEBHOOK_SECRET'),
        ]);

        return $this->context->smarty->fetch($this->getTemplatePath() . 'configure.tpl');
    }

    public function postProcess()
    {
        if (Tools::isSubmit('submitFrakIntegration')) {
            $hooksEnabled = (bool)Tools::getValue('FRAK_HOOKS_ENABLED');
            $shopName = strval(Tools::getValue('FRAK_SHOP_NAME'));
            $logoUrl = strval(Tools::getValue('FRAK_LOGO_URL'));
            $modalLng = strval(Tools::getValue('FRAK_MODAL_LNG'));
            $modalI18n = strval(Tools::getValue('FRAK_MODAL_I18N'));
            $webhookSecret = strval(Tools::getValue('FRAK_WEBHOOK_SECRET'));

            if (!$shopName || empty($shopName) || !Validate::isGenericName($shopName)) {
                $this->errors[] = $this->l('Invalid Shop Name');
            } elseif (!$logoUrl || empty($logoUrl) || !Validate::isUrl($logoUrl)) {
                $this->errors[] = $this->l('Invalid Logo URL');
            } elseif (!empty($modalI18n) && !json_decode($modalI18n)) {
                $this->errors[] = $this->l('Invalid i18n JSON');
            } else {
                Configuration::updateValue('FRAK_HOOKS_ENABLED', $hooksEnabled);
                Configuration::updateValue('FRAK_SHOP_NAME', $shopName);
                Configuration::updateValue('FRAK_LOGO_URL', $logoUrl);
                Configuration::updateValue('FRAK_MODAL_LNG', $modalLng);
                Configuration::updateValue('FRAK_MODAL_I18N', $modalI18n, true);
                Configuration::updateValue('FRAK_WEBHOOK_SECRET', $webhookSecret);
                $this->confirmations[] = $this->l('Settings updated');
            }
        }

        if (Tools::isSubmit('submitFrakWebhook')) {
            $this->setupWebhook();
        }

        if (Tools::isSubmit('submitFrakWebhookDelete')) {
            $this->deleteWebhook();
        }

        if (Tools::isSubmit('generateFrakWebhookSecret')) {
            Configuration::updateValue('FRAK_WEBHOOK_SECRET', Tools::passwdGen(32));
            $this->confirmations[] = $this->l('New webhook secret generated');
        }
    }

    private function getWebhookStatus($productId)
    {
        $url = '%%BACKEND_URL%%' . '/business/product/' . $productId . '/oracleWebhook/status';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        $data = json_decode($response, true);
        return isset($data['setup']) && $data['setup'];
    }

    private function setupWebhook()
    {
        $productId = FrakWebhookHelper::getProductId();
        $url = '%%BACKEND_URL%%' . '/business/product/' . $productId . '/oracleWebhook';
        $body = [
            'url' => $this->context->link->getModuleLink('frakintegration', 'webhook'),
            'events' => ['order.created']
        ];
        $jsonBody = json_encode($body);
        $signature = hash_hmac('sha256', $jsonBody, Configuration::get('FRAK_WEBHOOK_SECRET'));

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonBody);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'x-hmac-sha256: ' . $signature
        ]);

        $response = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpcode == 200) {
            $this->confirmations[] = $this->l('Webhook created successfully');
        } else {
            $this->errors[] = $this->l('Error creating webhook: ') . $response;
        }
    }

    private function deleteWebhook()
    {
        $productId = FrakWebhookHelper::getProductId();
        $url = '%%BACKEND_URL%%' . '/business/product/' . $productId . '/oracleWebhook';
        $signature = hash_hmac('sha256', '', Configuration::get('FRAK_WEBHOOK_SECRET'));

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'x-hmac-sha256: ' . $signature
        ]);

        $response = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpcode == 200) {
            $this->confirmations[] = $this->l('Webhook deleted successfully');
        } else {
            $this->errors[] = $this->l('Error deleting webhook: ') . $response;
        }
    }
}
