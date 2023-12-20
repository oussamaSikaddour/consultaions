<?php

namespace App\Livewire\Forms\establishment;

use App\Models\Service;
use Illuminate\Validation\Rule;
use Livewire\Form;

class AddServiceForm extends Form
{
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
                    }),
                ],
                'specialty' => [
                    'required',
                    'string',
                    'min:5',
                    'max:255',
                    // Rule::unique('services','specialty')->where(function ($query)  {
                    //     return $query->where('establishment_id', $this->establishment_id);
                    // }),
                ],
                'head_of_service'  => [
                    'required',
                    'string',
                    'min:5',
                    'max:255',
                    Rule::unique('services','head_of_service')->where(function ($query)  {
                        return $query->where('establishment_id', $this->establishment_id);
                    }),
                ],
            ];

    }

    public function validationAttributes()
    {
        return [
            'establishment_id' => 'établissement',
            'name' => 'le nom',
            'specialty'=>'specialty',
            'head_of_service'=>'chef de service',
        ];
    }

    public function save()
    {
        $validatedData = $this->validate();
        try {
            Service::create($validatedData);

            return [
                'status' => true,
                'success' => "le service a été créé avec succès",
            ];
        } catch (\Exception $e) {
            return [
                'status' => false,
                'error' => $e->getMessage(),
            ];
        }
    }
}
