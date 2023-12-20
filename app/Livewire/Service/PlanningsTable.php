<?php

namespace App\Livewire\Service;

use App\Models\Planning;
use App\Traits\SortableTrait;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class PlanningsTable extends Component
{

    use WithPagination, SortableTrait;

    // Properties with default values
    #[Url()]
    public $month = "";
    #[Url()]
    public $year ="";
    #[Url()]
    public $name = "";
    #[Url()]
    public $state = "";
    #[Url()]
    public $selectedChoice = null;
    public $serviceId = "";








    public function updated($property)
    {
        // $property: The name of the current property that was updated

        if (($property === 'name' || $property === "year" ||
             $property==="month" || $property === "state") && count($this->plannings())===0) {
            $this->setSelectedChoiceAndDispatchEvent('unkonwn');
        }
    }
    public function selectFirstPlanning()
    {
        try {
            if ($this->selectedChoice === null && $this->plannings()->isNotEmpty()) {
                $firstPlanning = $this->plannings()[0];
                if ($firstPlanning) {
                    $this->setSelectedChoiceAndDispatchEvent($firstPlanning->id);
                }
            }
        } catch (\Exception $e) {
            $this->dispatch('open-errors', [$e->getMessage()]);
        }
    }

    public function setSelectedChoiceAndDispatchEvent($choice)
    {
        $this->selectedChoice = $choice;
        $this->dispatch('set-planning-id-externally', $this->selectedChoice);
    }

    #[Computed]
    public function plannings()
    {

        $query =Planning::query();
         $query->where('service_id', 'like', "%{$this->serviceId}%");
         $query->where('name', 'like', "%{$this->name}%");
         if ($this->state !== "") {
            $query->where('state', $this->state);
        }
         if ($this->year !== "") {
            $query->where('year', $this->year);
        }
         if ($this->month !== "") {
            $query->where('month', $this->month);
        }
            $query->orderBy($this->sortBy, $this->sortDirection);
            return $query->get();
    }



    #[On("delete-planning")]
    public function deletePlanning(Planning $planning)
    {
        try {
            $planning->delete();
        } catch (\Exception $e) {
            $this->dispatch('open-errors', [$e->getMessage()]);
        }
    }



    public function mount()
    {

   $this->selectFirstPlanning();
    $this->year = date('Y');
    // $this->month = date('m');
    $this->initializeFilter('year', 'Année :',app('my_constants')['YEARS']);
    $this->initializeFilter('month', 'Mois :',app('my_constants')['MONTHS_OPTIONS']);
    $this->initializeFilter('state', 'Etat :',app('my_constants')['PLANNING_STATE']);
    }

    public function placeholder(){

        return view('components.loading',['variant'=>'l']);
    }
    public function render()
    {
        return view('livewire.service.plannings-table');
    }
}
