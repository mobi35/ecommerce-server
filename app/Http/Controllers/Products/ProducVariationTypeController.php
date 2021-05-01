<?php

namespace App\Http\Controllers\Products;

use App\Models\Product;
use App\Models\ProductVariation;
use App\Models\Category;
use App\Http\Requests\Products\ProductRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductIndexResource;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ProductAddResource;
use App\Scoping\Scopes\CategoryScope;

class ProducVariationTypeController extends Controller
{
    public function index(){
        $productVariation = ProductVariation::with(['variations.stock'])->withScopes($this->scopes())->paginate(10);

        return ProductResource::collection($products);
    }

  

  
}
