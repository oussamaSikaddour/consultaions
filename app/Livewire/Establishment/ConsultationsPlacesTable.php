<?php

namespace App\Livewire\Establishment;

use App\Models\ConsultationPlace;
use App\Traits\SortableTrait;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class ConsultationsPlacesTable extends Component
{


    use WithPagination, SortableTrait;

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
    public $selectedChoice = null;






    public function updated($property)
    {
        // $property: The name of the current property that was updated

        if (($property === 'daira' || $property==="name" || $property==="fax" || $property==="tel"  || $property==="address") && count($this->consultationsPlaces())===0) {
            $this->setSelectedChoiceAndDispatchEvent('unkonwn');
        }
    }
    public function selectFirstConsultationPlace()
    {
        try {
            if ($this->selectedChoice === null && $this->consultationsPlaces()->isNotEmpty()) {
                $firstService = $this->consultationsPlaces()[0];
                if ($firstService) {
                    $this->setSelectedChoiceAndDispatchEvent($firstService->id);
                }
            }
        } catch (\Exception $e) {
            $this->dispatch('open-errors', [$e->getMessage()]);
        }
    }

    public function setSelectedChoiceAndDispatchEvent($choice)
    {
        $this->selectedChoice = $choice;
        $this->dispatch('set-userable-id-Externally', $this->selectedChoice);
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


    public function mount()
    {

        $this->selectFirstConsultationPlace();
        $this->initializeFilter('daira', 'Daïra',app('my_constants')['DAIRAS']);

    }

    public function placeholder(){

        return view('components.loading',['variant'=>'l']);
    }
    public function render()
    {
        return view('livewire.establishment.consultations-places-table');
    }
}
