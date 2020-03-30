<?php
namespace Sku;

use Macaroons\Utils;
use Macaroons\Macaroon;
use Macaroons\Packet;

class Sku {
    public static function generateSKUToken($secret, $sku, $amount, $currency, $description, $expiry) {
       $identifier = "Brave SKU v1.0";
       // Current website or variable representing the website
       $location = $_SERVER['HTTP_HOST'];

       $m = new Macaroon($secret, $identifier, $location);

       $m->addFirstPartyCaveat('sku = ' . $sku);
       $m->addFirstPartyCaveat('amount = ' . $amount);
       $m->addFirstPartyCaveat('currency = ' . $currency);
       $m->addFirstPartyCaveat('description = ' . $description);
       $m->addFirstPartyCaveat('expiry = ' . $expiry);

       return $m;
    }
}
?>
