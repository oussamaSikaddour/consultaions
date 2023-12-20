<?php

namespace App\Livewire\Forms\Login;

use App\Models\Service;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Rule;
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

            'email' => 'email',
            'password' => 'mot de passe',
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

                if ($user->userable_type === "admin_service") {
                // Find the associated service using userable_id
                      $service = Service::with('establishment')->where('id', $user->userable_id)->first();
                    if ($service) {
                    // Retrieve information about the establishment associated with the service
                       $establishment = $service->establishment;
                       if ($establishment) {
                        // Set a session key 'establishment_id' with the establishment's ID
                           session(['establishment_id' => $establishment->id]);
                        }
                     }
                   }
                   $routeInfo = $user->getRouteBasedOnUserableType();
                    return  [
                       'status'=>true,
                       'data'=> $routeInfo
                     ];
                   } else {
                  return [
                    'status' => false,
                       'error' => "Aucun utilisateur correspondant trouvé avec l'e-mail et le mot de passe fournis",
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
