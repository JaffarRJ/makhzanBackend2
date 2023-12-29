<?php

namespace App\Http\Requests\User;

use App\Http\Requests\BaseRequest;

class StoreRequest extends BaseRequest
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
            'name' => 'required',
//            'role_id' => 'required|array',
            'role_id' => 'required|exists:roles,id',
//            'role_id.*' => 'required|exists:roles,id',
            'email' => 'required|email:rfc,dns|unique:users,email',
            'password' => 'required|confirmed'
        ];
    }
}
