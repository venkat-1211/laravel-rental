<?php

namespace Modules\Auth\Http\Requests;

use Modules\Shared\Http\Requests\BaseFormRequest;

class AdminRegisterRequest extends BaseFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()?->hasRole('super_admin');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'profile_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'name' => 'required',
            'name_as_in_aadhaar' => 'required',
            'email' => 'required|email|unique:users',
            'phone' => 'required|unique:profiles|max:10',
            'password' => 'required|min:6',
            'password_confirmation' => 'required|same:password',
            'street' => 'required',
            'flat' => 'required',
            'city' => 'required',
            'state' => 'required',
            'postcode' => 'required',
            'aadhaar_no' => 'required',
            'pan_no' => 'required',
            'gst_no' => 'required',
            'bank_ac_no' => 'required',
            'bank_name' => 'required',
            'ifsc' => 'required',
            'branch' => 'required',
            'upi_phone' => 'required',
        ];
    }
}
