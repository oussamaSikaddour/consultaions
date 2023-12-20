<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class MedicalFile extends Model
{
    use HasFactory, SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $withCount=['rendezVous'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        "last_name",
        "first_name",
        "code",
        "email",
        "birth_place",
        "birth_date",
        "address",
        "tel",
        "opened_by",
        "establishment_id"
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        "deleted_at"
    ];

    public function openedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, "opened_by");
    }
    public function establishment(): BelongsTo
    {
        return $this->belongsTo(Establishment::class);
    }

    public function rendezVous(): HasMany
    {
        return $this->hasMany(RendezVous::class, "patient_id");
    }
}
