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
        if ($response['status']) {
            // Redirect to the "logout" route by name
            $this->dispatch('redirect-page');
            $this->dispatch('open-toast', $response['success']);
        } else {
            $this->dispatch('open-errors', [$response['error']]);
        }
    }

    public function render()
    {
        return view('livewire.change-password.change-password');
    }
}
