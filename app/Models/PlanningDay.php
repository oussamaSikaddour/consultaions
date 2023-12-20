<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class PlanningDay extends Model
{
    use HasFactory ,SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $hidden = ["deleted_at"];
    protected $fillable = [
        "doctor_id",
        "planning_id",
        "day_at",
        "number_of_consultation",
        "number_of_rendez_vous",
        "state",
        "consultation_place_id"
    ];

    public function planning(): BelongsTo
    {
        return $this->belongsTo(Planning::class);
    }
    public function consultationPlace(): BelongsTo
    {
        return $this->belongsTo(ConsultationPlace::class);
    }

    public function doctor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    public function rendezVous(): HasMany
    {
        return $this->hasMany(RendezVous::class);
    }
}
