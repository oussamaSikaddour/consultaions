<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class DairaExists implements ValidationRule
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
        $dairas = app('my_constants')['DAIRAS'];

        $lowercaseValue = strtolower($value);

        foreach ($langs as $lang) {
            if (in_array($lowercaseValue, array_map('strtolower', $dairas[$lang]))) {
                return;
            }
        }
        // $fail(__('The selected :attribute is not a valid Daira.', ['attribute' => $attribute]));
        $fail(__('rules.daira.not-valid'));
    }

}
