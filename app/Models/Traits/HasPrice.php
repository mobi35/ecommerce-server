<?php
namespace App\Models\Traits;
use App\Cart\Money;
use NumberFormatter;
use Money\Currencies\ISOCurrencies;
use Money\Formatter\IntlMoneyFormatter;
use Illuminate\Support\Str;

trait HasPrice{

    public function getPriceAttribute($value){

        return new Money($value);
    }

    public function getFormattedPriceAttribute(){
        return $this->price->formatted();
    }


    public function getNormalPriceAttribute(){
       // $converted = Str::substr('The Laravel Framework', 4, 7);
        return Str::substr( $this->price->amount() ,0,-2);
    }

}