<?php

namespace App\Http\Requests\Api\Auth;

use App\Http\Requests\BaseRequest;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends BaseRequest
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
            'name' => 'nullable',
            'role_id' => 'required|exists:roles,id',
            'email' => 'required|email:rfc,dns|unique:users,email',
            'password' => 'required|confirmed'
        ];
    }
}
