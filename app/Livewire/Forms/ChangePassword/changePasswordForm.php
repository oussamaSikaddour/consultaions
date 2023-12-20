<?php

namespace App\Livewire\Forms\ChangePassword;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Rule;
use Livewire\Form;

class changePasswordForm extends Form
{
    public $newPassword ="";
    public $password ="";

    // Livewire rules
    public function rules()
    {

         return [
                'password' => 'required|min:8|max:255',
                'newPassword' => 'required|min:8|max:255|different:form.password',
         ];


    }


    public function validationAttributes()
    {
        return [

            'password' => 'ancien mot de passe',
            'newPassword' => 'nouveau mot de passe',
            // Add more attribute names as needed
        ];
    }




    public function save()
    {
        $data = $this->validate();
        $user = Auth::user();

        $isPasswordCorrect = Auth::attempt(['email' => $user->email, 'password' => $data['password']]);

        if($isPasswordCorrect){

            $user["password"] = Hash::make($data['newPassword']);
            $user->update();
            $response = [
                'status' => $isPasswordCorrect,
                'response' => 'votre mot de passe a été changé. Vous serez maintenant déconnecté.',
            ];

        }else{
            $response = [
                'status' => $isPasswordCorrect,
                'response' => 'Le mot de passe est incorrect',
            ];
        }


        return $response;
    }


}
