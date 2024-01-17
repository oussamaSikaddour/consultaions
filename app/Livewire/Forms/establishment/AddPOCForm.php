<?php

namespace App\Livewire\Forms\establishment;

use App\Models\ConsultationPlace;
use App\Rules\LandLineNumberExist;
use Illuminate\Validation\Rule;
use Livewire\Form;

class AddPOCForm extends Form
{
    public $daira="";
    public $name="";
    public $address="";
    public $tel="";
    public $fax="";
    public $latitude="";
    public $longitude="";


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
                })->whereNull('deleted_at'),
            ],
            'address' => [
                'required',
                'string',
                'min:5',
                'max:255',
                Rule::unique('consultation_places','address')->where(function ($query){
                    return $query->where('daira', $this->daira);
                })->whereNull('deleted_at'),

            ],

            'latitude' => [
                'required',
                'string',
                'min:5',
                'max:25',
                Rule::unique('consultation_places','latitude')->where(function ($query){
                    return $query->where('longitude', $this->longitude);
                })->whereNull('deleted_at'),

            ],
            'longitude' => [
                'required',
                'string',
                'min:3',
                'max:25',
                Rule::unique('consultation_places','longitude')->where(function ($query){
                    return $query->where('latitude', $this->latitude);
                })->whereNull('deleted_at'),

            ],

            'tel' => [
                'required',
                'digits:9',
                new LandLineNumberExist(new ConsultationPlace())
              ,
            ],
            'fax' => [
                'nullable',
                'digits:9',
                new LandLineNumberExist(new ConsultationPlace())
            ],
        ];
    }

    public function validationAttributes()
    {
        return [
            'daira' => __('modals.c-place.daira'),
            'name' => __("modals.c-place.name"),
            'address'=>__("modals.c-place.address"),
            'tel'=>__("modals.c-place.land-line-number"),
            'fax'=>__("modals.c-place.fax-number"),
            'longitude'=>__("modals.c-place.longitude"),
            'latitude'=>__("modals.c-place.latitude"),
        ];
    }

    public function save()
    {
        $validatedData = $this->validate();
        try {
            ConsultationPlace::create($validatedData);

            return [
                'status' => true,
                'success' =>__("forms.c-place.add.success-txt"),
            ];
        } catch (\Exception $e) {
            return [
                'status' => false,
                'error' => $e->getMessage(),
            ];
        }
    }
}
