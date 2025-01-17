<?php

namespace App\Http\Requests\Auth;

use App\Http\Traits\ApiValidationError;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'first_name' => 'required|max:250',
            'last_name' => 'required|max:250',
            'phone' => 'required|max:15',
            'email' => 'required|email|max:250|unique:users,email',
            'password' => 'required|min:8|confirmed'
        ];
    }
}
