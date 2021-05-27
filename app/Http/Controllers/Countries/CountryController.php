<?php

namespace App\Http\Controllers\Countries;

use App\Models\Country;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CountryShippingMethod;
use App\Http\Resources\CountryResource;

class CountryController extends Controller
{
    public function index(){
        return CountryResource::collection(Country::get());
    }
    public function store(Request $request){
        Country::create($request->only('code','name'));
        return "created";
    }

    public function addShippingInCountry(Request $request){
        $check = CountryShippingMethod::
        where([
            ['country_id',$request->country_id],
            ['shipping_method_id',$request->shipping_method_id]
            ])->first();
       if($check === null){
         CountryShippingMethod::create($request->only('country_id','shipping_method_id'));
       
        return "added";
    }else {
        return "existing";
    }
    }


    public function destroy($id){
        Country::find($id)->delete();
        return "deletedd";
    }
}
