<?php

namespace Modules\Property\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class AdminRequired implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $user = auth()->user();

        if ($user && $user->hasRole('admin')) {
            if (is_null($value) || (is_array($value) && empty($value))) {
                $fail("The $attribute field is required for admin users.");
            }
        }
    }
}
