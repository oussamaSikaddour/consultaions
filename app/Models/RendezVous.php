<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class RendezVous extends Model
{
    use HasFactory ,SoftDeletes;
    protected $table = 'rendez_vous';
    protected $dates = ['deleted_at'];
    protected $hidden = ["deleted_at"];
    protected $fillable = [
        "patient_id",
        "planning_day_id",
        'consultation_place_id',
        "type",
        "day_at",
        "specialty",
        "doctor_id"
    ];
    public function referralLetter(): MorphOne
    {
        return $this->morphOne(Image::class, 'imageable');
    }
    public function patient(): BelongsTo
    {
        return $this->belongsTo(MedicalFile::class, "patient_id");
    }
    public function doctor(): BelongsTo
    {
        return $this->belongsTo(User::class, "doctor_id");
    }
    public function consultationPlace(): BelongsTo
    {
        return $this->belongsTo(ConsultationPlace::class);
    }
    public function planningDay(): BelongsTo
    {
        return $this->belongsTo(PlanningDay::class);
    }
}
