<?php

namespace App\Http\Controllers\Products;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\ImagesForProduct;
use App\Models\ProductVariation;
use App\Http\Controllers\Controller;

use App\Models\ProductVariationType;
use App\Http\Resources\ImagesProductResource;
use App\Http\Resources\ProductVariationTypeResource;

class ImageController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt.admin')->except(['index','show']);
    }

    public function index(){
        $images = ImagesForProduct::get();
        return ImagesProductResource::collection($images);
    }

    public function store(Request $request){

       $varType = ImagesForProduct::create($request->only('name','image_name','product_variation_id',''));
       return new ImagesProductResource($varType);
    }
    public function destroy($id){
        ImagesForProduct::find($id)->delete();
        return "deleted";
    }
}
