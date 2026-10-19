<?php

namespace App\Models;

use Database\Factories\StoredObjectFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['key', 'value', 'timestamp'])]
class StoredObject extends Model
{
    /** @use HasFactory<StoredObjectFactory> */
    use HasFactory;

    protected $table = 'objects';

    public $timestamps = false;

    protected function casts(): array
    {
        return [
            'value' => 'object',
            'timestamp' => 'integer',
        ];
    }
}
