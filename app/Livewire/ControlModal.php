<?php

namespace App\Livewire;

use App\Livewire\Forms\AddRendezvousForm;
use App\Models\ConsultationPlace;
use App\Models\Planning;
use App\Models\PlanningDay;
use App\Models\User;
use App\Traits\GeneralTrait;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class ControlModal extends Component
{

    use WithFileUploads,GeneralTrait;
    public $medicalFileId =null;
    public AddRendezvousForm $form;
    public $consultationPlace = "";
    public $daira="";
    public $consultationPlaceOptions = [];
    public $doctorId=null;




    #[Computed()]
    public function consultationsPlaces()
    {
   return  ConsultationPlace::where('daira',$this->daira)->get(['id', 'name']);
    }





    public function updatedDaira()
 {
    $this->consultationPlaceOptions= $this->populateConsultationPlacesOptions($this->consultationsPlaces());
}

 public function mount()
 {
    $this->consultationPlaceOptions= $this->populateConsultationPlacesOptions($this->consultationsPlaces());
try {
    $doctor = User::with('personnelInfo')->findOrFail($this->doctorId);

    $this->form->fill([
        'specialty' =>$doctor->occupations?->first()?->specialty,
        'doctor_id'=>$this->doctorId,
        'type'=>"control",
        'patient_id'=>$this->medicalFileId
    ]);
} catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
    $this->dispatch('open-errors', [$e->getMessage()]);
}
 }


    public function handleSubmit()
    {
        $this->dispatch('form-submitted');
        $response = $this->form->save();
        if ($response['status']) {
            $this->dispatch('update-rendezvous-table');
            $this->dispatch('open-toast', $response['success']);

        } else {
            $this->dispatch('open-errors', [$response['error']]);
        }
    }
    public function render()
    {
        return view('livewire.control-modal');
    }
}
