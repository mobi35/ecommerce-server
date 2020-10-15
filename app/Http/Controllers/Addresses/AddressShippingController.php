<?php

namespace App\Http\Controllers\Addresses;

use App\Models\Address;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ShippingMethodsResource;

class AddressShippingController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:api']);
    }

    public function action(Address $address){
        $this->authorize('show',$address);
     return ShippingMethodsResource::collection(
        $address->country->shippingMethods
     );
        
    }
}
