<?php

namespace App\Http\Controllers\Products;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\ProductVariation;
use App\Http\Controllers\Controller;
use App\Models\ProductVariationType;

use App\Http\Resources\ProductVariationTypeResource;
use Exception;
class ProductVariationTypeController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt.admin')->except(['index','show']);
    }

    public function index(){
        $productVariation = ProductVariationType::get();
        return ProductVariationTypeResource::collection($productVariation);
    }

    public function store(Request $request){

       $varType = ProductVariationType::create($request->only('name'));
       return new ProductVariationTypeResource($varType);
    }
    public function destroy($id){
        ProductVariationType::find($id)->delete();
        return "deleted";
    }
}
