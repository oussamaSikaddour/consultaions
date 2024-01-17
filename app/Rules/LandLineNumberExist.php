<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class LandLineNumberExist implements ValidationRule
{
    private $model;
    private $currentId = null;
    private $attributes = [];

    public function __construct($model, $currentId = null, $attributes = [])
    {
        $this->model = $model;
        $this->currentId = $currentId;
        $this->attributes = $attributes;
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Constructing the query based on the provided model and value
        $query = $this->model::where(function ($query) use ($value) {
            $query->where('tel', $value)
                ->orWhere('fax', $value);
        });

        // Exclude the current record being edited if a current ID is provided
        if ($this->currentId) {
            $query->where('id', '!=', $this->currentId);
        }

        // If additional attributes are provided, customize the query accordingly
        if ($this->attributes && count($this->attributes)) {
            foreach ($this->attributes as $key => $v) {
                // You can modify the query based on the additional attributes here
             $query->where($key, $v);
            }
        }

        // Check if the record exists and has not been soft-deleted
        if (!$query->whereNull('deleted_at')->exists()) {
            return;
        }

        // If the record exists, fail the validation with a custom error message
        $fail(__('rules.land_line_number.not-valid', ['attribute' => $attribute]));
    }
}
