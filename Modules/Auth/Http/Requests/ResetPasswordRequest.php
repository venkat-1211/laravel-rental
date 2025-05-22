<?php

namespace Modules\Auth\Http\Requests;

use Modules\Auth\Rules\OldPasswordCheck;
use Modules\Shared\Http\Requests\BaseFormRequest;

class ResetPasswordRequest extends BaseFormRequest
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
            'old_password' => [new OldPasswordCheck, 'required'],
            'new_password' => 'required|min:6',
            'confirm_password' => 'required|same:new_password',
        ];
    }
}
