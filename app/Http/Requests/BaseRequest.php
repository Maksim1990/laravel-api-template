<?php

namespace App\Http\Requests;

use App\Exceptions\AuthenticationException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

abstract class BaseRequest extends FormRequest
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

    public function failedValidation(Validator $validator)
    {
        if ($validator->fails()) {
            throw new AuthenticationException(implode(',', $validator->messages()->all()));
        }
    }
}
