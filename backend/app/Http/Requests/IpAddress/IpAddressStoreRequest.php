<?php

namespace App\Http\Requests\IpAddress;

use App\Enums\LabelEnum;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class IpAddressStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'ip_address' => 'required|ip|unique:ip_addresses,ip_address',
            'label' => ['required', 'string', 'max:255', new Enum(LabelEnum::class)],
            'comment' => 'nullable|string',
        ];
    }
}
