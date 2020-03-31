<?php
namespace Sku;

use Macaroons\Utils;
use Macaroons\Macaroon;
use Macaroons\Packet;

class Sku
{
    private static function getHost()
    {
        return isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '';
    }

    public static function generateSKUToken($secret, $sku, $amount, $currency, $description, $expiry)
    {
        $identifier = "Brave SKU v1.0";
        // Current website or variable representing the website
        $location = Sku::getHost();

        $m = new Macaroon($secret, $identifier, $location);
    
        $m->addFirstPartyCaveat('sku = ' . $sku);
        $m->addFirstPartyCaveat('amount = ' . $amount);
        $m->addFirstPartyCaveat('currency = ' . $currency);
        $m->addFirstPartyCaveat('description = ' . $description);
        $m->addFirstPartyCaveat('expiry = ' . $expiry);

        return $m;
    }

    private static function sendResponse($status, $message)
    {
        $response = [
            'status' => $status,
            'message' => $message
        ];
        return $response;
    }

    public static function validateOrderStatus($orderId)
    {
        $location = Sku::getHost();
        $url = "https://grant.rewards.brave.software/v1/orders/" . $orderId;
        $response = file_get_contents($url);
        $json = json_decode(strval($response));

        if ($json->{'status'} != 'paid') {
            return Sku::sendResponse(false, "Payment status is ". $json->{'status'});
        }
        if ($json->{'location'} != $location) {
            return Sku::sendResponse(false, "Payment location is invalid. Expected: ". $location . " Actual: " . $json->{'location'});
        }
        return Sku::sendResponse(true, "");
    }
}
?>
