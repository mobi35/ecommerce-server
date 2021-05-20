<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ImagesForProduct extends Model
{
    //
    protected $fillable = [
        'image_name',
        'cover',
        'product_variation_id'
    ];


    public function productVariation(){
        return $this->belongsTo(ProductVariation::class,'product_variation_id','id');
    }
}
