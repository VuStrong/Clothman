<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class CreateProductRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'category_id' => 'required',
            'price' => 'required|integer',
            'selling_price' => 'required|integer',
            'discount' => 'integer',
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg,webp',
            'size_guild' => 'image|mimes:jpeg,png,jpg,webp',
        ];
    }
}
