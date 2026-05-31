<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateStaffRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'first_name' => [
                'required',
                'string',
                'max:255',
            ],

            'last_name' => [
                'required',
                'string',
                'max:255',
            ],

            'mobile' => [
                'required',
                'string',
                'unique:users,mobile',
                'regex:/^(?:0|94|\+94)?7[01245678][0-9]{7}$/',
            ],

            'password' => [
                'required',
                'string',
                'min:8',
            ],

            'user_type_id' => [
                'required',
                'integer',
                'exists:user_types,id',
            ],
        ];
    }
}
