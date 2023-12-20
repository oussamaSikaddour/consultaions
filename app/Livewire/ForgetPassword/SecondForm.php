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




public function mount(){
    $this->form->email = session()->has('forget-password-email')
    ? session('forget-password-email') : '';
}
    #[On('fgp-email-set')]
    public function setEmail()
    {
        $this->form->email = session()->has('forget-password-email')
        ? session('forget-password-email') : '';
    }

    public function handleSubmit()
    {
        $response =  $this->form->save();
       if ($response['status']) {
        $this->reset();
         session()->forget('forget-password-email');
         $this->dispatch('is-slide-updated', false);
         redirect()->route($response['data'][0], $response['data'][1]);
         }else{
            $this->dispatch('open-errors', [$response['error']]);
         }

    }

    public function render()
    {
        return view('livewire.forget-password.second-form');
    }
}
