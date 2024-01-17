<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Enums\UserableTypesEnum;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        Gate::define('user-access', function ($user) {
            return $user->userable_type === UserableTypesEnum::USER_TYPE;
        });

        Gate::define('admin-access', function ($user) {
            return $user->userable_type === UserableTypesEnum::ADMIN_TYPE;
        });

        Gate::define('admin-service-access', function ($user) {
            $id =  session('service_id') ;
            if (
            $id !== null  && $user->userable_type === UserableTypesEnum::SERVICE_TYPE && $user->userable_id == $id) {
                return true;
            }
            return false;
        });


        Gate::define('admin-establishment-access', function ($user) {


             $id= session('establishment_id');
            if ($id !== null && $user->userable_type === UserableTypesEnum::ESTABLISHMENT_TYPE && $user->userable_id == $id) {
                return true;
            }
            return false;
        });



        Gate::define('admin-place-of-consultation-access', function ($user) {
            $id =   session('consultation_place_id');
            if ($id !== null && $user->userable_type === UserableTypesEnum::PLACE_OF_CONSULTATION_TYPE && $user->userable_id == $id) {
                return true;
            }
            return false;
        });

        Gate::define('doctor-access', function ($user) {
            return $user->userable_type === UserableTypesEnum::DOCTOR_TYPE;
        });
    }
}
