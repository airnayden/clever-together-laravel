<?php

namespace App\Http\Requests\Customer;

use Illuminate\Foundation\Http\FormRequest;

class CustomerDestroyRequest extends FormRequest
{
    /**
     * @return string[]
     */
    public function rules(): array
    {
        // Redirect to list in case of failed validation
        $this->redirect = url('customer');

        return [
            'limit' => 'integer',
            'order' => 'in:ASC,DESC',
            'sort' => 'in:first_name,last_name,email,id',
            'page' => 'integer',
            'search' => 'string'
        ];
    }
}
