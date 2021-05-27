<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductVariationCustomResources extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'name' => $this->name,
            'price' => $this->price,
            'formatted' => $this->price->formatted(),
            'id' => $this->id,
            'file' => $this->file,
            'stock_count' =>(int) $this->stockCount(),
            'type' => $this->getVariationType($this->product_variation_type_id)
        ];
    }
}
