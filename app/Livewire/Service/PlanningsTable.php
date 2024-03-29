<?php

namespace App\Livewire\Service;

use App\Models\Planning;
use App\Traits\TableTrait;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
use PhpOffice\PhpSpreadsheet\Calculation\DateTimeExcel\Month;

class PlanningsTable extends Component
{

    use WithPagination, TableTrait;

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
    public $selectedChoice ;
    public $serviceId = "";



    public function resetFilters(){
        $this->month="";
        $this->name="";
        $this->state="";
}
    public function callUpdatedSelectedChoiceOnKeyDownEvent(){
        $this->updatedSelectedChoice();
     }


    public function updatedSelectedChoice(){
        $this->dispatch('set-planning-id-externally',$this->selectedChoice);
    }


    public function updated($property)
    {
        // $property: The name of the current property that was updated
        if ($property === 'name' || $property === "year" ||
             $property==="month" || $property === "state") {
            $this->selectedChoice = 'empty';
            $this->updatedSelectedChoice();
        }
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

     $this->selectedChoice="empty";
    $this->year = date('Y');
    $this->month = date('n');
    $this->initializeFilter(
        'year',
        __('tables.plannings.filters.year'),
         app('my_constants')['YEARS']);
    $this->initializeFilter(
           'month',
            __('tables.plannings.filters.month'),
            app('my_constants')['MONTHS_OPTIONS'][app()->getLocale()]);
    $this->initializeFilter(
            'state',
             __('tables.plannings.filters.state'),
             app('my_constants')['PLANNING_STATE'][app()->getLocale()]);
    }

    public function placeholder(){

        return view('components.loading',['variant'=>'l']);
    }
    public function render()
    {
        return view('livewire.service.plannings-table');
    }
}
