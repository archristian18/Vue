<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        return [
            'customer_id' => $this->customer_id,
            'quantity' => $this->quantity,
            'total_price' => $this->total_price,
            'menu_id' => $this->menu_id,
        ];
    }
}
