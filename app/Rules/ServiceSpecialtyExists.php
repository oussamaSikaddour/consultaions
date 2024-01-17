<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ServiceSpecialtyExists implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param string $attribute
     * @param mixed $value
     * @param Closure $fail
     * @return void
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $langs = ["ar", "fr", "en"];
        $specialties = app('my_constants')['SPECIALTY_OPTIONS'];

        $lowercaseValue = strtolower($value);

        foreach ($langs as $lang) {
            if (in_array($lowercaseValue, array_map('strtolower', $specialties[$lang]))) {
                return;
            }
        }
        $fail(__('rules.specialty.not-valid'));
    }

}
