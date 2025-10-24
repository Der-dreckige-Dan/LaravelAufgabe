<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Projekte extends Model {
    /** @use HasFactory<\Database\Factories\ProjekteFactory> */
    use HasFactory;

    protected $table = 'projekte';

    public function aufgaben():HasMany {
        return  $this->hasMany(Aufgabe::class);
    }
}
