<?php

namespace App\Http\Controllers\Products;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\ImagesForProduct;
use App\Models\ProductVariation;
use App\Models\ProductVariationType;
use App\Http\Requests\Products\ProductRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductIndexResource;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ProductAddResource;
use App\Http\Resources\ProductVariationCustomResources;
use App\Scoping\Scopes\CategoryScope;



class ProductController extends Controller
{
    public function index(){
        $products = Product::with(['variations.stock'])->withScopes($this->scopes())->paginate(10);

        return ProductResource::collection($products);
    }

    public function show(Product $product){

        $product->load(['variations.type','variations.stock','variations.product']);

        return new ProductResource(
            $product
        );
    }

    public function showVar(){

        $products = Product::with(['variations.stock'])->withScopes($this->scopes())->paginate(10);

        return ProductResource::collection($products);

    }

    public function showAllWithoutPage(){

        $products = Product::with(['variations.stock'])->withScopes($this->scopes())->paginate();

        return ProductResource::collection($products);

    }

    public function storeVariation(Request $request){
       //return $request->file;
       //print_r($request);

      $image = $request->file('file');
      $prod = Product::where('id',$request->product_id)->first();

        $prod->variations()->save(
            $variation = ProductVariation::create( $request->only('name','price','product_id','product_variation_type_id') )
         );
        $count = 0;
         foreach($image as $val){
            $imgName = time() . "." . $val->extension();
            $val->move(public_path('uploads'), $imgName);

            if($count == 0){
            $variation->images()->save(

                $image = ImagesForProduct::create(
                    ['image_name' => $imgName ,
                    'product_variation_id' => $variation->id ,
                    'cover' => true]
                )
            );
            $count++;
        }else {
            $variation->images()->save(

                $image = ImagesForProduct::create(
                    ['image_name' => $imgName ,
                    'product_variation_id' => $variation->id ,
                    'cover' => false]
                )
            );
        }
         }

         return $variation;






    }

    protected function scopes(){
        return [
            'category' => new CategoryScope()
        ];
    }

    public function store(ProductRequest $request){


        $authUser = \JWTAuth::parseToken()->authenticate();

        if($authUser->role != "admin"){
            return "You are not an admin ";
        }

        $category = Category::where('slug',$request->category)->first();

        if($category != null){
            $category->products()->save(
                $product = Product::create($request->only('name','price','description','slug'))
            );
            return new ProductAddResource($product);
       }else {
           return "no Category";
       }
      //  $product->sync();
    }

    public function checkSlug(ProductRequest $request){

        $test = Product::where('slug',$request->slug)->first();
        if(!$test){
            dd("false");
        }
        return new ProductAddResource($test);
    }

    ///PRODUCT VARIATIONS


    public function getVariations(Request $request){

        $test = Product::where('slug',$request->slug)->first();
        $productVar = ProductVariation::where('product_id',$test->id)->get();

        return ProductVariationCustomResources::collection($productVar);
    }


}
