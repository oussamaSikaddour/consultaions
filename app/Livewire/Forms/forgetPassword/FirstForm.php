<?php

namespace App\Livewire\Forms\forgetPassword;

use App\Events\Auth\EmailVerificationEvent;
use App\Models\User;
use Livewire\Attributes\Rule;
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
            'email' => ['required', 'email', "exists:users,email"]
        ];
    }


    public function validationAttributes()
    {
        return [
            'email' => 'email'
            // Add more attribute names as needed
        ];
    }


    public function save()
    {


       $data =$this->validate();
       try{
               $user= User::where("email", $data['email'])->first();
               event(new EmailVerificationEvent($user));
               return [
               'status' => true,
               'success' => 'Un code de vérification a été envoyé à votre adresse e-mail',
                 ];
       } catch (\Exception $e) {
                return [
              'status' => false,
              'error' => $e->getMessage(),
          ];
         }

    }


}
