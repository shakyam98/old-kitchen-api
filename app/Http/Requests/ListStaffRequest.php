<?php

namespace App\Http\Requests;

use App\Models\UserType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ListStaffRequest extends FormRequest
{
    public function authorize(): bool
    {
        return false;
    }

    public function rules(): array
    {
        return [
            'filter.active' => [
                'nullable',
                Rule::in(['0', '1']),
            ],

            'filter.role' => [
                'nullable',
                Rule::in([
                    UserType::ADMIN,
                    UserType::MANAGER,
                    UserType::CHEF,
                ]),
            ],

            'per_page' => [
                'nullable',
                'integer',
                'min:1',
                'max:100',
            ],
        ];
    }
}
