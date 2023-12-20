<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ConsultationPlace extends Model
{
    use HasFactory, SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $hidden = ["deleted_at"];
    protected $fillable = [
        "name",
        "address",
        "tel",
        "fax",
        "daira"

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
            ->where('userable_type', 'adminConsultationPlace');
    }
}
