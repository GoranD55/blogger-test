<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property-read int $id
 * @property string $name
 */
class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];
}
