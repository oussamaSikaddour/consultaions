<?php

namespace App\Livewire\Forms\Admin;

use App\Models\Establishment;
use App\Rules\LandLineNumberExist;
use Illuminate\Validation\Rule;
use Livewire\Form;

class UpdateEstablishmentForm extends Form
{
    public $id;
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
                        ->whereNull('deleted_at')
                        ->ignore($this->id),
                ],
                'name' => [
                    'required',
                    'string',
                     "max:255",
                    Rule::unique('establishments', 'name')
                        ->whereNull('deleted_at')
                        ->ignore($this->id)
                ],
                'email' => [
                    'required',
                    'email',
                     "max:255",
                    Rule::unique('establishments', 'email')
                        ->whereNull('deleted_at')
                        ->ignore($this->id)
                ],
                'address' => [
                    'required',
                    'string',
                     "max:255",
                    Rule::unique('establishments', 'address')
                        ->whereNull('deleted_at')
                        ->ignore($this->id)
                ],
                'tel' => [
                    'required',
                    'digits:9',
                     new LandLineNumberExist(new Establishment(),$this->id)
                ],
                'fax' => ['nullable','digits:9',
                new LandLineNumberExist(new  Establishment(),$this->id)]
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

    public function save($establishment)
    {
        $validatedData = $this->validate();

        try {
            $establishment->update($validatedData);

            return [
                'status' => true,
                'success' =>__("forms.establishment.update.success-txt"),
            ];
        } catch (\Exception $e) {
            return [
                'status' => false,
                'error' => $e->getMessage(),
            ];
        }
    }
}
