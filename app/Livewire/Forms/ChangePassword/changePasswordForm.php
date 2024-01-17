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

            'password' => __("forms.change-pwd.pwd"),
            'newPassword' =>__("forms.change-pwd.new-pwd")
            // Add more attribute names as needed
        ];
    }







    public function save()
    {
        $data = $this->validate();
        try {
            $user = Auth::user();

            $isPasswordCorrect = Auth::attempt(['email' => $user->email, 'password' => $data['password']]);

            if(!$isPasswordCorrect){
                throw new \Exception(__("forms.change-pwd.pwd-err"));
            }

            $user["password"] = Hash::make($data['newPassword']);
            $user->update();
            return [
                'status' => true,
                'success' =>__("forms.change-pwd.success-txt"),
            ];
        } catch (\Exception $e) {
            return [
                'status' => false,
                'error' => $e->getMessage(),
            ];
        }
    }

}
