<?php

namespace App\Livewire\Forms\User;

use App\Models\MedicalFile;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Rule;
use Livewire\Form;

class AddMedicalFileForm extends Form
{

    public $last_name;
    public $first_name;
    public $birth_place;
    public $birth_date;
    public $address;
    public $tel;

    public function rules()
    {

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


    public function save()
    {
        $validatedData = $this->validate();
        try {
          $this->createMedicalFile($validatedData);
            return [
                'status' => true,
                'success' =>__("forms.m-file.add.success-txt"),
            ];
        } catch (\Exception $e) {
            return [
                'status' => false,
                'error' => $e->getMessage(),
            ];
        }
    }




    protected function createMedicalFile($validatedData)
    {
        $year = date('Y'); // Get the current year
        $lastMedicalFile = MedicalFile::latest('id')->first(); // Get the latest medical file record
        $number = $lastMedicalFile ? intval(substr($lastMedicalFile->code, -1)) + 1 : 1; // Get the next sequential number
        $code = $year . '-' . $number; // Combine the year and number into the code
        $validatedData["email"]=Auth::user()->email;
        $validatedData["opened_by"]=Auth::id();
        $validatedData["code"] = $code;
        return MedicalFile::create($validatedData);
    }
}
