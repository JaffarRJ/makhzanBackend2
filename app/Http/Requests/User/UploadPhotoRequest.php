<?php

namespace App\Http\Requests\User;

use App\Http\Requests\BaseRequest;

class UploadPhotoRequest extends BaseRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'profile_picture' => 'required|file|mimes:jpeg,jpg,png|max:5120',
        ];
    }
}
