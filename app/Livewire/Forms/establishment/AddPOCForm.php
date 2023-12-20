<?php

namespace App\Livewire\Forms\establishment;

use App\Models\ConsultationPlace;
use Illuminate\Validation\Rule;
use Livewire\Form;

class AddPOCForm extends Form
{
    public $daira="";
    public $name="";
    public $address="";
    public $tel="";
    public $fax="";


    public function rules(){
        return [
            'daira' => 'required|string|min:3|max:100',
            'name' => [
                'required',
                'string',
                'min:5',
                'max:255',
                Rule::unique('consultation_places','name')->where(function ($query) {
                    return $query->where('daira', $this->daira);
                }),
            ],
            'address' => [
                'required',
                'string',
                'min:5',
                'max:255',
                Rule::unique('consultation_places','address')->where(function ($query){
                    return $query->where('daira', $this->daira);
                }),
            ],

            'tel' => [
                'required',
                'digits:9',
                Rule::unique('consultation_places','tel')->where(function ($query) {
                    return $query->where('daira', $this->daira);
                }),
            ],
            'fax' => [
                'nullable',
                'digits:9',
                Rule::unique('consultation_places','fax')->where(function ($query) {
                    return $query->where('daira', $this->daira);
                }),
            ],
        ];
    }

    public function validationAttributes()
    {
        return [
            'daira' => 'Daïra',
            'name' => 'le nom',
            'address'=>"l'addresse",
            'tel'=>'numéro de téléphone',
            'fax'=>'numéro de fax',
        ];
    }

    public function save()
    {
        $validatedData = $this->validate();
        try {
            ConsultationPlace::create($validatedData);

            return [
                'status' => true,
                'success' => 'Le lieu de consultation a été créé avec succès',
            ];
        } catch (\Exception $e) {
            return [
                'status' => false,
                'error' => $e->getMessage(),
            ];
        }
    }
}
