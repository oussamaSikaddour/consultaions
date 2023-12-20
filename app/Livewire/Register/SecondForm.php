<?php

namespace App\Livewire\Register;

use App\Events\Auth\EmailVerificationEvent;
use App\Livewire\Forms\register\SecondForm as RegisterSecondForm;
use App\Models\User;
use Livewire\Attributes\On;
use Livewire\Component;

class SecondForm extends Component
{
    public RegisterSecondForm $form;


    public function setNewValidationCode(){
        try {
            if (session()->has('registration_email')) {
                $user = User::where('email', session('registration_email'))->first();
            }
            event(new EmailVerificationEvent($user));
            $this->dispatch('open-toast','new verification code was sent to your email');
            } catch (\Exception $e) {
                $this->dispatch('open-errors', [$e->getMessage()]);
            }
    }





    #[On('registration-email-set')]
    public function setEmail()
    {
        $this->form->email = session()->has('registration_email')
        ? session('registration_email') : '';
    }

    public function handleSubmit()
    {
        $response =  $this->form->save();
       if ($response['status']) {
        $this->reset();
         config(['session.lifetime' => 120]);
         session()->forget('registration_email');
         $this->dispatch('is-slide-updated', false);
         redirect()->route($response['data'][0], $response['data'][1]);
         }else{
            $this->dispatch('open-errors', [$response['error']]);
         }

    }

    public function mount(){
        $this->form->email = session()->has('registration_email')
        ? session('registration_email') : '';
    }

    public function render()
    {
        return view('livewire.register.second-form');
    }
}
