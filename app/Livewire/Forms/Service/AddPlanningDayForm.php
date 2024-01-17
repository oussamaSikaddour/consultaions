<?php

namespace App\Livewire\Forms\Service;

use App\Models\Planning;
use App\Models\PlanningDay;
use Illuminate\Validation\Rule;
use Livewire\Form;

class AddPlanningDayForm extends Form
{

    public $day_at;
    public $doctor_id;
    public $planning_id;
    public $consultation_place_id;
    public $number_of_consultation;
    // public $number_of_rendez_vous;

    public function rules()
    {
        $now = now()->toDateString();
        return [
            'doctor_id' => [
                'required',
                'exists:users,id',
                Rule::unique('planning_days','doctor_id')->where(function ($query) use ($now) {
                    return $query->where('day_at', $this->day_at);
                })
            ],
            'planning_id' => 'required|exists:plannings,id',
            'consultation_place_id' => 'required|exists:consultation_places,id',
            'day_at' => "required|date|after:$now",
            'number_of_consultation' => 'required|integer|min:0',
            // 'number_of_rendez_vous' => "nullable|integer|min:0|max:$this->number_of_consultation",
        ];
    }


            public function validationAttributes()
            {
                return [
                    'day_at' => __("modals.planning-day.date"),
                    'doctor_id' =>__("modals.planning-day.doctor"),
                    'planning' => 'planning',
                    'consultation_place_id' =>__("modals.planning-day.c-place"),
                    'number_of_consultation' =>__("modals.planning-day.c-number"),
                    // 'number_of_rendez_vous' => 'Nombre de rendez-vous confirmés',
                ];
            }


    public function save()
    {
        $validatedData = $this->validate();
        try {
            PlanningDay::create($validatedData);
            return [
                'status' => true,
                'success' =>__('forms.planning-day.add.success-txt'),
            ];
        } catch (\Exception $e) {
            return [
                'status' => false,
                'error' => $e->getMessage(),
            ];
        }
    }
}
