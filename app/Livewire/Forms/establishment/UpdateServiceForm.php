<?php

namespace App\Livewire\Forms\establishment;

use Illuminate\Validation\Rule;
use Livewire\Form;

class UpdateServiceForm extends Form
{
    public $id="";
    public $establishment_id="";
    public $name = "";
    public $specialty="";
    public $head_of_service="";

    public function rules()
    {


        return [
            'establishment_id' => 'required|exists:establishments,id',
            'name' => [
                'required',
                'string',
                'min:5',
                'max:255',
                Rule::unique('services','name')->where(function ($query) {
                    return $query->where('establishment_id', $this->establishment_id);
                })->ignore($this->id)
            ],
            'specialty' => [
                'required',
                'string',
                'min:5',
                'max:255',
                Rule::unique('services','specialty')->where(function ($query){
                    return $query->where('establishment_id', $this->establishment_id);
                })->ignore($this->id)
            ],
            'head_of_service'  => [
                'required',
                'string',
                'min:5',
                'max:255',
                Rule::unique('services','head_of_service')->where(function ($query) {
                    return $query->where('establishment_id', $this->establishment_id);
                })->ignore($this->id)
            ],
        ];
    }

    public function validationAttributes()
    {
        return [
            'id'=>'service',
            'establishment_id' => 'établissement',
            'name' => 'nom',
            'specialty'=>'specialty',
            'head_of_service'=>'chef de service',
        ];
    }

    public function save($service)
    {
        $validatedData = $this->validate();

        try {
            $service->update($validatedData);

            return [
                'status' => true,
                'success' => "Le service a été mis à jour avec succès",
            ];
        } catch (\Exception $e) {
            return [
                'status' => false,
                'error' => $e->getMessage(),
            ];
        }
    }
}
