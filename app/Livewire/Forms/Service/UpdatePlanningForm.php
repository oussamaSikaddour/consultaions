<?php

namespace App\Livewire\Forms\Service;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Form;

class UpdatePlanningForm extends Form
{

    public $id;
    public $year;
    public $month;
    public $name;
    public $service_id;
    public $state;
    public function rules()
    {
        return [
            'year' => ['required', 'integer', 'digits:4', 'min:2023', 'max:2050'], // must be a 4-digit integer between 1900 and 10 years in the future
            'month' => ['required', 'integer', 'between:1,12'],
            'name' => ['required', 'string', 'max:255', Rule::unique('plannings','name')->where(function ($query)  {
                return $query->where('year', $this->year);
            })->ignore($this->id)],
            'service_id' => ['required', 'integer', 'exists:services,id'], // must be an existing service ID
            'state' => ['nullable', 'string', Rule::in(['publié', 'non publié'])], // must be either "published" or "unpublished"
        ];
    }

    public function validationAttributes()
    {

        return [
            'year' => 'année',
            'month' => 'mois',
            'name' => 'nom',
            'service_id' => 'service',
            'state' => 'état'
        ];
    }

    public function save($planning)
    {
        $validatedData = $this->validate();

        try {
            $planning->created_by =Auth::user()->id;
            $planning->update($validatedData);

            return [
                'status' => true,
                'success' => 'Le planning a été mis à jour avec succès',
            ];
        } catch (\Exception $e) {
            return [
                'status' => false,
                'error' => $e->getMessage(),
            ];
        }
    }
}
