<?php

namespace App\Models;

use App\Cart\Money;
use App\Models\Collections\ProductVariationCollection;
use App\Models\Stock;
use App\Models\Product;

use App\Models\Traits\HasPrice;
use App\Models\ProductVariationType;
use Illuminate\Database\Eloquent\Model;

class ProductVariationOrder extends Model
{
    protected $table = 'product_variation_order';
    protected $fillable = [
        'order_id',
        'quantity',
        'product_variation_id'

    ];

    


}
