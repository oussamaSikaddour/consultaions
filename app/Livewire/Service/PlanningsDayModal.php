<?php

namespace App\Livewire\Service;

use App\Livewire\Forms\Service\AddPlanningDayForm;
use App\Livewire\Forms\Service\UpdatePlanningDayForm;
use App\Models\ConsultationPlace;
use App\Models\Planning;
use App\Models\PlanningDay;
use App\Models\User;
use App\Traits\GeneralTrait;
use Illuminate\Support\Carbon;
use Livewire\Attributes\Computed;
use Livewire\Component;

class PlanningsDayModal extends Component
{
      use GeneralTrait;
    public $planningId = null;
    public $specialty = "";
    public $doctorsOptions = [];
    public $consultationPlaceOptions = [];
    public AddPlanningDayForm $addForm;
    public UpdatePlanningDayForm $updateForm;
    public PlanningDay $planningDay;
    public $id = "";
    public $establishmentId=null;
    public $minDate;

    #[Computed()]
    public function doctors()
    {
        if(session('establishment_id')){
            $this->establishmentId=(session('establishment_id'));
        }
        $users = User::where('userable_id',$this->establishmentId)->whereHas('occupations', function ($query) {
            $query->where('entitled', 'doctor')->where('specialty', 'like', "%{$this->specialty}%");
        })->whereHas('occupations', function ($query) {
            // Only consider the first occupation
            $query->take(1);
        })->get(['id', 'name']);

        return $users;
    }
    #[Computed()]
    public function consultationsPlaces()
    {
        return  ConsultationPlace::get(['id', 'name']);

    }

    public function updatedSpecialty()
    {
        $this->populateDoctorsOptions($this->doctors());
    }
    public function mount()
    {
        $this->populateDoctorsOptions($this->doctors());
        $this->populateConsultationPlacesOptions($this->consultationsPlaces());
        if ($this->id !== "") {
            try {
                $this->planningDay = PlanningDay::findOrFail($this->id);
                $this->updateForm->fill([
                    "id" => $this->id,
                    "planning_id" => $this->planningDay->planning_id,
                    'day_at'=>$this->planningDay->day_at,
                    "consultation_place_id"=>$this->planningDay->consultation_place_id,
                    "number_of_consultation"=>$this->planningDay->number_of_consultation
                ]);
            } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
                $this->dispatch('open-errors', [$e->getMessage()]);
            }
        } else {
            try {
                $this->addForm->planning_id = $this->planningId;
                $planning = Planning::findOrFail($this->planningId);
                 $minDateOfThePlanning = Carbon::createFromDate(
                    $planning->year,
                     $planning->month,
                      1);
                 if($minDateOfThePlanning <= now()){
                    $this->minDate = now()->addDay(3);
                   }elseif($minDateOfThePlanning > now()){
                      $this->minDate = $minDateOfThePlanning;
                   }
                 $this->addForm->day_at = $this->minDate->toDateString();
            } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
                $this->dispatch('open-errors', [$e->getMessage()]);
            }
        }
    }

    public function handleSubmit()
    {
        $response = ($this->id !== "")
            ? $this->updateForm->save($this->planningDay)
            : $this->addForm->save();

        if ($this->id === "") {
            $this->addForm->reset( 'doctor_id','consultation_place_id','number_of_consultation');
        }

        if ($response['status']) {
            $this->dispatch('update-plannings-days-table');
            $this->dispatch('open-toast', $response['success']);
        } else {
            $this->dispatch('open-errors', [$response['error']]);
        }
    }

    public function render()
    {
        return view('livewire.service.plannings-day-modal');
    }
}
