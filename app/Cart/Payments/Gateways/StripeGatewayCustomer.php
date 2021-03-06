<?php


namespace App\Cart\Payments\Gateways;

use App\Cart\GatewayCustomer;
use App\Models\PaymentMethod;
use App\Cart\Payments\Gateway;
use App\Exceptions\PaymentFailedException;
use Exception;
use Stripe\Customer as StripeCustomer;
use Stripe\Charge as StripeCharge;
class StripeGatewayCustomer implements GatewayCustomer{

    protected $gateway;
    protected $customer;
    public function __construct(Gateway $gateway, StripeCustomer $customer)
    {
        $this->gateway = $gateway;
        $this->customer = $customer;
    }

    public function charge(PaymentMethod $card, $amount)
    {
        try{
        StripeCharge::create([
            'currency' => 'PHP',
            'amount' => $amount,
            'customer' => $this->customer->id,
            'source' => $card->provider_id
        ]);
        }
        catch(Exception $e){
            throw new PaymentFailedException();
        }

    }

    public function addCard($token)
    {


    $card = $this->customer->createSource(
        $this->customer->id,
        [
            'source' => $token,
        ]
        );


        $this->customer->default_source = $card->id;
        $this->customer->save();

          return  $this->gateway->user()->paymentMethods()->create([

                    'provider_id' => $card->id,
                    'card_type' => $card->brand,
                    'last_four' => $card->last4,
                    'default' => true
                ]);




    }

    public function id(){
        return $this->customer->id;
    }

}
