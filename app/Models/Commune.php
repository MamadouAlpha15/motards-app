<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Commune extends Model
{
    protected $fillable = ['nom', 'slug'];

    public function motards()
    {
        return $this->hasMany(Motard::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
