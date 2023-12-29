<?php

namespace App\Http\Requests\Api\PartyTransaction;

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
            'party_id' => 'required|exists:parties,id',
            'transaction_id' => 'required|array',
            'transaction_id' => 'required|exists:transactions,id',
        ];
    }
}
