<?php

namespace App\Http\Resources;

use Illuminate\Support\Collection;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\ProductVariation;
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
            'priceAmount' => $this->normalPrice,
            'price_varies' => $this->priceVaries(),
            'stock_count' =>(int) $this->stockCount(),
            'type' => $this->type->id,
            'in_stock' => $this->inStock(),
            'images' => $this->showImages($this->id),
            'product' => new ProductIndexResource($this->product)
        ];
    }
}
