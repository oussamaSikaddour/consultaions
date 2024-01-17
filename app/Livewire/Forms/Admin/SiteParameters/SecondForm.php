<?php

namespace App\Livewire\Forms\Admin\SiteParameters;

use Livewire\Attributes\Validate;
use Livewire\Form;

class SecondForm extends Form
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

    public function validationAttributes()
    {
        return [
            'maintenance' => __('forms.site-params.second-f.state'),
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
                'success' =>  __('forms.site-params.second-f.success-txt'),
            ];
        } catch (\Exception $e) {
            return [
                'status' => false,
                'error'  => $e->getMessage(),
            ];
        }
    }
}
