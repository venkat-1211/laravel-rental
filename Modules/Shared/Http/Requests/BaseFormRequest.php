<?php

namespace Modules\Shared\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

abstract class BaseFormRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    abstract public function rules(): array;

    public function safeData(?array $only = null): array
    {
        $data = $this->safe();

        return $only ? $data->only($only) : $data->all();
    }
}
