<?php

namespace App\Livewire\ForgetPassword;

use App\Events\Auth\EmailVerificationEvent;
use App\Livewire\Forms\forgetPassword\SecondForm as FGPSecondForm;
use App\Models\User;
use Livewire\Attributes\On;
use Livewire\Component;

class SecondForm extends Component
{
    public FGPSecondForm $form;



    public function setEmail($email){
        $this->form->email = $email;
    }

    public function handleSubmit()
    {
        $this->dispatch('form-submitted');
        $response =  $this->form->save();
       if ($response['status']) {
        $this->reset();
         session()->forget('forget-password-email');
         $this->dispatch('second-step-succeeded');
         redirect()->route($response['data']);
         }else{
            $this->dispatch('open-errors', [$response['error']]);
         }

    }

    public function render()
    {
        return view('livewire.forget-password.second-form');
    }
}
