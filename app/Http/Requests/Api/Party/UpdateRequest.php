<?php

namespace App\Http\Requests\Api\Party;

use App\Http\Requests\BaseRequest;

class UpdateRequest extends BaseRequest
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
            'id' => 'required|exists:parties,id',
            'name' => 'required',
            'cnic' => 'required',
            'address' => 'required',
        ];
    }
}
