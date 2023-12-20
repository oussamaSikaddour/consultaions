<?php

namespace App\Livewire\ChangePassword;
use App\Livewire\Forms\ChangePassword\changePasswordForm;
use Livewire\Attributes\Js;
use Livewire\Component;

class ChangePassword extends Component
{

    public changePasswordForm $form;


    public function redirectPage(){
        return redirect()->route('logout');
    }



    public function handelSubmit()
    {
        $response = $this->form->save();
        if ($response['status'] === true) {
            // Redirect to the "logout" route by name
            $this->dispatch('redirect-page');
            $this->dispatch('open-toast', $response['response']);
        } else {
            $this->dispatch('open-errors', [$response['response']]);
        }
    }

    public function render()
    {
        return view('livewire.change-password.change-password');
    }
}
