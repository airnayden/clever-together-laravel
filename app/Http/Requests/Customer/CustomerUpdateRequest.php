<?php

namespace App\Http\Requests\Customer;

use App\Http\Enums\CustomerMetaCodeEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class CustomerUpdateRequest extends FormRequest
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'first_name' => ['string'],
            'last_name' => ['string'],
            'email' => [Rule::unique('customers')],
            'password' => ['string'],
            'roles' => ['nullable', 'array'],
            'roles.*' => ['integer'],
            'meta' => ['nullable', 'array'],
            'meta.*.code' => [new Enum(CustomerMetaCodeEnum::class)],
            'meta.*.value' => ['required', 'string']
        ];
    }
}
