<?php

namespace App\Livewire\Forms;

use App\Models\MedicalFile;
use App\Models\PlanningDay;
use App\Models\RendezVous;
use App\Models\User;
use App\Traits\ImageTrait;
use Illuminate\Support\Facades\DB;
use Livewire\Form;

class AddRendezvousForm extends Form
{
    use ImageTrait;
    public $planning_day_id;
    public $consultation_place_id;
    public $patient_id;
    public $day_at;
    public $doctor_id=null;
    public $type;
    public $planningDay;
    public $specialty;
    public $referral_letter;
public function rules()
{
     $commonRules = [
            'specialty' => "required|string|min:3|max:255",
            'consultation_place_id' => 'required|exists:consultation_places,id',
            'doctor_id' => 'required|exists:users,id',
            'type' => 'required|in:normal,control',
            'patient_id' => 'required|exists:users,id',
            'referral_letter' => 'nullable|file|mimes:jpeg,png,gif,ico|max:10000',
        ];
        if ($this->type === 'control') {
            return array_merge($commonRules, [
                'day_at' => 'required|date|after_or_equal:' . now()->addDays(15)->format('Y-m-d'),
            ]);
        }else{
            try {
                $this->planningDay = PlanningDay::with('doctor')->findOrFail($this->planning_day_id);


                return array_merge($commonRules, [
                    'planning_day_id' => 'required|exists:planning_days,id',
                    'referral_letter' => 'required|file|mimes:jpeg,png,gif,ico|max:10000',
                ]);
            } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
                return [
                    'planning_day_id' => 'required|exists:planning_days,id|exists_error',
                ];
            }
        }
 }


    public function messages(): array
    {
        return [
            'consultation_place_id.required' => 'Vous devez sélectionner au moins un lieu de consultation',
            'planning_day_id.required' => 'Vous devez sélectionner une date de rendez-vous.',
            'planning_day_id.exists' => 'La journée de planification sélectionnée est invalide.',
        ];
    }


            public function validationAttributes()
            {
                return [
                    "planning_day_id"=>"planning",
                    "patient_id"=>"dossier médical",
                    "referral_letter"=>"lettre d'orientation",
                    "day_at"=>"date de contrôle"
                ];
            }


            public function save()
            {
                $validatedData = $this->validate();
                try {
                    DB::beginTransaction();
                    $medicalFile = MedicalFile::find($this->patient_id);
                    if (!$medicalFile) {
                        throw new \Exception("aucun dossier médical valide trouvé");
                    }
                    if ($this->type !== 'control') {
                        $planningDay = $this->planningDay;
                        $this->validatePlanningDay($planningDay);
                        $this->updatePlanningDay($planningDay);
                        $validatedData["day_at"] = $planningDay->day_at;
                        $medicalFile->establishment_id = $planningDay->doctor->userable_id;
                    } else {
                        $doctor = User::find($this->doctor_id);
                        $medicalFile->establishment_id = $doctor->userable_id;
                    }
                    $medicalFile->save();
                    $rendezVous = RendezVous::create($validatedData);
                    if (isset($this->referral_letter)) {
                        $this->uploadAndCreateImage($this->referral_letter, $rendezVous->id, "App\Models\RendezVous", "lettre d'orientation");
                    }
                    DB::commit();
                    return [
                        'status' => true,
                        'success' => 'Le rendez-vous a été pris avec succès',
                    ];
                } catch (\Exception $e) {
                    DB::rollBack();
                    return [
                        'status' => false,
                        'error' => $e->getMessage(),
                    ];
                }
            }

            protected function validatePlanningDay($planningDay)
            {
                $numberOfRendezVous = $planningDay->number_of_rendez_vous;
                $numberOfConsultation = $planningDay->number_of_consultation;

                if ($numberOfRendezVous >= $numberOfConsultation) {
                    throw new \Exception("Le nombre maximum de rendez-vous pour cette journée a été atteint. Vous avez mis beaucoup de temps à valider votre choix, un autre patient vient de prendre le dernier rendez-vous");
                }
            }

            protected function updatePlanningDay($planningDay)
            {
                $planningDay->number_of_rendez_vous += 1;

                if ($planningDay->number_of_consultation == $planningDay->number_of_rendez_vous) {
                    $planningDay->state = 'complet';
                }

                $planningDay->save();
            }



}
