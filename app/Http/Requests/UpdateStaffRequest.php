<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateStaffRequest extends FormRequest
{
    public function authorize(): bool
    {
        return false;
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
                'nullable',
                'string',
                'max:255',
            ],

            'mobile' => [
                'required',
                'string',
                Rule::unique('users', 'mobile')
                    ->ignore($this->route('user')),
            ],

            'password' => [
                'nullable',
                'string',
                'min:8',
            ],

            'user_type_id' => [
                'required',
                'exists:user_types,id',
            ],
        ];
    }
}
