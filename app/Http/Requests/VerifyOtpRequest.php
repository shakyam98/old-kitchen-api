<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VerifyOtpRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'mobile' => [
                'required',
                'string',
                'regex:/^(?:0|94|\+94)?7[01245678][0-9]{7}$/',
            ],

            'otp' => [
                'required',
                'digits:6',
            ],
        ];
    }
}
