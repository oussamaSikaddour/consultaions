<?php

namespace App\Livewire\Forms\User;

use App\Models\MedicalFile;
use Livewire\Attributes\Rule;
use Livewire\Form;

class UpdateMedicalFileForm extends Form
{
    public $id;
    public $last_name;
    public $first_name;
    public $birth_place;
    public $birth_date;
    public $address;
    public $tel;

    public function rules()
    {

        if($this->id !==""){
            $mf =MedicalFile::findOrFail($this->id);}
        return [
            'last_name' => 'required|string|max:255',
            'first_name' => 'required|string|max:255',
            'birth_place' => 'required|string|max:255',
            'birth_date' => 'required|date',
            'address' => 'required|string|min:10|max:255',
            'tel' => [
                'required',
                'regex:/^(05|06|07)\d{8}$/'
            ],

        ];
    }


            public function validationAttributes()
            {
                return [

                    'last_name' => 'nom',
                     'first_name' => 'prénom',
                     'birth_place' => 'lieu de naissance',
                     'birth_date' => 'date de naissance',
                     'address' => 'adresse actuelle',
                     'tel'=> 'numéro de téléphone'
                ];
            }


    public function save($medicalFile)
    {
        $validatedData = $this->validate();
        try {
            $medicalFile->update($validatedData);
            return [
                'status' => true,
                'success' => 'Le dossier médical a été mis à jour avec succès',
            ];
        } catch (\Exception $e) {
            return [
                'status' => false,
                'error' => $e->getMessage(),
            ];
        }
    }
}
