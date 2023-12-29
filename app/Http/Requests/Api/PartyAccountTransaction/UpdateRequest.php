<?php

namespace App\Http\Requests\Api\PartyAccountTransaction;

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
            'party_id' => 'required|exists:parties,id',
            'transaction_id' => 'required|exists:transactions,id',
            'account_id' => 'required|exists:accounts,id',
            'sub_account_id' => 'required|exists:sub_accounts,id',
            'amount' => 'required',
            'dr' => 'required'
        ];
    }
}
