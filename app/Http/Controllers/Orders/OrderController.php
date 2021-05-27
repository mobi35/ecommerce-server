<?php

namespace App\Http\Controllers\Orders;

use App\Cart\Cart;
use App\Events\Order\OrderCreated;
use App\Events\Order\OrderPaid;
use App\Events\Order\OrderPaymentFailed;
use App\Http\Controllers\Controller;
use App\Http\Requests\Orders\OrderStoreRequest;
use App\Http\Resources\OrderResource;
use App\Models\ProductVariation;
use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Storage;

class OrderController extends Controller
{

    protected $cart;

    public function __construct()
    {
        $this->middleware(['auth:api']);
        $this->middleware(['cart.sync','cart.isnotempty'])->only('store');
    }

    public function index(Request $request){
        $orders = $request->user()->orders()
        ->with(['products','products.stock','products.type','products.product','products.product.variations','products.product.variations.stock','address','shippingMethod'])
        ->latest()
        ->paginate(10);

        return OrderResource::collection($orders);

    }


    public function adminshow(){

        $orders = Order::with(['products','products.stock','products.type','products.product','products.product.variations','products.product.variations.stock','address','shippingMethod'])->get();
       // $orders = $request->orders()
      //  ->with(['products','products.stock','products.type','products.product','products.product.variations','products.product.variations.stock','address','shippingMethod'])
      //  ->latest()
       // ->paginate(10);

        return OrderResource::collection($orders);


    }

    public function store(OrderStoreRequest $request, Cart $cart){



       $order = $this->createOrder($request, $cart);

       $order->products()->sync($cart->products()->forSyncing());

      // $order->load(['products']);

        event(new OrderCreated($order));

        return new OrderResource($order);

    }

    protected function createOrder(Request $request, Cart $cart){

       return $request->user()->orders()->create(
           array_merge( $request->only(['address_id','shipping_method_id','payment_method_id'])
            ,
            [
                'subtotal' => $cart->subtotal()->amount()
            ]
            ));

    }

    public function pay(Request $request){
        $order = Order::find( $request->id);
        event(new OrderPaid($order));

        $order->status = "completed";
        $order->save();
        return 'success';
    }

    public function cancel(Request $request){
        $order = Order::find($request->id);
        event(new OrderPaymentFailed($order));
        $order->status = "payment_failed";
        $order->save();
        return 'success';
    }
    public function prepare(Request $request){
        $order = Order::find( $request->id);
       // event(new OrderPaid($order));
        $order->orderStatus = "prepare";
        $order->save();
        return 'success';
    }
    public function shipped(Request $request){
        $order = Order::find( $request->id);
     //   event(new OrderPaid($order));
        $order->orderStatus = "shipped";
        $order->save();
        return 'success';
    }

    public function uploadPayment(Request $request){
        $request->validate([
            'image' => 'required|file|image',
        ]);

        $imgName = time() . "." . $request->file('image')->extension();
        $request->file('image')->move(public_path('receipt'), $imgName);
        $order =  Order::find($request->order_id);

        if($order->image_name != ""){
        // Storage::disk('storage')->delete($order->image_name);
             if($order->image_name == ""){
             $order->image_name = $imgName;
         }
        }else {
            $order->image_name = $imgName;
        }
        $order->save();
        return "";
      //  $this->StoreImage($request->file('image'), $request->order_id);

        //return 'Success';
    }


    public function StoreImage($image,$id){
        return "burat";

    //   $timestampName = microtime(true) . '.jpg';
       $imgName = time() . "." . $image->extension();
       $image->move(public_path('receipt'), $imgName);

      // $image->storeAs('photos',  $timestampName);
       $this->UpdateOrder( $imgName, $id);

        return $image;
    }

    public function UpdateOrder($image,$id){
       $order =  Order::find($id);

       if($order->image_name != ""){
       // Storage::disk('storage')->delete($order->image_name);
            if($order->image_name == ""){
            $order->image_name = $image;
        }
       }else {
           $order->image_name = $image;
       }
       $order->save();

    }



}
