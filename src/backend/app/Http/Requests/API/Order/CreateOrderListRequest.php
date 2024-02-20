<?php

namespace App\Http\Requests\API\Order;

use Illuminate\Foundation\Http\FormRequest;

class CreateOrderListRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'quantity' => 'required',
            'customer_id' => 'required',
            'menu_id' => 'required',
        ];
    }

    public function getQuantity(): ?array
    {
        return $this->input('quantity', []);
    }

    public function getCustomerId(): ?int
    {
        return $this->input('customer_id', null);
    }

    public function getMenuId(): ?array
    {
        return $this->input('menu_id', []);
    }

    public function getTotalPrice(): ?array
    {
        return $this->input('total_price', []);
    }
}
