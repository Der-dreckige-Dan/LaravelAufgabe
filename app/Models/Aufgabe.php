<?php

namespace App\Models;

use App\Enums\AufgabenStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aufgabe extends Model {

    use HasFactory;

    protected $table = 'aufgaben';

    public $timestamps = false;

    protected $fillable = ['title', 'description', 'status'];

    protected string $title;

    protected string $description;

    protected AufgabenStatus $status;

    protected function casts(): array {
        return [
            'status' => AufgabenStatus::class,
        ];
    }
}
