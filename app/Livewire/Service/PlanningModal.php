<?php

namespace App\Livewire\Service;

use App\Livewire\Forms\Service\AddPlanningForm;
use App\Livewire\Forms\Service\UpdatePlanningForm;
use App\Models\Planning;
use Livewire\Component;

class PlanningModal extends Component
{


    public $serviceId =null;
    public AddPlanningForm $addForm;
    public UpdatePlanningForm $updateForm;
    public Planning $planning;
    public $id = "";

    public function mount()
    {

        if ($this->id !== "") {
            try {
                $this->planning = Planning::findOrFail($this->id);

                $this->updateForm->fill([
                    "id" => $this->id,
                    "service_id" => $this->planning->service_id,
                    "name" => $this->planning->name,
                    "year" => $this->planning->year,
                    "month" => $this->planning->month,
                    "state" => $this->planning->state,
                ]);
            } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
                $this->dispatch('open-errors', [$e->getMessage()]);
            }
        }else{
            $this->addForm->service_id= $this->serviceId;
        }
    }

    public function handleSubmit()
    {
        $response = ($this->id !== "")
            ? $this->updateForm->save($this->planning)
            : $this->addForm->save();

        if ($this->id === "") {
            $this->addForm->reset('month','name');
        }

        if ($response['status']) {

            if($this->id !==""){
                // this event will be dipatched to planning days table when the planning->state is updated
             $this->dispatch('update-plannings-days-table');
            }
            $this->dispatch('update-plannings-table');
            $this->dispatch('open-toast', $response['success']);
        } else {
            $this->dispatch('open-errors', [$response['error']]);
        }
    }


    public function render()
    {
        return view('livewire.service.planning-modal');
    }
}
