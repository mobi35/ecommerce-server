<?php

namespace App\Http\Resources;

use App\Models\ShippingMethod;
use Illuminate\Http\Resources\Json\JsonResource;

class CountryShippingResource extends JsonResource
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
            'country_id' => $this->country_id,
            'shipping_method_id' => $this->shipping_method_id,
            'shipping_method' => ShippingMethod::where('id',$this->shipping_method_id)->first()->name,
        ];
    }
}
