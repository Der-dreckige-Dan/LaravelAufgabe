<?php

namespace App\Models;

use App\Enums\AufgabenStatus;
use DateTimeImmutable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Aufgabe extends Model {

    use HasFactory;

    protected $table = 'aufgaben';

    public $timestamps = false;

    protected $fillable = ['title', 'description', 'status', 'deadline'];

    protected string $title;

    protected string $description;

    protected AufgabenStatus $status;

    protected DateTimeImmutable $deadline;

    protected function casts(): array {
        return [
            'status' => AufgabenStatus::class,
        ];
    }

    public function benutzer(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function projekt(): BelongsTo {
        return $this->belongsTo(Project::class);
    }
}
