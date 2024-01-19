<?php

namespace App\Livewire\Forms;

use App\Events\Auth\GeneratePasswordEvent;
use App\Models\Occupation;
use App\Models\PersonnelInfo;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Livewire\Form;

class AddUserForm extends Form
{
    public $last_name ='';
    public $first_name ='';
    public $birth_date ='';
    public $email ='';
    public $tel ='';
    public $userable_id="";
    public $userable_type="";
    public $specialty="";



    // Livewire rules
    public function rules()
    {
        $rules = [
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users', 'email')->whereNull('deleted_at'),
            ],
            'last_name' => 'required|string|min:3|max:100',
            'first_name' => 'required|string|min:3|max:100',
            'birth_date' => 'required|date|before_or_equal:' . now()->subYears(18)->format('Y-m-d'),
            'tel' => [
                'required',
                'regex:/^(05|06|07)\d{8}$/',
                'unique:personnel_infos,tel',
            ],
        ];

        // Add a conditional rule for 'specialty'
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
            'email' => __("modals.user.email"),
            'tel' => __("modals.user.tel"),
            'specialty'=>__("modals.user.specialty")

        ];
    }






    public function save()
    {
        $data = $this->validate();

        try {
            return DB::transaction(function () use ($data) {
                // $password = Str::password(8,symbols:false);
                $password="test=test";
                $default = [
                    "name" => $data['last_name'] . " " . $data['first_name'],
                    'email' => $data['email'],
                    "password" => Hash::make($password),
                    'userable_id' => $this->userable_id,
                    'userable_type' => $this->userable_type,
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
                if ($this->userable_type === "doctor") {
                    $occupation = [
                        'entitled'=>"doctor",
                        'user_id' => $user->id,
                        'field' => 'Medicine',
                        'specialty' => $data['specialty'],
                        // Add any other fields from your form here
                    ];
                    Occupation::create($occupation);
                }
                // event(new GeneratePasswordEvent($user, $password));
                $defaultRoleSlugs = [config('defaultRole.default_role_slug', 'user')];
                if ($this->userable_type === "admin") {
                    $defaultRoleSlugs = ['user', 'admin'];
                }

                $user->roles()->attach(Role::whereIn('slug', $defaultRoleSlugs)->get());

                return [
                    'status' => true,
                    'success' => __("forms.user.add.success-txt"),
                ];
            });
        } catch (\Exception $e) {
            return [
                'status' => false,
                'error' => $e->getMessage(),
            ];
        }
    }




}
