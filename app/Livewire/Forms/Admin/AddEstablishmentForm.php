<?php

namespace App\Livewire\Forms\Admin;

use App\Models\Establishment;
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
            'acronym' => 'required|string|unique:establishments,acronym|max:10',
            'name' => 'required|string|unique:establishments,name|max:255',
            'email' => 'required|email|unique:establishments,email|max:255',
            'address' => 'required|string|unique:establishments,address|max:255',
            'tel' => 'required|digits:9|unique:establishments,tel',
            'fax' => 'nullable|digits:9|unique:establishments,fax',
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

    public function save()
    {
        $validatedData = $this->validate();

        try {
            Establishment::create($validatedData);

            return [
                'status' => true,
                'success' => "L'établissement a été créé avec succès",
            ];
        } catch (\Exception $e) {
            return [
                'status' => false,
                'error' => $e->getMessage(),
            ];
        }
    }
}
