<?php

namespace App\Livewire\ForgetPassword;

use App\Livewire\Forms\forgetPassword\FirstForm as forgetPasswordFirstForm;
use Illuminate\Validation\Rule;
use Livewire\Component;

class FirstForm extends Component
{


    public forgetPasswordFirstForm $form;

    public function updated($property)
    {
     if($property ==="form.email"){
        $this->dispatch('fgp-email-set');
     }
    }
    public function handleSubmit()
    {
        $response =  $this->form->save();
       if ($response['status']) {
           session(['forget-password-email' => $this->form->email]);
           $this->dispatch('open-toast', $response['success']); // Corrected the variable name
           $this->dispatch('is-slide-updated', true);
            $this->form->reset();
         }else{
            $this->dispatch('open-errors', [$response['error']]);
         }

    }

    public function render()
    {
        return view('livewire.forget-password.first-form');
    }
}
