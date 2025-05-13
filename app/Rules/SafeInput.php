<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class SafeInput implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        
        if (!preg_match('/^((?!script>|<script|alert|javascript|prompt|onerror|document.cookie).)*$/si', $value)) {
            $fail("The :attribute contains potentially unsafe input.");
        }
    }
}
