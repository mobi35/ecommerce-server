<?php

namespace App\Http\Controllers\Categories;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use Exception;

class CategoryController extends Controller
{

    public function __construct()
    {
        $this->middleware('jwt.admin')->except(['index','show']);
    }

    public function index(){
        return CategoryResource::collection(
            Category::with('children')->parents()->ordered()->get()
        );
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

    public function store(Request $request){

      $catSlug = $this->slugify($request->name);
       $category = Category::create(array_merge(['slug' =>  $catSlug],$request->only('name')));
       return new CategoryResource($category);
    }

    public function destroy($id){
        Category::find($id)->delete();
    }
}
