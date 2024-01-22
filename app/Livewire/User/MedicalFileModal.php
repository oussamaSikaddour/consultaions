<?php

namespace App\Livewire\User;

use App\Livewire\Forms\User\AddMedicalFileForm;
use App\Livewire\Forms\User\UpdateMedicalFileForm;
use App\Models\MedicalFile;
use Livewire\Component;

class MedicalFileModal extends Component
{




    public AddMedicalFileForm $addForm;
    public UpdateMedicalFileForm $updateForm;
    public MedicalFile $medicalFile;
    public $id = "";




    public function mount()
    {

        if ($this->id !== "") {
            try {
                $this->medicalFile = MedicalFile::findOrFail($this->id);

                $this->updateForm->fill([
                    "id" => $this->id,
                    'last_name'=>$this->medicalFile->last_name,
                    'first_name'=>$this->medicalFile->first_name,
                    'birth_date'=>$this->medicalFile->birth_date,
                    'birth_place'=>$this->medicalFile->birth_place,
                    'address'=>$this->medicalFile->address,
                    'tel'=>$this->medicalFile->tel,
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
            ? $this->updateForm->save($this->medicalFile)
            : $this->addForm->save();
        if ($this->id === "") {
            $this->addForm->reset();
        }
        if ($response['status']) {
            $this->dispatch('update-medical-files-table');
            $this->dispatch('open-toast', $response['success']);
        } else {
            $this->dispatch('open-errors', [$response['error']]);
        }
    }

    public function render()
    {
        return view('livewire.user.medical-file-modal');
    }
}
