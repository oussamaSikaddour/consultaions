<?php

namespace App\Livewire\Register;

use App\Livewire\Forms\register\FirstForm as RegisterFirstForm;
use Illuminate\Validation\Rule;
use Livewire\Component;

class FirstForm extends Component
{

    public $registrationEmail;
    public RegisterFirstForm $form;

    public function handleSubmit()
    {

        $this->dispatch('form-submitted');
        $this->registrationEmail = $this->form->email;
        $response =  $this->form->save();
       if ($response['status']) {
           $this->dispatch('open-toast', $response['success']); // Corrected the variable name
           $this->dispatch('first-step-succeeded');
            $this->form->reset();
         }else{
            $this->dispatch('open-errors', [$response['error']]);
         }

    }

    public function render()
    {
        return view('livewire.register.first-form');
    }
}
