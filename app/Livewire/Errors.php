<?php

namespace App\Livewire;
use Livewire\Attributes\On;
use Livewire\Component;

class Errors extends Component
{
    public $isOpen = false;

    public $errors = [];

    #[On('open-errors')]
    public function openErrors($errors)
    {
        $this->errors = $errors;
        $this->isOpen = true;
    }

    public function closeErrors()
    {
        $this->isOpen = false;
    }

    public function render()
    {
        return view('livewire.errors');
    }
}
