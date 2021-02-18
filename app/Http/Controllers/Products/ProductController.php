<?php

namespace App\Http\Controllers\Products;

use App\Models\Product;
use App\Models\Category;
use App\Http\Requests\Products\ProductRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductIndexResource;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ProductAddResource;
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
 

    protected function scopes(){
        return [
            'category' => new CategoryScope()
        ];
    }

    public function store(ProductRequest $request){
        $category = Category::where('slug',$request->category)->first();
       dd($request);
        if($category != null){
            $category->products()->save(
                $product = Product::create($request->only('name','price','description','slug'))
            );
      }

        return new ProductAddResource($product);
      //  $product->sync();

    }

    public function checkSlug(ProductRequest $request){
        
        $test = Product::where('slug',$request->slug)->first();
        if(!$test){
            dd("false");
        }
        return new ProductAddResource($test);
    }

  
}
