<?php

namespace App\Http\Requests\API\Menu;

use Illuminate\Foundation\Http\FormRequest;

class EditMenuRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'id' => 'required',
            'name' => 'nullable',
            'price' => 'nullable',
            'description' => 'nullable',
            'image_path' => 'nullable',
        ];
    }

    public function getId()
    {
        return $this->input('id', null);
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
