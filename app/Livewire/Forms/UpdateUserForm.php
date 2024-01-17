<?php

namespace App\Livewire\Forms;

use App\Models\Occupation;
use App\Models\PersonnelInfo;
use App\Models\User;
use Illuminate\Validation\Rule;
use Livewire\Form;

class UpdateUserForm extends Form
{
    public $id="";
    public $last_name ='';
    public $first_name ='';
    public $birth_date ='';
    public $userable_id="";
    public $userable_type="";
    public $specialty="";
    public $tel ='';




    // Livewire rules
    public function rules()
    {
        if($this->id !==""){
        $user =User::findOrFail($this->id);}

        $rules= [
            'last_name' => 'required|string|min:3|max:100',
            'first_name' => 'required|string|min:3|max:100',
            'birth_date' => 'required|date|before_or_equal:' . now()->subYears(18)->format('Y-m-d'),
            'tel' => [
                'required',
                'regex:/^(05|06|07)\d{8}$/',
                Rule::unique('personnel_infos', "tel")->whereNull('deleted_at')->ignore($user->personnelInfo->user_id ?? null, "user_id"),
            ],
        ];

        if ($this->userable_type === 'doctor') {
            $rules['specialty'] = 'required|string|min:5|max:200';
        }

        return $rules;
    }


    public function validationAttributes()
    {
        return [
            'last_name' => __("modals.user.l-name"),
            'first_name' => __("modals.user.f-name"),
            'birth_date' => __("modals.user.b-date"),
            'tel' => __("modals.user.tel"),
            'specialty'=>__("modals.user.specialty")

        ];
    }


    public function save($user)
    {
       $data =$this->validate();

       try {
        $userId = $user->id;
            $default = [
                "name" => $data['last_name'] . " " . $data['first_name'],
            ];

            $user->update($default);
            $personalInfo = [
                'last_name' => $data['last_name'],
                'first_name' => $data['first_name'],
                'birth_date' => $data['birth_date'],
                'tel' => $data['tel'],
            ];
            $pInfo = PersonnelInfo::where('user_id', $userId)->first();
            $pInfo->update($personalInfo);
            if($user->userable_type==="doctor"){
                $occupationInfo = [
                   'specialty'=>$data['specialty']
                ];
                $occupation = Occupation::where('user_id', $userId)->first();
                $occupation->update($occupationInfo);
            }
        return [
            'status' => true,
            'success' =>__("forms.user.update.success-txt"),
        ];
    } catch (\Exception $e) {
        return [
            'status' => false,
            'error' => $e->getMessage(),
        ];
    }
    }


}
