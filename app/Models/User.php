<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Enums\RoutesNamesEnum;
use App\Enums\UserableTypesEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable,SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        "userable_id",
        "userable_type"
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'deleted_at'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function images(): MorphMany
    {
        return $this->morphMany(Image::class, 'imageable');
    }


    // public function userable(): MorphTo
    // {
    //     return $this->morphTo();
    // }

    public function roles()
    {
        // return $this->belongsToMany(Role::class, 'role_user'); you don't need to specify the name
        // because eloquent recognize the the pivot the table role_user convention
        return $this->belongsToMany(Role::class)->withTimestamps();
    }
    public function personnelInfo(): HasOne
    {
        return $this->hasOne(PersonnelInfo::class);
    }
    public function occupations(): HasMany
    {
        return $this->hasMany(Occupation::class);
    }

    public function establishment(): BelongsTo
    {
        return $this->belongsTo(Establishment::class, "userable_id");
    }
    public function medicalFiles(): hasMany
    {
        return $this->hasMany(MedicalFile::class, "opened_by");
    }
    public function planningDays(): hasMany
    {
        return $this->hasMany(PlanningDay::class, "doctor_id");
    }



    // public function scopeSearch($query, $value){
    //  $query->where('name','like',"%{$value}%")
    //         ->orWhere('email','like',"%{$value}%");
    // }
    public function getRouteBasedOnUserableType(): array
    {
        switch ($this->userable_type) {
            case UserableTypesEnum::USER_TYPE:
                return [RoutesNamesEnum::USER_ROUTE, []];

            case UserableTypesEnum::ADMIN_TYPE:
                return [RoutesNamesEnum::ADMIN_ROUTE, []];
            case UserableTypesEnum::SERVICE_TYPE:
                return [RoutesNamesEnum::SERVICE_ROUTE, ['id' => $this->userable_id]];

            case UserableTypesEnum::ESTABLISHMENT_TYPE:
                return [RoutesNamesEnum::ESTABLISHMENT_ROUTE, ['id' => $this->userable_id]];

            case UserableTypesEnum::PLACE_OF_CONSULTATION_TYPE:
                return [RoutesNamesEnum::PLACE_Of_CONSULTATION_ROUTE, ['id' => $this->userable_id]];

            case UserableTypesEnum::DOCTOR_TYPE:
                return [RoutesNamesEnum::DOCTOR_ROUTE, []];

            default:
                // Handle any other userable types or provide a default route name.
                return ['noAccess', []];
        }
    }
}
