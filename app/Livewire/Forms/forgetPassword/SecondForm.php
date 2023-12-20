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

            'email' => 'email',
            'password' => 'nouveau mot de passe',
            'code' => 'code de vérification',
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
                'error' => 'aucun utilisateur trouvé avec cet email',
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
                     $routeInfo = $user->getRouteBasedOnUserableType();
                     return [
                          'status' => true,
                          'data' =>  $routeInfo ,
                           ];
               } else {
                  // If the OTP validation fails, create an error message
                      return [
                          'status' => false,
                          'error' => "Le code de vérification n'est pas valide",
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
