<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property-read int $id
 * @property int $user_id
 * @property int $blog_id
 * @property string $title
 * @property string $text
 * @property string $categories_ids
 * @property DateTime $created_at
 * @property DateTime $updated_at
 * @property User $author
 * @property Blog $blog
 * @property Comment[] $comments
 */
class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'blog_id',
        'title',
        'text',
        'categories_ids',
    ];

    protected $casts = [
        'categories_ids' => 'json',
    ];

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function blog(): BelongsTo
    {
        return $this->belongsTo(Blog::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function images()
    {
        //todo: morph relation
    }
}
