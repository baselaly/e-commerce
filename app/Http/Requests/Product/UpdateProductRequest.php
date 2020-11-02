<?php

namespace App\Http\Requests\Product;

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
        $rules = [
            'name' => 'required|max:250',
            'description' => 'required|max:1000',
            'quantity' => 'required|integer|min:1|digits_between:1,2',
            'price' => 'required|numeric',
        ];

        request('thumbnail') ? $rules['thumbnail'] = 'required|image|mimes:png,jpg,jpeg|max:5000' : '';

        request('images') ?
            ($rules['images'] = 'array|min:1') && ($rules['images.*'] = 'image|mimes:jpg,jpeg,png|max:5000')
            : '';

        return $rules;
    }
}
