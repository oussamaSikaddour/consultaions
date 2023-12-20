<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use HasFactory, SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $hidden = ["deleted_at"];
    protected $fillable = [
        "establishment_id",
        "name",
        "specialty",
        "head_of_service",
    ];


    public function administrators(): HasMany
    {
        // return $this->hasMany(User::class, "userable_id")
        //     ->with(['personnelInfo' => function ($query) {
        //         $query->select('id', 'user_id', 'tel');
        //     }])
        //     ->where('userable_type', 'admin');
        return $this->hasMany(User::class, "userable_id")
            ->with('personnelInfo')
            ->where('userable_type', 'adminService');
    }
    public function establishment(): BelongsTo
    {
        return $this->belongsTo(Establishment::class);
    }

    public function rendezVous(): hasMany
    {
        return $this->hasMany(RendezVous::class, "patient_id");
    }
    public function plannings(): hasMany
    {
        return $this->hasMany(Planning::class);
    }
}
