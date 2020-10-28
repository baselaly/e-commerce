<?php

namespace App\Http\Requests\Store;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            'address' => 'required|max:500',
            'phone' => 'required|max:15',
        ];

        request('logo') ? $rules['logo'] = 'image|mimes:jpg,jpeg,png' : '';
        return $rules;
    }
}
