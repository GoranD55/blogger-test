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
 * @property int $post_id
 * @property string $text
 * @property int|null $parent_id
 * @property DateTime $created_at
 * @property DateTime $updated_at
 * @property User $author
 * @property Post $post
 * @property Comment[] $comments
 */
class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'post_id',
        'text',
        'parent_id'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class, 'parent_id', 'id');
    }
}
