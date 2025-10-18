<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Aufgabe extends Model {

    protected $table = 'aufgaben';

    public $timestamps = false;

    protected string $title;

    protected string $description;

    protected int $status;

    public function users(): BelongsToMany {
        return $this->belongsToMany(User::class);
    }
}
