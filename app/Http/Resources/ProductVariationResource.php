<?php

namespace App\Http\Resources;

use Illuminate\Support\Collection;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductVariationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

        if($this->resource instanceof Collection){
            return ProductVariationResource::collection($this->resource);
        }

        return [
            'id' => $this->id,
            'name' => $this->name,
            'product_id' => $this->product_id,
            'price' => $this->formattedPrice,
            'price_varies' => $this->priceVaries(),
            'stock_count' =>(int) $this->stockCount(),
            'type' => $this->type->name,
            'in_stock' => $this->inStock()
        ];
    }
}