<?php

namespace App\Models;

use App\Models\Traits\IsOwnedByTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;

class Blog extends Model
{
    use HasFactory,
        SoftDeletes,
        IsOwnedByTrait;

    protected $fillable = [
        'user_id',
        'name',
        'description',
        'is_public',
    ];

    protected $casts = [
        'is_public' => 'boolean',
    ];

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function scopeSearch(Builder $query, array $searchParams): Builder
    {
        if (isset($searchParams['name']) && !empty($searchParams['name'])) {
            $query->where('name', 'LIKE', '%' . $searchParams['name'] . '%');
        }

        return $query;
    }
}
