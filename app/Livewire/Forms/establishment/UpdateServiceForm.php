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
                })->whereNull('deleted_at')->ignore($this->id)
            ],
            'specialty' => [
                'required',
                'string',
                'min:5',
                'max:255',
            ],
            'head_of_service'  => [
                'required',
                'string',
                'min:5',
                'max:255',
                Rule::unique('services','head_of_service')->where(function ($query) {
                    return $query->where('establishment_id', $this->establishment_id);
                })->whereNull('deleted_at')->ignore($this->id)
            ],
        ];
    }

    public function validationAttributes()
    {
        return [
            'id'=>'service',
            'establishment_id' => 'établissement',
            'name' => __("modals.service.name"),
            'specialty'=>__("modals.service.specialty"),
            'head_of_service'=>__("modals.service.head-service"),
        ];
    }

    public function save($service)
    {
        $validatedData = $this->validate();

        try {
            $service->update($validatedData);

            return [
                'status' => true,
                'success' => __("forms.service.update.success-txt")
            ];
        } catch (\Exception $e) {
            return [
                'status' => false,
                'error' => $e->getMessage(),
            ];
        }
    }
}
