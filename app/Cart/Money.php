<?php

namespace App\Cart;

use Money\Currency;
use NumberFormatter;
use Money\Money as BaseMoney;
use Money\Currencies\ISOCurrencies;
use Money\Formatter\IntlMoneyFormatter;

class Money{

public function __construct($value){
    $this->money = new BaseMoney($value, new Currency('USD'));
}

public function amount(){
    return $this->money->getAmount();
}

public function formatted(){
    $numberFormatter = new NumberFormatter('en_US', NumberFormatter::CURRENCY);
    $currencies = new ISOCurrencies();
  
    $formatter = new IntlMoneyFormatter(
      $numberFormatter,$currencies
    );

    return $formatter->format($this->money);
}

public function add(Money $money){

        $this->money = $this->money->add($money->instance());

        return $this;

}

public function instance(){
    return $this->money;
}
}