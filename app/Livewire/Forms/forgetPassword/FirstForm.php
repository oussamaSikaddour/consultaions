<?php

namespace App\Livewire\Forms\forgetPassword;

use App\Events\Auth\EmailVerificationEvent;
use App\Models\User;
use Livewire\Attributes\Rule;
use Livewire\Form;


class FirstForm extends Form
{

    public $email ='';





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
            'email' =>__("forms.forget-pwd.first-f.email")
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
               'success' => __("forms.forget-pwd.first-f.success-txt"),
                 ];
       } catch (\Exception $e) {
                return [
              'status' => false,
              'error' => $e->getMessage(),
          ];
         }

    }


}
