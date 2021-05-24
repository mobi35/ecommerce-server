<?php

namespace App\Http\Controllers\Stocks;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\StockResource;
use App\Models\Stock;
use Exception;

class StockController extends Controller
{

    public function __construct()
    {
        $this->middleware('jwt.admin')->except(['index','show']);
    }

    public function show($id){
        $stocks = Stock::where('product_variation_id',$id)->get();
        return StockResource::collection($stocks);
    }

    public function store(Request $request){

       $stock = Stock::create($request->only('product_variation_id','quantity'));
       return new StockResource($stock);
    }

    public function destroy($id){
        Stock::find($id)->delete();
    }
}
