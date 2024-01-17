<?php

namespace App\Livewire\Establishment;

use App\Models\ConsultationPlace;
use App\Traits\GeneralTrait;
use App\Traits\TableTrait;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use Livewire\WithPagination;

class ConsultationsPlacesTable extends Component
{


    use WithPagination, TableTrait,WithFileUploads, GeneralTrait;

    // Properties with default values
    #[Url()]
    public $name = "";
    #[Url()]
    public $daira ="";
    public $perPage = 1;
    #[Url()]
    public $address = "";
    public $tel = "";
    public $fax="";
    #[Url()]
    public $selectedChoice = "empty";




    public function resetFilters(){
        $this->name="";
        $this->daira="";
        $this->address="";
        $this->tel="";
        $this->fax="";
         }
    public function callUpdatedSelectedChoiceOnKeyDownEvent(){
        $this->updatedSelectedChoice();
     }

    public function updatedSelectedChoice(){
        $this->dispatch('set-userable-id-Externally', $this->selectedChoice);
    }




    public function updated($property)
    {
        if($property ==="excelFile"){
            $this->whenExcelFileUploaded("CPlaceImport",
            __('tables.c-places.excel-upload-success-msg')
        );
    }
        if ($property === 'daira' || $property==="name" || $property==="fax" || $property==="tel"  || $property==="address") {
            $this->selectedChoice="empty";
        }
    }




    #[Computed]
    public function consultationsPlaces()
    {
        $query = ConsultationPlace::query();


        if ($this->daira !== "") {
            $query->where('daira', $this->daira);
        }

        $query->where('address', 'like', "%{$this->address}%");
        $query->where('name', 'like', "%{$this->name}%");
        $query->where('tel', 'like', "%{$this->tel}%");
        $query->where('fax', 'like', "%{$this->fax}%");

        // Sort users based on other fields.
        $query->orderBy($this->sortBy, $this->sortDirection);

        // return $query->paginate($this->perPage);
        return $query->get();


    }

    public function updatedPerPage()
    {
        $this->resetPage();
    }

    #[On("delete-consultation-place")]
    public function deleteConsultationPlace(ConsultationPlace $consultationPlace)
    {
        try {
            $consultationPlace->delete();
        } catch (\Exception $e) {
            $this->dispatch('open-errors', [$e->getMessage()]);
        }
    }




    public function generateEmptyCPlacesSheet(){

        return $this->generateEmptyExcelWithHeaders(  "LieuxDeConsultations",
            ["Nom du lieu des consultations","Adresse","latitude","longitude","Numéro de téléphone fixe","Numéro de fax","Daïra"],
          );
    }
    public function mount()
    {

     $this->initializeFilter('daira',
        __('tables.c-places.filters.daira')
        ,app('my_constants')['DAIRAS'][app()->getLocale()]);

    }

    public function placeholder(){

        return view('components.loading',['variant'=>'l']);
    }
    public function render()
    {
        return view('livewire.establishment.consultations-places-table');
    }
}
