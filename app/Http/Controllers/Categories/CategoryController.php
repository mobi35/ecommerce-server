<?php

namespace App\Http\Controllers\Categories;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use Exception;

class CategoryController extends Controller
{
    public function index(){
        return CategoryResource::collection(
            Category::with('children')->parents()->ordered()->get()
        );
    }

    public function store(Request $request){
        try{
        $authUser = \JWTAuth::parseToken()->authenticate();
        }catch(Exception $e){
            return "Login first";
        }
        if($authUser->role != "admin"){
            return "You are not an admin ";
        }
       $category = Category::create($request->only('slug','name'));
       return new CategoryResource($category);
    }
}
