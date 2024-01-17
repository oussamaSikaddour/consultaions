<?php

namespace App\Livewire\Forms\forgetPassword;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Rule;
use Livewire\Form;
use Otp;
class SecondForm extends Form

{

    public $code ='';
    public $email ="";
    public $password ="";

    // Livewire rules
    public function rules()
    {
        return [
            'email' => ['required', 'email', "exists:users,email"],
            'code' => ['required', 'max:6'],
            'password' =>  'required|min:8|max:255'
        ];
    }


    public function validationAttributes()
    {
        return [

            'email' => __('forms.forget-pwd.second-f.email'),
            'password' =>__('forms.forget-pwd.second-f.password'),
            'code' => __('forms.forget-pwd.second-f.code')
            // Add more attribute names as needed
        ];
    }




    public function save()
    {

        // Validate the data
        $data = $this->validate();
        try{
        // Attempt to find the user by email
        $user = User::where('email', $data['email'])->first();

        if (!$user) {
            return [
                'status' => false,
                'error' => __('forms.forget-pwd.second-f.no-user'),
                  ];
        }

        // Create an instance of the Otp class
        $otp = new Otp();

        // Validate the OTP code for the provided email
        $validationResult = $otp->validate($data['email'], $data['code']);

            if ($validationResult->status) {
                   // Update the user's password
                   $user->update(['password' => bcrypt($data['password'])]);

                  // Authenticate the user
                   Auth::login($user);

                  // Get the route information based on the user's type
                     $route = $user->getRouteBasedOnUserableType();
                     return [
                          'status' => true,
                          'data' =>  $route ,
                           ];
               } else {
                  // If the OTP validation fails, create an error message
                      return [
                          'status' => false,
                          'error' => __('forms.forget-pwd.second-f.code-err')
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
