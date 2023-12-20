<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Nav extends Component
{
    public $forPhone = false;
    public function logout()
    {
        return redirect()->route('logout');
    }
    public function render()
    {
        return view('livewire.nav');
    }
}
