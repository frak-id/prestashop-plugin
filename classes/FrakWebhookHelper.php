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

    private static function toHex($string)
    {
        $hex = '';
        for ($i=0; $i<strlen($string); $i++) {
            $hex .= dechex(ord($string[$i]));
        }
        return $hex;
    }
}
