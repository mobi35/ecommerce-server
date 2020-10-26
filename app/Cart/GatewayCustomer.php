<?php


namespace App\Cart;

use App\Models\PaymentMethod;
interface GatewayCustomer
{
    public function charge(PaymentMethod $card, $amount);
    public function addCard($token);
    public function id();
}
