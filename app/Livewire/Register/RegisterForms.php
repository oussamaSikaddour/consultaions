<?php

namespace App\Livewire\Register;

use Livewire\Component;

class RegisterForms extends Component
{

    public $isSlide = false;

    public function mount(){
        if (session()->has('registration_email')) {
          $this->isSlide = true;
        }
    }
    public function render()
    {
        return view('livewire.register.register-forms');
    }
}
