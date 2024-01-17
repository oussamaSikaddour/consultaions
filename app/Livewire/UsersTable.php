<?php

namespace App\Livewire;

use App\Models\Service;
use App\Models\User;
use App\Traits\TableTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class UsersTable extends Component
{
use WithPagination, TableTrait;
#[Url()]
public $fullName = "";
#[Url()]
public $perPage = 1;
#[Url()]
public $userableType="";
#[Url()]
public $userableId=null;
#[Url()]
public $specialty="";
#[Url()]
public $email = "";
public $customNoUserFoundMessage;
public $defaultNoUserFoundMessage;
public $showForSuperAdmin=false;
public $showForAdminService=false;



public function resetFilters(){
$this->fullName="";
$this->specialty="";
$this->email="";
}

public function mount()
{
$this->defaultNoUserFoundMessage= __('tables.users.not-found');
if($this->userableType === "doctor"){
    $this->initializeFilter('specialty', __('tables.users.filters.specialty'),app('my_constants')['SPECIALTY_OPTIONS'][app()->getLocale()]);
}

if($this->showForSuperAdmin  ){
    $this->initializeFilter(
        'userableType',
        __('tables.users.filters.user-type'),
        app("my_constants")["USER_TYPES"][app()->getLocale()]
);


}
$this->specialty = $this->showForAdminService
                   ? Service::find(session('service_id'))->specialty
                  : "";
}
#[On('set-userable-id-Externally')]
public function setUserableIdExternally($selectedValue){
$this->userableId = $selectedValue;
}


#[Computed]
public function users()
{
        $query = User::query();
        $query->leftJoin('personnel_infos', 'users.id', '=', 'personnel_infos.user_id');
        if($this->userableType ==="doctor"){
            $query->leftJoin('occupations', 'users.id', '=', 'occupations.user_id');
        }
        if ($this->userableType !== "") {
            $query->where('userable_type', $this->userableType);
        }

        if ($this->userableId || !$this->showForSuperAdmin) {
            $query->where('userable_id', $this->userableId);
        }

        $query->where('email', 'like', "%{$this->email}%");
        $query->where('name', 'like', "%{$this->fullName}%");

        if($this->specialty !==""){
            $query->whereHas('occupations', function ($query) {
                $query->where('specialty',$this->specialty);
            })->whereHas('occupations', function ($query) {
                $query->take(1);
            });
        }

        if($this->userableType ==="doctor"){
            $query->select('users.*', 'personnel_infos.last_name', 'personnel_infos.first_name', 'personnel_infos.tel','occupations.specialty');
        }else{
            $query->select('users.*', 'personnel_infos.last_name', 'personnel_infos.first_name', 'personnel_infos.tel');
        }


        // Sort users based on other fields.
        $query->orderBy($this->sortBy, $this->sortDirection);

        // return $query->paginate($this->perPage);
        return $query->get();


}





public function updatedPerPage()
{
    $this->resetPage();
}

public function generateUsersExcel(){
    return $this->generateExcel(function() {
        return $this->users()->map(function ($user) {
            return [
                __("tables.users.fullName")=> $user->name,
                __("tables.users.email") => $user->email,
                __("tables.users.registration-date") => $user->created_at->format('d/m/Y'),
                __("tables.users.phone")=> $user->tel,
            ];
        })->toArray();
    }, "users");
}



#[On("delete-user")]
public function deleteUser(User $user){
    $user->delete();
}


public function placeholder(){

    return view('components.loading',['variant'=>'l']);
}


public function render()
    {
        return view('livewire.users-table');
    }
}
