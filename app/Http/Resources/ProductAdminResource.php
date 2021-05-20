<?php

namespace App\Http\Resources;

use App\Http\Resources\ProductVariationResource;
use App\Models\Category;
use App\Models\CategoryProduct;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductAdminResource extends ProductIndexResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {


        return array_merge(parent::toArray($request),[
            'variations' =>  ProductVariationResource::collection(
                $this->variations->groupBy('type.name')
            ),
            'category' => Category::where('id',CategoryProduct::where('product_id',$this->id)->first()->category_id)->first()->id,
            'categoryname' => Category::where('id',CategoryProduct::where('product_id',$this->id)->first()->category_id)->first()->name
        ]);
    }
}
