<?php

namespace App\Http\Controllers\Shipping;

use Illuminate\Http\Request;
use App\Models\ShippingMethod;
use App\Http\Controllers\Controller;
use App\Models\CountryShippingMethod;
use App\Http\Resources\CountryShippingResource;
use App\Http\Resources\ShippingMethodsResource;

class ShippingMethodController extends Controller
{
    
    //
    public function index(){
       return ShippingMethodsResource::collection(ShippingMethod::get());
    }

    public function store(Request $request){
        ShippingMethod::create($request->only('name','price'));
        return "created";
    }

    public function destroy($id){
        ShippingMethod::find($id)->delete();
        return "deletedd";
    }

    public function getCountryShipping($id){
       $countryShipping = CountryShippingMethod::where('country_id',$id)->get();
       return  CountryShippingResource::collection($countryShipping);
    }

    public function deleteCountryShipping(Request $request){
        CountryShippingMethod::where(
            [
                ['country_id',$request->country_id],
                ['shipping_method_id',$request->shipping_method_id]
                ]
            
            )->delete();

            return "deleted";
    }
}
