<?php

namespace App\Livewire\Forms\Admin;

use App\Models\Establishment;
use Livewire\Attributes\Rule;
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
            'acronym' => "required|string|min:3|max:10|unique:establishments,acronym," . $this->id,
            'name' => "required|string|min:10|max:255|unique:establishments,name," . $this->id,
            'email' => "required|email|unique:establishments,email," . $this->id,
            'address' => 'required|string|max:255',
            'tel' => [
                'required',
                'digits:9',
            ],
            'fax' => [
                'required',
                'digits:9',
            ],
        ];
    }

    public function validationAttributes()
    {
        return [
            'acronym' => 'abréviation du nom',
            'name' => 'le nom',
            'email' => "l'émail",
            'address' => "l'adresse",
            'tel' => 'numéro du téléphone fixe',
            'fax' => 'numéro du téléphone fax',
        ];
    }

    public function save($establishment)
    {
        $validatedData = $this->validate();

        try {
            $establishment->update($validatedData);

            return [
                'status' => true,
                'success' => "L'établissement a été mis à jour avec succès",
            ];
        } catch (\Exception $e) {
            return [
                'status' => false,
                'error' => $e->getMessage(),
            ];
        }
    }
}
