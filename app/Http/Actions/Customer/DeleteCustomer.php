<?php

namespace App\Http\Actions\Customer;

use App\Models\Customer;

class DeleteCustomer
{
    /**
     * @param Customer $customer
     * @return void
     */
    public static function execute(Customer $customer): void
    {
        $customer->delete();
    }
}
