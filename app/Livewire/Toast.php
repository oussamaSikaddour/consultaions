<?php

namespace App\Livewire;

use Illuminate\Support\Js;
use Livewire\Attributes\On;
use Livewire\Component;

class Toast extends Component
{
    public $isOpen = false;
    public $message = "";
    #[On('open-toast')]
    public function openToast($message)
    {
        $this->message = $message;
        $this->isOpen = true;

    }

    public function closeToast()
    {
        $this->isOpen = false;
    }


    public function render()
    {
        return view('livewire.toast');
    }
}
