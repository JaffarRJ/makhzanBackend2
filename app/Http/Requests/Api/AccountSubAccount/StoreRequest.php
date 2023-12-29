<?php

namespace App\Http\Requests\Api\AccountSubAccount;

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
            'account_id' => 'required|exists:accounts,id',
            'sub_account_id' => 'required|array',
            'sub_account_id.*' => 'required|exists:sub_accounts,id',
        ];
    }
}
