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
                    'last_name' =>__("modals.m-file.l-name"),
                    'first_name' =>__("modals.m-file.f-name"),
                    'birth_date' =>__("modals.m-file.birth-d"),
                    'address' =>__("modals.m-file.address"),
                    'tel'=>__("modals.m-file.phone-number")
                ];
            }


    public function save($medicalFile)
    {
        $validatedData = $this->validate();
        try {
            $medicalFile->update($validatedData);
            return [
                'status' => true,
                'success' => __('forms.m-file.update.success-txt'),
            ];
        } catch (\Exception $e) {
            return [
                'status' => false,
                'error' => $e->getMessage(),
            ];
        }
    }
}
