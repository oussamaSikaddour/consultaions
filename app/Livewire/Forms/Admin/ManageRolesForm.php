<?php

namespace App\Livewire\Forms\Admin;


use App\Models\User;
use Livewire\Form;

class ManageRolesForm extends Form
{

public $roles =[];

    public function rules()
    {
        return [
            'roles'   => ['required', 'array'],
            'roles.*' => ['exists:roles,id'],
        ];
    }

    public function validationAttributes()
    {
        return [
            'roles' => 'les privileges'
            // Add more attribute names as needed
        ];
    }


    public function save($user)
    {
        $validatedData = $this->validate();
        try {
            $user->roles()->sync($validatedData['roles']);
            return [
                'status'  => true,
                'success' => "Les rôles ont été modifiés avec succès",
            ];
        } catch (\Exception $e) {
            return [
                'status' => false,
                'error'  => $e->getMessage(),
            ];
        }
    }
}
