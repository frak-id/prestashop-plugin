<?php

use kornrunner\Keccak;

class FrakWebhookHelper
{
    public static function getProductId()
    {
        $domain = Tools::getShopDomain(true, true);
        $hash = Keccak::hash(self::toHex($domain), 256);
        return '0x' . $hash;
    }

    private static function getWebhookUrl()
    {
        global $config;
        $productId = self::getProductId();
        return $config['BACKEND_URL'] . '/ext/products/' . $productId . '/webhook/oracle/custom';
    }

    private static function toHex($string)
    {
        $hex = '';
        for ($i=0; $i<strlen($string); $i++) {
            $hex .= dechex(ord($string[$i]));
        }
        return $hex;
    }

    public static function send($order_id, $status)
    {
        $order = new Order($order_id);
        $cart = new Cart($order->id_cart);
        $customer = new Customer($order->id_customer);
        $currency = new Currency($order->id_currency);
        $products = $order->getProducts();

        $items = [];
        foreach ($products as $product) {
            $items[] = [
                'productId' => $product['product_id'],
                'quantity' => $product['product_quantity'],
                'price' => $product['unit_price_tax_incl'],
                'name' => $product['product_name'],
                'title' => $product['product_name'],
            ];
        }

        $body = [
            'id' => $order_id,
            'customerId' => $customer->id,
            'status' => $status,
            'token' => '',
            'currency' => $currency->iso_code,
            'totalPrice' => $order->total_paid_tax_incl,
            'items' => $items,
        ];

        $jsonBody = json_encode($body);
        $signature = hash_hmac('sha256', $jsonBody, Configuration::get('FRAK_WEBHOOK_SECRET'));

        $ch = curl_init(self::getWebhookUrl());
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonBody);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'x-hmac-sha256: ' . $signature,
        ]);

        curl_exec($ch);
        curl_close($ch);
    }
}
