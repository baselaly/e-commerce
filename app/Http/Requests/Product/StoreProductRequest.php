<?php

namespace App\Http\Requests\Product;

use App\Http\Traits\ApiValidationError;
use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    use ApiValidationError;

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
            'images' => 'required|array|min:1',
            'images.*' => 'required|image|mimes:png,jpg,jpeg|max:5000',
            'thumbnail' => 'required|image|mimes:png,jpg,jpeg|max:5000'
        ];

        // for user UI validation
        if (request()->route()->getName() === "products.store") {
            request('type') == 'store' ? $rules['store_id'] = 'required|exists:stores,id,user_id,' . auth()->id() : '';
            $rules['type'] = 'required|in:store,user';
        }

        return $rules;
    }
}
