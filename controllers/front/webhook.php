<?php

class FrakIntegrationWebhookModuleFrontController extends ModuleFrontController
{
    public function postProcess()
    {
        $signature = $_SERVER['HTTP_X_HMAC_SHA256'];
        $body = file_get_contents('php://input');
        $expectedSignature = hash_hmac('sha256', $body, Configuration::get('FRAK_WEBHOOK_SECRET'));

        if (!hash_equals($expectedSignature, $signature)) {
            http_response_code(401);
            exit;
        }

        $data = json_decode($body, true);

        if ($data['event'] === 'order.created') {
            // Process the order created event
        }

        http_response_code(200);
        exit;
    }
}
