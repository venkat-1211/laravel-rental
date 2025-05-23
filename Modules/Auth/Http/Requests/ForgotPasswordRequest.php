<?php

namespace Modules\Auth\Http\Requests;

use Modules\Shared\Http\Requests\BaseFormRequest;

class ForgotPasswordRequest extends BaseFormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'password' => 'required|min:6',
            'confirm_password' => 'required|same:password',
        ];
    }
}
