<?php

namespace App\Livewire\Admin;

use App\Models\Establishment;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
use App\Traits\SortableTrait;
use Livewire\Attributes\On;

use function PHPUnit\Framework\isEmpty;

class EstablishmentsTable extends Component
{
    use WithPagination, SortableTrait;

    // Properties with default values
    #[Url()]
    public $name = "";
    #[Url()]
    public $selectedChoice = null;
    #[Url()]
    public $perPage = 1;
    #[Url()]
    public $acronym = "";
    #[Url()]
    public $email = "";


    public function mount() {
        // $this->initializeFilter('perPage', 'Number of items per page:',[
        //     ['1', '1'],
        //     ['5', '5'],
        // ]);

        $this->selectFirstEstablishment();
    }

    public function updated($property)
    {
        // $property: The name of the current property that was updated

        if (($property === 'name' || $property==="acronym" || $property==="email") && count($this->establishments())===0) {
            $this->setSelectedChoiceAndDispatchEvent('unkonwn');
        }
    }
    public function selectFirstEstablishment()
    {
        try {
            if ($this->selectedChoice === null && $this->establishments()->isNotEmpty()) {
                $firstEstablishment = $this->establishments()[0];
                if ($firstEstablishment) {
                    $this->setSelectedChoiceAndDispatchEvent($firstEstablishment->id);
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
    public function establishments()
    {
     return Establishment::query()
            ->where('name', 'like', "%{$this->name}%")
            ->where('email', 'like', "%{$this->email}%")
            ->where('acronym', 'like', "%{$this->acronym}%")
            ->orderBy($this->sortBy, $this->sortDirection)
            ->get();



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




public function placeholder(){

    return view('components.loading',['variant'=>'l']);
}

    public function render()
    {
        return view('livewire.admin.establishments-table');
    }
}
