<?php

namespace App\Livewire\Forms\establishment;

use Illuminate\Validation\Rule;
use Livewire\Form;

class UpdatePOCForm extends Form
{
    public $id="";
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
                })->ignore($this->id)

            ],
            'address' => [
                'required',
                'string',
                'min:5',
                'max:255',
                Rule::unique('consultation_places','address')->where(function ($query) {
                    return $query->where('daira', $this->daira);
                })->ignore($this->id)
            ],

            'tel' => [
                'required',
                'digits:9',
                Rule::unique('consultation_places','tel')->where(function ($query) {
                    return $query->where('daira', $this->daira);
                })->ignore($this->id)
            ],
            'fax' => [
                'nullable',
                'digits:9',
                Rule::unique('consultation_places','fax')->where(function ($query) {
                    return $query->where('daira', $this->daira);
                })->ignore($this->id)
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
    public function save($consultationsPlace)
    {
        $validatedData= $this->validate();

        try {
            $consultationsPlace->update($validatedData);
            return [
                'status' => true,
                'success' => 'Le lieu de consultation a été mis à jour avec succès',
            ];
        } catch (\Exception $e) {
            return [
                'status' => false,
                'error' => $e->getMessage(),
            ];
        }
    }
}
