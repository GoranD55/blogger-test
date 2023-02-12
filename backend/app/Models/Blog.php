<?php

namespace App\Models;

use App\Models\Traits\IsOwnedByTrait;
use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property-read int $id
 * @property int $user_id
 * @property string $name
 * @property string $description
 * @property bool $is_public
 * @property DateTime $created_at
 * @property DateTime $updated_at
 * @property DateTime $deleted_at
 * @property User $author
 * @property Post[] $posts
 * @property User[] $subscribers
 */
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

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    public function subscribers(): BelongsToMany
    {
        return $this->belongsToMany(
            User::class,
            'blog_subscribers',
            'blog_id',
            'user_id'
        );
    }

    public function scopeSearch(Builder $query, array $searchParams): Builder
    {
        if (isset($searchParams['name']) && !empty($searchParams['name'])) {
            $query->where('name', 'LIKE', '%' . $searchParams['name'] . '%');
        }

        return $query;
    }
}
