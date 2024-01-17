<?php

namespace App\Livewire\Forms\Service;

use Illuminate\Validation\Rule;
use Livewire\Form;

class UpdatePlanningDayForm extends Form
{

    public $day_at;
    public $consultation_place_id;
    public $number_of_consultation;


    public function rules()
    {
        $now = now()->toDateString();
        return [

            'consultation_place_id' => 'required|exists:consultation_places,id',
            'day_at' => "required|date|after:$now",
            'number_of_consultation' => 'required|integer|min:0'
        ];
    }

 public function validationAttributes()
    {
                return [
                    'day_at' => __("modals.planning-day.date"),
                    'planning' => 'planning',
                    'consultation_place_id' =>__("modals.planning-day.c-place"),
                    'number_of_consultation' =>__("modals.planning-day.c-number"),
                ];
    }


    public function save($planningDay)
    {
        $validatedData = $this->validate();
        try {
            $planningDay->update($validatedData);
            return [
                'status' => true,
                'success' => __('forms.planning-day.update.success-txt'),
            ];
        } catch (\Exception $e) {
            return [
                'status' => false,
                'error' => $e->getMessage(),
            ];
        }
    }
}
