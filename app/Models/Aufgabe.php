<?php

namespace App\Models;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use App\Enums\AufgabenStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

#[ApiResource]
class Aufgabe extends Model {

    use HasFactory;

    protected $table = 'aufgaben';

    public $timestamps = false;

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
