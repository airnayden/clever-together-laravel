<?php

namespace App\Http\DataFactories;

use App\Http\DataTransferObjects\CustomerData;
use App\Http\Requests\Customer\CustomerCreateRequest;

class CustomerDataFactory
{
    /**
     * @param CustomerCreateRequest $request
     * @return CustomerData
     */
    public static function fromCreateRequest(CustomerCreateRequest $request): CustomerData
    {
        return new CustomerData(
            id: null,
            firstName: $request->get('first_name'),
            lastName: $request->get('last_name'),
            email: $request->get('email'),
            password: $request->get('password'),
            roles: $request->get('roles'),
            meta: $request->get('meta')
        );
    }
}
