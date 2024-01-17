<?php

namespace App\Livewire\Forms\Service;

use App\Models\Planning;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Form;

class AddPlanningForm extends Form
{
    public $year;
    public $month;
    public $name;
    public $service_id;

    public function rules()
    {
        return [
            'year' => ['required', 'integer', 'digits:4', 'min:2023', 'max:2050'], // Year should be between 2023 and 2050
            'month' => ['required', 'integer', 'between:1,12'],
            'name' => ['required', 'string', 'max:255', Rule::unique('plannings','name')->where(function ($query) {
                return $query->where('year', $this->year);
            })],
            'service_id' => ['required', 'integer', 'exists:services,id'], // Service ID should exist in the 'services' table
        ];
    }

    public function validationAttributes()
    {
        return [
            'year' => __("modals.planning.year"),
            'month' =>__("modals.planning.month"),
            'name' => __("modals.planning.name"),
            'service_id' => 'service',
            'state' =>__("modals.planning.state")
        ];
    }

    public function save()
    {
        $validatedData = $this->validate();
        try {
            $validatedData["created_by"] = Auth::user()->id;
            Planning::create($validatedData);
            return [
                'status' => true,
                'success' => __("forms.planning.add.success-txt"),
            ];
        } catch (\Exception $e) {
            return [
                'status' => false,
                'error' => $e->getMessage(),
            ];
        }
    }
}
