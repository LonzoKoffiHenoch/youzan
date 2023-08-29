<?php

namespace App\Http\Requests\Customer;

use App\Http\Payloads\Customer\CreateCustomerDto;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CreateCustomerRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            "first_name" => ["required"],
            "last_name" => ["required"],
            "birthday" => ["required"],
            "contact" => ["required"]
        ];
    }

    public function payload(): CreateCustomerDto
    {
        return CreateCustomerDto::fromArray(
            data: $this->validated()
        );
    }
}
