<?php

namespace App\Livewire\Establishment;
use App\Models\Service;
use App\Traits\TableTrait;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use Livewire\WithPagination;

class ServicesTable extends Component
{
    use WithPagination, TableTrait,WithFileUploads;

    // Properties with default values
    #[Url()]
    public $headOfService = "";
    #[Url()]
    public $selectedChoice = "empty";
    public $perPage = 1;
    #[Url()]
    public $name = "";
    #[Url()]
    public $specialty = "";
    public $establishmentId = "";


public function resetFilters(){
$this->headOfService="";
$this->specialty="";
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
        if($property ==="excelFile"){
            $this->whenExcelFileUploaded("ServiceImport",
            __('tables.services.excel-upload-success-msg')
        );
    }
        if ($property === 'name' || $property==="headOfService" || $property==="specialty") {
            $this->selectedChoice="empty";
        }
    }

    #[Computed]
    public function services()
    {
     return Service::query()
            ->where('name', 'like', "%{$this->name}%")
            ->where('head_of_service', 'like', "%{$this->headOfService}%")
            ->where('specialty', 'like', "%{$this->specialty}%")
            ->where('establishment_id', 'like', "%{$this->establishmentId}%")
            ->orderBy($this->sortBy, $this->sortDirection)
            ->get();



    }

    public function updatedPerPage()
    {
        $this->resetPage();
    }

    #[On("delete-service")]
    public function deleteService(Service $service)
    {
        try {
            $service->delete();
        } catch (\Exception $e) {
            $this->dispatch('open-errors', [$e->getMessage()]);
        }
    }




    public function generateEmptyServicesSheet(){

        return $this->generateEmptyExcelWithHeaders(  "services",
            ["Nom DU SERVICE","CHEF DE SERVICE","SPÉCIALITÉ DE SERVICE"],
          );
    }

    public function mount()
    {

        // Add the second filter to $filters
        $this->initializeFilter('specialty',
                                __('tables.services.filters.specialty'),
                                app('my_constants')['SPECIALTY_OPTIONS'][app()->getLocale()]);
    }

    public function placeholder(){

        return view('components.loading',['variant'=>'l']);
    }

    public function render()
    {
        return view('livewire.establishment.services-table');
    }
}
