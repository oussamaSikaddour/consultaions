<?php

namespace App\Livewire\User;

use App\Models\MedicalFile;
use App\Traits\TableTrait;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class MedicalsFilesTable extends Component
{

    use WithPagination,TableTrait;

    // Properties with default values
    #[Url()]
    public $code = "";
    #[Url()]
    public $birthDate ="";
    #[Url()]
    public $lastName = "";
    #[Url()]
    public $firstName = "";
    #[Url()]
    public $selectedChoice = null;
    public $openedBy=null;
    //only when doctor access the table
    public $showForDoctor=false;
    public $doctorId="";


     public function resetFilters(){
    $this->code="";
    $this->firstName="";
    $this->lastName="";
    $this->birthDate="";
    }

    public function callUpdatedSelectedChoiceOnKeyDownEvent(){
        $this->updatedSelectedChoice();
     }
    public function updatedSelectedChoice(){
        $this->dispatch('set-medical-file-id-Externally', $this->selectedChoice);
    }


    public function updated($property)
    {
        // $property: The name of the current property that was updated

        if ($property === 'code' || $property==="lastName" ||
             $property==="firstName" || $property==="birthDate") {
         $this->selectedChoice="empty";
         $this->updatedSelectedChoice();
        }
    }

    #[Computed]
    public function medicalFiles()
    {
        $query =MedicalFile::query()->with("rendezVous");
         if($this->openedBy){
            $query->where('opened_by', $this->openedBy);
         }
         $query->where('first_name', 'like', "%{$this->firstName}%");
         $query->where('last_name', 'like', "%{$this->lastName}%");
         $query->where('code', 'like', "%{$this->code}%");
         if ($this->birthDate !== "") {
            $query->where('birth_date', $this->birthDate);
        }
        if ($this->showForDoctor) {
            $query->whereHas('rendezVous', function ($query) {
                $query->whereHas('planningDay', function ($query) {
                    $query->where('doctor_id', $this->doctorId); // corrected $this->doctor
                });
            });
        }

        $query->orderBy($this->sortBy, $this->sortDirection);
        return $query->get();
    }



    #[On("delete-medical-file")]
    public function deleteMedicalFile(MedicalFile $mf)
    {
        try {
            $mf->delete();
        } catch (\Exception $e) {
            $this->dispatch('open-errors', [$e->getMessage()]);
        }
    }

    public function mount(){
        $this->selectedChoice="empty";
    }

    public function placeholder(){

        return view('components.loading',['variant'=>'l']);
    }
    public function render()
    {
        return view('livewire.user.medicals-files-table');
    }
}
