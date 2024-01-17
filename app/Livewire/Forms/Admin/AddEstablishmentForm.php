<?php

namespace App\Livewire\Forms\Admin;

use App\Models\Establishment;
use App\Rules\LandLineNumberExist;
use Illuminate\Validation\Rule;
use Livewire\Form;

class AddEstablishmentForm extends Form
{
    public $acronym = "";
    public $name = "";
    public $email = "";
    public $address = "";
    public $tel = "";
    public $fax = "";

    public function rules()
    {
        return [
            'acronym' => [
                'required',
                'string',
                 "max:10",
                Rule::unique('establishments', 'acronym')
                    ->whereNull('deleted_at'),
            ],
            'name' => [
                'required',
                'string',
                 "max:255",
                Rule::unique('establishments', 'name')
                    ->whereNull('deleted_at'),
            ],
            'email' => [
                'required',
                'email',
                 "max:255",
                Rule::unique('establishments', 'email')
                    ->whereNull('deleted_at'),
            ],
            'address' => [
                'required',
                'string',
                 "max:255",
                Rule::unique('establishments', 'address')
                    ->whereNull('deleted_at'),
            ],
            'tel' => [
                'required',
                'digits:9',
                 new LandLineNumberExist(new Establishment())
            ],
            'fax' => ['nullable','digits:9',
            new LandLineNumberExist(new  Establishment())]
        ];
    }

    public function validationAttributes()
    {
        return [
            'acronym' => __("modals.establishment.acronym"),
            'name' => __("modals.establishment.name"),
            'email' => __('modals.establishment.email'),
            'address' =>__("modals.establishment.address"),
            'tel' =>__('modals.establishment.land-line-number'),
            'fax' =>__('modals.establishment.fax-number'),
        ];
    }

    public function save()
    {
        $validatedData = $this->validate();

        try {
            Establishment::create($validatedData);

            return [
                'status' => true,
                'success' => __("forms.establishment.add.success-txt"),
            ];
        } catch (\Exception $e) {
            return [
                'status' => false,
                'error' => $e->getMessage(),
            ];
        }
    }
}
