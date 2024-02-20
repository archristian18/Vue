<?php

namespace App\Http\Requests\API\Menu;

use Illuminate\Foundation\Http\FormRequest;

class CreateMenuRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name' => 'required',
            'price' => 'required',
            'description' => 'required',
            'image_path' => 'required',
        ];
    }

    public function getName()
    {
        return $this->input('name', null);
    }

    public function getPrice()
    {
        return $this->input('price', null);
    }

    public function getDescription()
    {
        return $this->input('description', null);
    }

    public function getImage()
    {
        return $this->file('image_path', null);
    }
}
