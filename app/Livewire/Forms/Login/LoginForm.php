<?php

namespace App\Livewire\Forms\Login;
use Illuminate\Support\Facades\Auth;
use Livewire\Form;

class LoginForm extends Form
{
    public $email ="";
    public $password ="";

    // Livewire rules
    public function rules()
    {
        return [
            'email' => ['required', 'email', "exists:users,email"],
            'password' =>  'required|min:8|max:255'
        ];
    }


    public function validationAttributes()
    {
        return [

            'email' => __('forms.login.email'),
            'password' => __('forms.login.password'),
            // Add more attribute names as needed
        ];
    }




    public function save()
    {
        // // Validate the data
        $data = $this->validate();


        try {

                if (Auth::attempt($data)) {
                   session()->regenerate();
                  $user = Auth::user();
                   $route = $user->getRouteBasedOnUserableType();
                    return  [
                       'status'=>true,
                       'data'=> $route
                     ];
                   } else {
                  return [
                    'status' => false,
                       'error' => __('forms.login.no-user-err'),
                   ];
                   }

        } catch (\Exception $e) {
            return [
                'status' => false,
                'error' => $e->getMessage(),
            ];
        }
    }



}
