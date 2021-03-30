<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string'],
            'price' => ['required', 'integer', 'min: 0'], // gratis
            'description' => ['required'],
            'ingredients' => ['sometimes'],
            'product_category_id' => ['required', 'integer', 'exists:product_categories,id'],
        ];
    }
}
