<?php

namespace App\Http\Controllers\PaymentMethods;

use App\Http\Controllers\Controller;
use App\Http\Requests\PaymentMethods\PaymentMethodStoreRequest;
use App\Http\Resources\PaymentMethodResource;
use Illuminate\Http\Request;
use App\Models\PaymentMethod;
class PaymentMethodController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth:api']);
    }

    public function index(Request $request){

      return PaymentMethodResource::collection(
          $request->user()->paymentMethods
      );
    }

    public function store(PaymentMethodStoreRequest $request){


        //$id = $request->user()->user->id;
              $product = PaymentMethod::create($request->only('user_id','card_type'));
        



        return new PaymentMethodResource($product);

    }
}
