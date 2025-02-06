<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->product_id,
            'name' => $this->product_name,
            'code' => $this->product_code,
            'price' => $this->product_price,
            'tax' => $this->product_tax,
        ];
    }
}
