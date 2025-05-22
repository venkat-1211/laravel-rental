<?php

namespace Modules\Property\Http\Requests;

use Modules\Shared\Http\Requests\BaseFormRequest;

class PaymentRequest extends BaseFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'check_in' => 'required|date',
            'check_out' => 'required|date|after_or_equal:check_in',
            'code' => 'nullable|exists:coupons,code',
            'bedrooms' => 'numeric',
            'adults' => 'numeric',
            'children' => 'numeric',
        ];
    }
}
