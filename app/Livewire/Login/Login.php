<?php

namespace App\Livewire\Login;

use App\Livewire\Forms\Login\LoginForm;
use Livewire\Component;

class Login extends Component
{

    public LoginForm $form;

    public function handelSubmit()
    {

        $response =  $this->form->save();
        $this->form->reset();
       if ($response['status']) {
        return redirect()->route($response['data']);
       }else{
         $this->dispatch('open-errors', [$response['error']]);
         }
    }
    public function render()
    {
        return view('livewire.login.login');
    }
}
