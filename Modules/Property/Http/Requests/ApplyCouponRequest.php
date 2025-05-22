<?php

namespace Modules\Property\Http\Requests;

use Modules\Shared\Http\Requests\BaseFormRequest;

class ApplyCouponRequest extends BaseFormRequest
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
            // 'property_id' => 'required|exists:properties,id',
            'code' => 'required|exists:coupons,code',
            'check_in' => 'required|date',
            'check_out' => 'required|date|after_or_equal:check_in',
        ];
    }
}
