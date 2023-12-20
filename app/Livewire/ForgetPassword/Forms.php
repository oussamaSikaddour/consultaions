<?php

namespace App\Livewire\ForgetPassword;

use Livewire\Component;

class Forms extends Component
{

    public $isSlide = false;


    public function render()
    {
        return view('livewire.forget-password.forms');
    }
}
