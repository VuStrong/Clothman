<?php

namespace App\Http\Requests\Banner;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBannerRequest extends FormRequest
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
            'image' => 'image|mimes:jpeg,png,jpg,webp'
        ];
    }

    /**
     * Get the error messages for the request.
     *
     * @return array<string, mixed>
     */
    public function messages()
    {
        return [
            'name.required' => 'Tên banner không được để trống',
            'image.image' => 'Banner phải có phần mở rộng là .png .jpg .jpeg hoặc .webp',
            'image.mimes' => 'Banner phải có phần mở rộng là .png .jpg .jpeg hoặc .webp',
        ];
    }
}
