<?php

namespace App\Models;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Eloquent\Model;

class CategoryProduct extends Model
{
    public $timestamps = false;
    protected $table = 'category_product';
}
