<?php

namespace App\Livewire\Admin;

use App\Livewire\Forms\Admin\AddEstablishmentForm;
use App\Livewire\Forms\Admin\UpdateEstablishmentForm;
use App\Models\Establishment;
use Livewire\Component;

class EstablishmentModal extends Component
{
    public AddEstablishmentForm $addForm;
    public UpdateEstablishmentForm $updateForm;
    public Establishment $establishment;
    public $id = "";

    public function mount()
    {
        if ($this->id !== "") {
            try {
                $this->establishment = Establishment::findOrFail($this->id);

                $this->updateForm->fill([
                    'id' => $this->id,
                    'name' => $this->establishment->name,
                    'acronym' => $this->establishment->acronym,
                    'email' => $this->establishment->email,
                    'address' => $this->establishment->address,
                    'tel' => $this->establishment->tel,
                    'fax' => $this->establishment->fax,
                ]);

            } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
                $this->dispatch('open-errors', [$e->getMessage()]);
            }
        }
    }

    public function handleSubmit()
    {
        $this->dispatch('form-submitted');
        $response = ($this->id !== "")
            ? $this->updateForm->save($this->establishment)
            : $this->addForm->save();

        if ($this->id === "") {
            $this->addForm->reset();
        }

        if ($response['status']) {
            $this->dispatch('update-establishments-table');
            $this->dispatch('open-toast', $response['success']);
        } else {
            $this->dispatch('open-errors', [$response['error']]);
        }
    }

    public function render()
    {
        return view('livewire.admin.establishment-modal');
    }
}
