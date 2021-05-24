<?php

namespace App\Http\Controllers\Products;

use Exception;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\ImagesForProduct;
use App\Models\ProductVariation;

use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use App\Models\ProductVariationType;
use App\Http\Resources\ProductVariationResource;
use App\Http\Resources\ProductVariationTypeResource;
use App\Http\Resources\ProductVariationCustomResources;

class ProductVariationController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt.admin')->except(['index','show','getVariations']);
    }
    public function index(){
        $productVariation = ProductVariation::get();
        return ProductVariationResource::collection($productVariation);
    }

    public function show($id){
        $productVariation = ProductVariation::where('product_id',$id)->get();
        return ProductVariationResource::collection($productVariation);
    }

    public function edit($id){
        $productVariation = ProductVariation::where('id',$id)->get();
        return ProductVariationResource::collection($productVariation);

    }

    public function update(Request $request, $id){
        $price = $request->price . "00";
        ProductVariation::find($id)->fill(array_merge(['price' => $price] , $request->only('name','product_variation_type_id' )   ))->save();
        return "updated";
    }

    public function store(Request $request){

       

       $image = $request->file('file');
       $prod = Product::where('id',$request->product_id)->first();

         $prod->variations()->save(
             $variation = ProductVariation::create( $request->only('name','price','product_id','product_variation_type_id') )
          );

         $count = 0;
          foreach($image as $val){
             $imgName = time(). $val->getClientOriginalName();
             $val->move(public_path('uploads'), $imgName);
             $variation->images()->save(

                 $image = ImagesForProduct::create(
                     ['image_name' => $imgName ,
                     'product_variation_id' => $variation->id ,
                     'cover' => false]
                 )
             );
             $count++;
          } 

          return $image;
          return new ProductVariationResource($variation);
     }


    public function destroy($id){
        ImagesForProduct::where('product_variation_id',$id)->delete();
        ProductVariation::find($id)->delete();
        return "deleted";
    }

    public function getVariations(Request $request){
        $test = Product::where('slug',$request->slug)->first();
        $productVar = ProductVariation::where('product_id',$test->id)->get();

        return ProductVariationCustomResources::collection($productVar);
    }

}
