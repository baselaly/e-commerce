<?php

namespace App\Http\Requests\Cart;

use App\Http\Traits\ApiValidationError;
use Illuminate\Foundation\Http\FormRequest;

class CartStoreRequest extends FormRequest
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
        return [
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1|digits_between:1,2'
        ];
    }
}
