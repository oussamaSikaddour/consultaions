<?php

namespace App\Livewire\Establishment;

use App\Livewire\Forms\establishment\AddServiceForm;
use App\Livewire\Forms\establishment\UpdateServiceForm;
use App\Models\Service;
use Livewire\Component;

class ServiceModal extends Component

    {
        public $establishmentId =null;
        public AddServiceForm $addForm;
        public UpdateServiceForm $updateForm;
        public Service $service;
        public $id = "";

        public function mount()
        {

            if ($this->id !== "") {
                try {
                    $this->service = Service::findOrFail($this->id);

                    $this->updateForm->fill([
                        "id" => $this->id,
                        "establishment_id" => $this->service->establishment_id,
                        "name" => $this->service->name,
                        "specialty" => $this->service->specialty,
                        "head_of_service" => $this->service->head_of_service,
                    ]);
                } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
                    $this->dispatch('open-errors', [$e->getMessage()]);
                }
            }else{
                $this->addForm->establishment_id= $this->establishmentId;
            }
        }

        public function handleSubmit()
        {
            $this->dispatch('form-submitted');
            $response = ($this->id !== "")
                ? $this->updateForm->save($this->service)
                : $this->addForm->save();

            if ($this->id === "") {
                $this->addForm->reset( 'name','specialty','head_of_service');
            }

            if ($response['status']) {
                $this->dispatch('update-services-table');
                $this->dispatch('open-toast', $response['success']);
            } else {
                $this->dispatch('open-errors', [$response['error']]);
            }
        }






    public function render()
    {
        return view('livewire.establishment.service-modal');
    }
}
