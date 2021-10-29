<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'name' => 'required|unique:users|min:5|max:100|alpha',
            'lastname' => 'required|max:100|alpha',
            'national_identity_document' => 'required|unique:users',
            'email' => 'required|unique:users|max:150|email',
            'country' => 'required',
            'address' => 'required|max:180',
            'mobile' => 'required|max:10|alpha_num'

        ];
    }
}
