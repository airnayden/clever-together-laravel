<?php

namespace App\Http\Actions\Customer;

use App\Http\DataTransferObjects\CustomerData;
use App\Models\Customer;
use Illuminate\Support\Facades\Hash;

class CreateOrUpdateCustomer
{
    /**
     * @param CustomerData $customerData
     * @return Customer
     */
    public static function execute(CustomerData $customerData): Customer
    {

        if (is_null($customerData->id)) {
            $customer = new Customer();
        } else {
            $customer = Customer::findOrFail($customerData->id);
        }

        if (!is_null($customerData->firstName)) {
            $customer->first_name = $customerData->firstName;
        }

        if (!is_null($customerData->lastName)) {
            $customer->last_name = $customerData->lastName;
        }

        if (!is_null($customerData->email)) {
            $customer->email = $customerData->email;
        }

        if (!empty($customerData->password)) {
            $customer->password = Hash::make($customer->password);
        }

        $customer->save();

        if (!is_null($customerData->roles)) {
            $customer->roles()->sync($customerData->roles);
        }

        if (!is_null($customerData->meta)) {
            $customer->meta()->delete();

            $meta = [];

            foreach ($customerData->meta as $k => $v) {
                $meta[] = [
                    'code' => $k,
                    'value' => $v
                ];
            }

            $customer->meta()->createMany($meta);
        }

        return $customer;
    }

}
