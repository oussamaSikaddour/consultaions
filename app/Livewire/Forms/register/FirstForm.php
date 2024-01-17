<?php

namespace App\Livewire\Forms\register;

use App\Events\Auth\EmailVerificationEvent;
use App\Models\PersonnelInfo;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Reactive;
use Livewire\Attributes\Rule as AttributesRule;
use Livewire\Form;

class FirstForm extends Form
{
    public $last_name ='';
    public $first_name ='';
    public $birth_date ='';
    public $email ='';
    public $tel ='';
    public $userable_id ='1';
    public $userable_type ='user';
    public $password ="";




    // Livewire rules
    public function rules()
    {
        return [
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users','email')->whereNull('deleted_at'),
            ],
            'userable_type' => 'required|string|max:255',
            'userable_id' => 'required|integer',
            'last_name' => 'required|string|min:3|max:100',
            'first_name' => 'required|string|min:3|max:100',
            'birth_date' => 'required|date|before_or_equal:' . now()->subYears(18)->format('Y-m-d'),
            'password' => 'required|min:8|max:255',
            'tel' => [
                'required',
                'regex:/^(05|06|07)\d{8}$/',
                'unique:personnel_infos,tel'
            ],
        ];
    }


    public function validationAttributes()
    {
        return [
            'last_name' => __('forms.register.first-f.l-name'),
             'first_name' => __('forms.register.first-f.f-name'),
             'birth_date' => __('forms.register.first-f.b-date'),
             'email' => __('forms.register.first-f.email'),
             'password' =>__('forms.register.first-f.password'),
             'tel' => __('forms.register.first-f.tel')
            // Add more attribute names as needed
        ];
    }

// Import the DB facade

    public function save()
    {
        return DB::transaction(function () {
            $data = $this->validate();
            try {
                $default = [
                    "name" => $data['last_name'] . " " . $data['first_name'],
                    'email' => $data['email'],
                    "password" => Hash::make($data['password']),
                    'userable_id' => $data['userable_id'],
                    'userable_type' => $data['userable_type'],
                ];
                $user = User::create($default);

                $personalInfo = [
                    'user_id' => $user->id,
                    'last_name' => $data['last_name'],
                    'first_name' => $data['first_name'],
                    'birth_date' => $data['birth_date'],
                    'tel' => $data['tel'],
                    // Add any other fields from your form here
                ];
                PersonnelInfo::create($personalInfo);

                event(new EmailVerificationEvent($user));

                $defaultRoleSlugs = [config('defaultRole.default_role_slug', 'user')];
                $user->roles()->attach(Role::whereIn('slug', $defaultRoleSlugs)->get());

                return [
                    'status' => true,
                    'success' => __('forms.register.first-f.success-txt'),
                ];
            } catch (\Exception $e) {
                return [
                    'status' => false,
                    'error' => $e->getMessage(),
                ];
            }
        });
    }



}
