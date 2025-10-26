<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Projekt extends Model {
    /** @use HasFactory<\Database\Factories\ProjektFactory> */
    use HasFactory;

    public $timestamps = false;

    protected $table = 'projekte';

    public function aufgaben():HasMany {
        return  $this->hasMany(Aufgabe::class);
    }
}
