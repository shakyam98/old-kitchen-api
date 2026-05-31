<?php

namespace App\Http\Requests;

use App\Models\Otp;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SendOtpRequest extends FormRequest
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

            'purpose' => [
                'required',
                'string',
                Rule::in([Otp::PURPOSE_LOGIN, Otp::PURPOSE_REGISTER]),
            ],
        ];
    }
}
