<?php

namespace App\Http\Requests;

class UpdatePostRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'max:15',
            'slug' => 'unique:posts',
            'description' => 'max:55',
            'user_id' => 'integer',
        ];
    }
}
