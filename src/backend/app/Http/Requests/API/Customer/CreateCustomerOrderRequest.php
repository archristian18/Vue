<?php

namespace App\Http\Requests\API\Customer;

use Illuminate\Foundation\Http\FormRequest;

class CreateCustomerOrderRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name' => 'required',
            'status' => 'required',
        ];
    }

    public function getName(): ?string
    {
        return $this->input('name', null);
    }

    public function getStatus(): ?string
    {
        return $this->input('status', null);
    }
}
