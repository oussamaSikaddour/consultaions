<?php

namespace App\Livewire\Forms\Admin;

use Livewire\Attributes\Validate;
use Livewire\Form;

class MaintenanceModeForm extends Form
{

    public $maintenance;
    public function rules()
    {
        return [
            'maintenance' => [
                'required',
                'boolean',
            ],
            // Add more attribute names as needed
        ];
    }


    public function save($generalSettings)
    {
        $validatedData = $this->validate();
        try {
            $generalSettings->update($validatedData);
            return [
                'status'  => true,
                'success' => "Vous avez modifié l'état de maintenance avec succès",
            ];
        } catch (\Exception $e) {
            return [
                'status' => false,
                'error'  => $e->getMessage(),
            ];
        }
    }
}
