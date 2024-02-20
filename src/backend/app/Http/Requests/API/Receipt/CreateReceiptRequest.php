<?php

namespace App\Http\Requests\API\Receipt;

use Illuminate\Foundation\Http\FormRequest;

class CreateReceiptRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'customer_id' => 'required',
        ];
    }

    public function getCustomerId(): ?int
    {
        return $this->input('customer_id', null);
    }
}
