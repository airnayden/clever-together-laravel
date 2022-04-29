<?php

namespace App\Http\DataTransferObjects;

class CustomerData
{
    /**
     * @param int|null $id
     * @param string|null $firstName
     * @param string|null $lastName
     * @param string|null $email
     * @param string|null $password
     * @param array|null $roles
     * @param array|null $meta
     */
    public function __construct(
        public ?int $id,
        public ?string $firstName,
        public ?string $lastName,
        public ?string $email,
        public ?string $password,
        public ?array $roles,
        public ?array $meta
    ) {
    }
}
