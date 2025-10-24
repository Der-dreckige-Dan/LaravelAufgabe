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
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    protected $fillable = ['title', 'description', 'status'];

    protected string $title;

    protected string $description;

    #[ApiProperty(types: AufgabenStatus::class)]
    protected AufgabenStatus $status;

    protected function casts(): array {
        return [
            'status' => AufgabenStatus::class,
        ];
    }
}
