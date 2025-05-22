<?php

namespace Modules\Shared\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Shared\Http\Requests\BaseFormRequest;

class AddTestimonialRequest extends BaseFormRequest
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
            'reminder_id' => 'required',
            'ratings' => 'required',
            'description' => 'required',
        ];
    }
}
