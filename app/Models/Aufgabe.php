<?php

namespace App\Models;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Enums\AufgabenStatus;
use DateTimeImmutable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use SebastianBergmann\CodeCoverage\Report\Xml\Project;

#[ApiResource(
    operations: [
        new GetCollection('/aufgaben'),
        new Post('/aufgaben'),
        new Get('/aufgaben/{id}'),
        new Put('/aufgaben/{id}'),
        new Delete('/aufgaben/{id}'),
    ],
    middleware: 'auth:sanctum',
)]
class Aufgabe extends Model {

    use HasFactory;

    protected $table = 'aufgaben';

    public $timestamps = false;

    protected $fillable = ['title', 'description', 'status', 'deadline'];

    protected string $title;

    protected string $description;

    protected DateTimeImmutable $deadline;

    #[ApiProperty(types: AufgabenStatus::class)]
    protected AufgabenStatus $status;

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
