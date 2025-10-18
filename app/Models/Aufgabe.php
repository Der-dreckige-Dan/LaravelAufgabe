<?php

namespace App\Models;

use ApiPlatform\Metadata\ApiResource;
use Illuminate\Database\Eloquent\Model;

class Aufgabe extends Model {

    protected $table = 'aufgaben';

    public $timestamps = false;

    protected string $title;

    protected string $description;

    protected int $status;
}
