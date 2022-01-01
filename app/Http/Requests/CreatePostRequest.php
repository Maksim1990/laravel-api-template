<?php

namespace App\Http\Requests;

class CreatePostRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|max:15',
            'slug' => 'required|unique:posts',
            'description' => 'max:55',
            'user_id' => 'required|integer',
        ];
    }
}
