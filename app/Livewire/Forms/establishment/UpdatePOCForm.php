<?php

namespace App\Livewire\Forms\establishment;

use App\Models\ConsultationPlace;
use App\Rules\LandLineNumberExist;
use Illuminate\Validation\Rule;
use Livewire\Form;

class UpdatePOCForm extends Form
{
    public $id="";
    public $daira="";
    public $name="";
    public $address="";
    public $latitude="";
    public $longitude="";
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
                })->whereNull('deleted_at')->ignore($this->id)

            ],
            'address' => [
                'required',
                'string',
                'min:5',
                'max:255',
                Rule::unique('consultation_places','address')->where(function ($query) {
                    return $query->where('daira', $this->daira);
                })->whereNull('deleted_at')->ignore($this->id)
            ],
            'latitude' => [
                'required',
                'string',
                'min:5',
                'max:25',
                Rule::unique('consultation_places','latitude')->where(function ($query){
                    return $query->where('longitude', $this->longitude);
                })->whereNull('deleted_at')->ignore($this->id),

            ],
            'longitude' => [
                'required',
                'string',
                'min:3',
                'max:25',
                Rule::unique('consultation_places','longitude')->where(function ($query){
                    return $query->where('latitude', $this->latitude);
                })->whereNull('deleted_at')->ignore($this->id),

            ],
            'tel' => [
                'required',
                'digits:9',
                new LandLineNumberExist(new ConsultationPlace(),$this->id)
            ],
            'fax' => [
                'nullable',
                'digits:9',
                new LandLineNumberExist(new ConsultationPlace(),$this->id)
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
    public function save($consultationsPlace)
    {
        $validatedData= $this->validate();

        try {
            $consultationsPlace->update($validatedData);
            return [
                'status' => true,
                'success' =>__('forms.c-place.update.success-txt'),
            ];
        } catch (\Exception $e) {
            return [
                'status' => false,
                'error' => $e->getMessage(),
            ];
        }
    }
}
