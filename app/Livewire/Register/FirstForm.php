<?php

namespace App\Livewire\Register;

use App\Livewire\Forms\register\FirstForm as RegisterFirstForm;
use Illuminate\Validation\Rule;
use Livewire\Component;

class FirstForm extends Component
{


    public RegisterFirstForm $form;

    public function updated($property)
    {
     if($property ==="form.email"){
        $this->dispatch('registration-email-set');
     }
    }
    public function handleSubmit()
    {
        $response =  $this->form->save();
       if ($response['status']) {
           session(['registration_email' => $this->form->email]);
           $this->dispatch('open-toast', $response['success']); // Corrected the variable name
           $this->dispatch('is-slide-updated', true);
           config(['session.lifetime' => 20160]);
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
