<?php

namespace Modules\Auth\Http\Requests;

use Modules\Auth\Rules\UniqueJsonValue;
use Modules\Shared\Http\Requests\BaseFormRequest;

class EditProfileRequest extends BaseFormRequest
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
        $userId = auth()->id();

        return [
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',

            'name' => 'required|unique:users,name,'.$userId,
            'email' => 'required|email|unique:users,email,'.$userId,
            'phone' => 'required|max:10|unique:profiles,phone,'.$userId.',user_id',

            'street' => 'required',
            'flat' => 'required',
            'city' => 'required',
            'state' => 'required',
            'postcode' => 'required',

            'name_as_in_aadhaar' => [
                'required',
                new UniqueJsonValue('profiles', 'aadhaar', '$.name_as_in_aadhaar', $userId),
            ],

            'aadhaar_no' => [
                'required',
                new UniqueJsonValue('profiles', 'aadhaar', '$.aadhaar_no', $userId),
            ],

            'aadhaar_front' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'aadhaar_back' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',

            'pan_no' => [
                'required',
                new UniqueJsonValue('profiles', 'pan', '$.pan_number', $userId),
            ],

            'gst_no' => 'required|unique:profiles,gst_number,'.$userId.',user_id',

            'bank_ac_no' => [
                'required',
                new UniqueJsonValue('profiles', 'bank', '$.account_number', $userId),
            ],

            'bank_name' => 'required',
            'ifsc' => 'required',
            'branch' => 'required',

            'upi_phone' => [
                'required',
                new UniqueJsonValue('profiles', 'upi', '$.upi_phone', $userId),
            ],
        ];
    }
}
