<?php

namespace App\Livewire\Admin;
use App\Models\Establishment;
use App\Traits\GeneralTrait;
use App\Traits\TableTrait;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

use Livewire\Attributes\On;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class EstablishmentsTable extends Component
{
    use WithPagination,TableTrait ,GeneralTrait,WithFileUploads;

    // Properties with default values
    #[Url()]
    public $name = "";
    #[Url()]
    public $selectedChoice="empty";
    #[Url()]
    public $perPage = 1;
    #[Url()]
    public $acronym = "";
    #[Url()]
    public $email = "";
    public $uploadFunction;


    public function resetFilters(){
   $this->acronym="";
   $this->email="";
   $this->name="";
    }

    public function callUpdatedSelectedChoiceOnKeyDownEvent(){
       $this->updatedSelectedChoice();
    }

    public function updatedSelectedChoice(){
        $this->dispatch('set-userable-id-Externally', $this->selectedChoice);
    }
    public function updated($property)
    {
        // $property: The name of the current property that was updated
        if($property ==="excelFile"){
            $this->whenExcelFileUploaded("EstablishmentImport",
            __('tables.establishments.excel-upload-success-msg')
        );
        }
        if ($property === 'name' || $property==="acronym" || $property==="email") {
            $this->selectedChoice="empty";
        }
    }


    #[Computed]
    public function establishments()
    {
     return Establishment::query()
            ->where('name', 'like', "%{$this->name}%")
            ->where('email', 'like', "%{$this->email}%")
            ->where('acronym', 'like', "%{$this->acronym}%")
            ->orderBy($this->sortBy, $this->sortDirection)
            ->get();
    }


public function generateEmptyEstablishmentsSheet(){

    return $this->generateEmptyExcelWithHeaders(  "establishments",
        ["ABRÉVIATION DU NOM","NOM","EMAIL","ADRESSE","NUMÉRO DU FIX","NUMÉRO DU FAX"],
      );
}


    public function updatedPerPage()
    {
        $this->resetPage();
    }

    #[On("delete-establishment")]
    public function deleteEstablishment(Establishment $establishment)
    {
        try {
            $establishment->delete();
        } catch (\Exception $e) {
            $this->dispatch('open-errors', [$e->getMessage()]);
        }
    }



public function rendered(){
    $this->dispatch('html-content-rendered')->self();
}

public function placeholder(){

    return view('components.loading',['variant'=>'l']);
}

    public function render()
    {


        return view('livewire.admin.establishments-table');
    }
}
