<?php

namespace App\Livewire;

use App\Livewire\Forms\AddRendezvousForm;
use App\Models\ConsultationPlace;
use App\Models\Planning;
use App\Models\PlanningDay;
use App\Models\RendezVous;
use App\Models\User;
use App\Traits\GeneralTrait;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class RendezvousModal extends Component
{

    use WithFileUploads,GeneralTrait;
    public $medicalFileId =null;
    public AddRendezvousForm $form;
    public $daira="";
    public $dateMin;
    public $dateMax;
    public $doctorsOptions = [];
    public $consultationPlaceOptions = [];
    public $temporaryImageUrl=null;
    public $planningDaysOptions =[];
    public $youHaveAlreadyAnUpcomingRendezVous=false;




    #[Computed()]
    public function consultationsPlaces()
    {
   return  ConsultationPlace::where('daira',"like","%{$this->daira}%")->get(['id', 'name']);
    }

    #[Computed()]
    public function doctors()
    {
        $users = User::whereHas('planningDays', function ($query) {
            $query->where('consultation_place_id',$this->form->consultation_place_id);
        })->whereHas('occupations', function ($query) {
            $query->where('entitled', 'doctor')->where('specialty',$this->form->specialty);
        })->whereHas('occupations', function ($query) {
            // Only consider the first occupation
            $query->take(1);
        })->get(['id', 'name']);
        return $users;
    }

    #[Computed()]
public function planningDays()
{
        $query = PlanningDay::query()
        ->whereHas('planning', function ($query) {
            $query->where('state', 'publié');
        })
        ->where('state','incomplet')
        ->where('doctor_id', $this->form->doctor_id);
        if($this->form->consultation_place_id !==""){
        $query->where('consultation_place_id', $this->form->consultation_place_id);
        }
        if ($this->dateMin !== "" && $this->dateMax !== "") {
            $query->whereBetween('day_at', [$this->dateMin, $this->dateMax]);
        } elseif ($this->dateMin !== "") {
            $query->where('day_at', '>=', $this->dateMin)
                  ->where('day_at', '<=', date('Y-m-d', strtotime($this->dateMin . ' +60 days')));
        } else {
            $query->whereBetween('day_at', [
                now()->addDays(1)->toDateString(),
                now()->addDays(60)->toDateString()
            ]);
        }

    return $query->get();

}



public function checkIfTheUserHasAlreadyAnUpcomingRendezVousWithTheSameSpecialty($medicalFileId, $specialty){
    $rendezvous = RendezVous::query()
        ->with('patient')
        ->whereHas('patient', function ($query) use ($specialty, $medicalFileId) {
            $query->where('patient_id', $medicalFileId)
                ->where('specialty', $specialty);
        })
        ->where('day_at', '>', now())
        ->get();

    if(count($rendezvous) > 0) {
        $this->youHaveAlreadyAnUpcomingRendezVous = true;
        $this->dispatch('open-errors', [
            "message" => "Vous avez déjà un rendez-vous à venir avec cette spécialité. Veuillez sélectionner une autre spécialité ou attendre votre rendez-vous."
        ]);
    } else {
        $this->youHaveAlreadyAnUpcomingRendezVous = false;
    }

}



    public function updated($property)
    {
     if($property ==="dateMin"){
      $this->manageTheRendezVousPeriodSelected();
     }

       if($property ==="form.referral_letter" && $this->form->referral_letter){
         try{
            $this->temporaryImageUrl = $this->form->referral_letter->temporaryUrl();
         }catch (\Exception $e) {
            $this->dispatch('open-errors', ["vous devez selection une image"]);
        }
       }
        if ($property === "form.specialty"){
            $this->checkIfTheUserHasAlreadyAnUpcomingRendezVousWithTheSameSpecialty($this->medicalFileId,$this->form->specialty);
            $this->form->consultation_place_id="";
            $this->daira="";
            $this->populateDoctorsOptions($this->doctors());
        }
        if ($property === "form.consultation_place_id"){
           $this->populateDoctorsOptions($this->doctors());
        }
        if ($property === "daira"){
            $this->form->consultation_place_id="";
            $this->form->doctor_id="";
            $this->populateDoctorsOptions($this->doctors());
            $this->populateConsultationPlacesOptions($this->consultationsPlaces());
        }

        if (in_array($property, ['form.doctor_id','daira','form.consultation_place_id', 'dateMin', 'dateMax']) ){

            $this->planningDaysOptions = $this->populateSelectorOption(
                $this->planningDays(),
                fn($pd) => [$pd->id, $pd->day_at],
                "choisir une date");
        }
    }


    public function manageTheRendezVousPeriodSelected(){

        if (isset($this->dateMin)) {
            // If $dateMin is set, calculate the $minDateForDateMax based on it plus 30 days
            $this->dateMax= \Carbon\Carbon::parse($this->dateMin)->addDays(60)->toDateString();

        } else {
            $this->dateMin = now()->addDays(1)->toDateString();
            $this->dateMax = now()->addDays(60)->toDateString();
        }

    }


    public function mount()
    {
        $this->manageTheRendezVousPeriodSelected();
        $this->form->fill([
            'type'=>"normal",
            'patient_id'=>$this->medicalFileId
        ]);
        $this->populateDoctorsOptions($this->doctors());
        $this->populateConsultationPlacesOptions(
        $this->consultationsPlaces()
        );
    }



    public function handleSubmit()
    {
        $response = $this->form->save();
        if ($response['status']) {
            $this->dispatch('update-rendezvous-table');
            $this->dispatch('open-toast', $response['success']);
            $this->form->reset('specialty','planning_day_id','referral_letter','doctor_id');
            $this->temporaryImageUrl=null;
        } else {
            $this->dispatch('open-errors', [$response['error']]);
        }
    }
    public function render()
    {
        return view('livewire.rendezvous-modal');
    }
}
