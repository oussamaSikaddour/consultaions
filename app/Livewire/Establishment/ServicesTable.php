<?php

namespace App\Livewire\Establishment;
use App\Models\Service;
use App\Traits\SortableTrait;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class ServicesTable extends Component
{
    use WithPagination, SortableTrait;

    // Properties with default values
    #[Url()]
    public $headOfService = "";
    #[Url()]
    public $selectedChoice = null;
    public $perPage = 1;
    #[Url()]
    public $name = "";
    #[Url()]
    public $specialty = "";
    public $establishmentId = "";






    public function updated($property)
    {
        // $property: The name of the current property that was updated

        if (($property === 'name' || $property==="headOfService" || $property==="specialty") && count($this->services())===0) {
            $this->setSelectedChoiceAndDispatchEvent('unkonwn');
        }
    }
    public function selectFirstService()
    {
        try {
            if ($this->selectedChoice === null && $this->services()->isNotEmpty()) {
                $firstService = $this->services()[0];
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




    public function mount()
    {

        $this->selectFirstService();
        // Add the second filter to $filters
        $this->initializeFilter('specialty', 'Spécialité de service :',app('my_constants')['SPECIALTY_OPTIONS']);
    }

    public function placeholder(){

        return view('components.loading',['variant'=>'l']);
    }

    public function render()
    {
        return view('livewire.establishment.services-table');
    }
}
