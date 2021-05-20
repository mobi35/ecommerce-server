<?php

namespace App\Http\Controllers\Products;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\CategoryProduct;
use App\Models\ImagesForProduct;
use App\Models\ProductVariation;
use App\Http\Controllers\Controller;
use App\Models\ProductVariationType;
use App\Scoping\Scopes\CategoryScope;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ProductAddResource;
use App\Http\Resources\ProductIndexResource;
use App\Http\Requests\Products\ProductRequest;
use App\Http\Resources\ProductAdminResource;
use App\Http\Resources\ProductVariationCustomResources;



class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt.admin')->except(['index','show']);
    }

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

    public function update(Request $request, $id){
        $category  = CategoryProduct::where('product_id', $id)->update(['category_id' => $request->category]);
        Product::find($id)->fill($request->only('name','price','description' ))->save();
        return "updated";
    }

    public function showVar(){
        $products = Product::with(['variations.stock'])->withScopes($this->scopes())->paginate(10);
        return ProductResource::collection($products);
    }
    public function showAllWithoutPage(){
        $products = Product::with(['variations.stock'])->withScopes($this->scopes())->paginate();
        return ProductResource::collection($products);
    }

    public function showAdminProducts(){
        $products = Product::with(['variations.stock'])->withScopes($this->scopes())->paginate();
        return ProductAdminResource::collection($products);
    }

    public function bestProducts(){
        $products = Product::with(['variations.stock'])->withScopes($this->scopes())->paginate(10);

        return ProductResource::collection($products);
    }

    public function makeBest($id){

        $products = Product::find($id);
        $products->feature = !$products->feature;
        $products->save();
        return "updated feature to  " . $products->feature;
    }

    public function uploadSize(Request $request){
        $request->validate([
            'image' => 'required|file|image',
        ]);
        $imgName = time() .  $request->file('image')->getClientOriginalName() . "." . $request->file('image')->extension();
        $request->file('image')->move(public_path('sizeChart'), $imgName);

        $product =  Product::find($request->id);

        if($product->sizeImage != ""){
             if($product->sizeImage == ""){
             $product->sizeImage = $imgName;
         }
        }else {
            $product->sizeImage = $imgName;
        }
        $product->save();
        return "";

    }

    public function randomProducts()
    {
        $products = Product::with(['variations.stock'])->withScopes($this->scopes())->inRandomOrder()->limit(5)->get();;
        return ProductResource::collection($products);
    }

    protected function scopes(){
        return [
            'category' => new CategoryScope()
        ];
    }

    public  function slugify($text, string $divider = '-')
    {
    $text = preg_replace('~[^\pL\d]+~u', $divider, $text);
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
    $text = preg_replace('~[^-\w]+~', '', $text);
    $text = trim($text, $divider);
    $text = preg_replace('~-+~', $divider, $text);
    $text = strtolower($text);

    if (empty($text)) {
        return 'n-a';
    }

    return $text;
    }

    public function store(ProductRequest $request){

        $category = Category::where('id',$request->category)->first();
        $slug = $this->slugify($request->name);

        $count = 0;
        $newSlug = $slug;
        while(Product::where('slug',$newSlug)->count() > 0){
            $newSlug = $slug . '-' . $count;
            $count++;
        }

        //array_merge([ 'slug' => $slug],$request->only('name','price','description' ))
        if($category != null){
            $category->products()->save(
                $product = Product::create(array_merge([ 'slug' => $newSlug],$request->only('name','price','description' ))  )
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

    public function deleteVariation(Request $request){
        $productImage = ImagesForProduct::where('product_variation_id',$request->id)->delete();
        $productVar = ProductVariation::where('id',$request->id)->delete();
        return "deleted";
    }

    public function destroy($id){
        $prod = Product::where('id',$id)->first();
        $prodVar = ProductVariation::where('product_id',$id)->get();
        if($prodVar->count() > 0){
            foreach($prodVar as $var){
                ImagesForProduct::where('product_variation_id',$var->id)->delete();
                ProductVariation::where('id',$var->id)->delete();
            }
        }
        CategoryProduct::where('product_id',$id)->delete();
        Product::where('id',$id)->delete();
     //   $product = Product::where('id',$request->id)->delete();
        return "deleted";
    }
    ///PRODUCT VARIATIONS
    public function getVariations(Request $request){
        $test = Product::where('slug',$request->slug)->first();
        $productVar = ProductVariation::where('product_id',$test->id)->get();

        return ProductVariationCustomResources::collection($productVar);
    }


}
