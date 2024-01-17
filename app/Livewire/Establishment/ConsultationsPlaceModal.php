<?php

namespace App\Livewire\Establishment;

use App\Livewire\Forms\establishment\AddPOCForm;
use App\Livewire\Forms\establishment\UpdatePOCForm;
use App\Models\ConsultationPlace;
use Livewire\Component;

class ConsultationsPlaceModal extends Component
{

    public $establishmentId =null;
    public AddPOCForm $addForm;
    public UpdatePOCForm $updateForm;
    public ConsultationPlace $consultationsPlace;
    public $id = "";

    public function mount()
    {

        if ($this->id !== "") {
            try {
                $this->consultationsPlace = ConsultationPlace::findOrFail($this->id);

                $this->updateForm->fill([
                    'id' => $this->id,
                    'daira' => $this->consultationsPlace->daira,
                    'name' => $this->consultationsPlace->name,
                    'address' => $this->consultationsPlace->address,
                    'tel' => $this->consultationsPlace->tel,
                    'fax' => $this->consultationsPlace->fax,
                    "latitude"=>$this->consultationsPlace->latitude,
                    "longitude"=>$this->consultationsPlace->longitude

                ]);
            } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
                $this->dispatch('open-errors', [$e->getMessage()]);
            }
        }
    }

    public function handleSubmit()
    {
        $response = ($this->id !== "")
            ? $this->updateForm->save($this->consultationsPlace)
            : $this->addForm->save();

        if ($this->id === "") {
            $this->addForm->reset( 'daira','name','address','tel','fax');
        }

        if ($response['status']) {
            $this->dispatch('update-consultations-places-table');
            $this->dispatch('open-toast', $response['success']);
        } else {
            $this->dispatch('open-errors', [$response['error']]);
        }
    }


    public function render()
    {
        return view('livewire.establishment.consultations-place-modal');
    }
}
