<?php

namespace App\Http\Requests\Customer;

use App\Http\Enums\CustomerMetaCodeEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\Validator;

class CustomerUpdateRequest extends FormRequest
{
    /**
     * @param Validator $validator
     * @return void
     */
    public function withValidator(Validator $validator): void
    {
        if ($validator->fails()) {
            Redirect::back()
                ->withErrors($validator->getMessageBag()->getMessages())
                ->withInput();
        }
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'first_name' => ['string'],
            'last_name' => ['string'],
            'email' => [Rule::unique('customers')->ignore($this->get('customer_id'))],
            'password' => ['string'],
            'roles' => ['array'],
            'roles.*' => ['integer'],
            'meta' => ['nullable', 'array'],
            'meta.*.code' => [new Enum(CustomerMetaCodeEnum::class)],
            'meta.*.value' => ['required', 'string']
        ];
    }
}
