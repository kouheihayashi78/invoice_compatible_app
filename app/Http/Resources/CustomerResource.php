<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // 必要なものだけ返してくれるようになる
        return [
            'id' => $this->customer_id,
            'name' => $this->customer_name,
        ];
    }
}
