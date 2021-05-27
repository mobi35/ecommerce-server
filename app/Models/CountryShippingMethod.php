<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CountryShippingMethod extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'country_id',
        'shipping_method_id'
    ];
    protected $table = 'country_shipping_method';
}
