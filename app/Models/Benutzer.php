<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Benutzer extends Model
{
    /** @use HasFactory<\Database\Factories\BenutzerFactory> */
    use HasFactory;

    public $timestamps = false;

    protected $table = 'benutzer';

    public function aufgaben():HasMany {
        return  $this->hasMany(Aufgabe::class);
    }
}
