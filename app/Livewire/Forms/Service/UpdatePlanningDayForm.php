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
                    'day_at' => 'Date de consultation',
                    'planning' => 'Planning',
                    'consultation_place_id' => 'Lieu de la consultation',
                    'number_of_consultation' => 'Nombre maximum de rendez-vous',
                ];
    }


    public function save($planningDay)
    {
        $validatedData = $this->validate();
        try {
            $planningDay->update($validatedData);
            return [
                'status' => true,
                'success' => 'Le jour de planification a été mis à jour avec succès',
            ];
        } catch (\Exception $e) {
            return [
                'status' => false,
                'error' => $e->getMessage(),
            ];
        }
    }
}
