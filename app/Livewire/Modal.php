<?php

namespace App\Livewire;

use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;

class Modal extends Component
{
    public $isOpen = false;
    public $title = "";
    public $type="";
    public $component = [];

    #[On("open-modal")]
    public function openModal($data)
    {
        $this->isOpen = true;
        $this->title = $data['title'];
        $this->type = isset($data['type']) ? $data['type'] : '';
        $this->component = $data['component'];
    }


    public function closeModal()
    {
        $this->isOpen = false;
        $this->title = "";
        $this->type="";
        $this->component =[];
    }

    public function render()
    {
        return view('livewire.modal');
    }
}
