<?php


namespace App\Livewire;

use App\Livewire\Forms\AddUserForm;
use App\Livewire\Forms\UpdateUserForm;
use App\Models\User;
use Livewire\Component;

class UserModal extends Component
{
    public AddUserForm $addForm;
    public UpdateUserForm $updateForm;
    public User $user;
    public $userableType="";
    public $userableId="";
    public $id = "";

    public function mount()
    {
        if ($this->id !== "") {
            try {
                $this->user = User::with('personnelInfo', 'occupations')->findOrFail($this->id);

                $this->updateForm->fill([
                    'id' => $this->id,
                    'userable_id'=>$this->user->userable_id,
                    'userable_type'=>$this->user->userable_type,
                    'last_name' => $this->user->personnelInfo?->last_name,
                    'first_name' => $this->user->personnelInfo?->first_name,
                    'email' => $this->user->email,
                    'birth_date' => $this->user->personnelInfo?->birth_date,
                    'tel' => $this->user->personnelInfo?->tel,
                    'specialty' =>$this->user->occupations?->first()?->specialty,
                ]);

            } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
                $this->dispatch('open-errors', [$e->getMessage()]);
            }
        }else{
         $this->addForm->fill([
          'userable_id' => $this->userableId,
          'userable_type'=>$this->userableType
         ]);
        }
    }


    public function handleSubmit()
    {

        $response = ($this->id !== "")
            ? $this->updateForm->save($this->user)
            : $this->addForm->save();

        if ($this->id === "") {
            $this->addForm->reset('last_name','first_name','birth_date','email','tel','specialty');
        }

        if ($response['status']) {
            $this->dispatch('update-users-table');
            $this->dispatch('open-toast', $response['success']);
        } else {
            $this->dispatch('open-errors', [$response['error']]);
        }
    }

    public function render()
    {
        return view('livewire.user-modal');
    }
}
