<?php

namespace App\Http\Payloads\Customer;

class CreateCustomerDto
{
    public function __construct(
        public readonly string $first_name,
        public readonly string $last_name,
        public readonly string $birthday,
        public readonly string $contact,
    )
    {
    }

    public static function fromArray(array $data): CreateCustomerDto
    {
        return new CreateCustomerDto(
            first_name: $data["first_name"],
            last_name: $data["last_name"],
            birthday: $data["birthday"],
            contact: $data["contact"]
        );
    }

    public function toArray(): array
    {
        return [
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'birthday' => $this->birthday,
            'contact' => $this->contact

        ];
    }
}
