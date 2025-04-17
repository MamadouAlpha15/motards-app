<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Motard extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'prenom',
        'telephone',
        'ligne',
        'numero_tuteur',
        'matricule',
        'base_stationnement',
        'photo',
        'slug',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($motard) {
            // Génère un slug unique (UUID)
            $motard->slug = Str::uuid();
        });
    }

    // Pour utiliser "slug" comme clé au lieu de "id"
    public function getRouteKeyName()
    {
        return 'slug';
    }
}
