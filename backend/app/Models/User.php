<?php

namespace App\Models;

use App\Enums\UserRole;
use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * @property-read int $id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property UserRole $role
 * @property string $avatar
 * @property DateTime $created_at
 * @property Blog $blog
 * @property Post[] $posts
 * @property Blog[] $blogSubscriptions
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'role',
        'password',
        'avatar',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'role' => UserRole::class,
    ];

    protected $attributes = [
        'role' => UserRole::Reader,
        'avatar' => '/avatars/default.png',
    ];

    public function blog(): HasOne
    {
        return $this->hasOne(Blog::class)->withTrashed()->latest();
    }

    public function blogs(): HasMany
    {
        return $this->hasMany(Blog::class);
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    public function blogSubscriptions(): BelongsToMany
    {
        return $this->belongsToMany(
            Blog::class,
            'blog_subscribers',
            'user_id',
            'blog_id'
        );
    }

    public function isBlogger(): bool
    {
        return $this->role === UserRole::Blogger;
    }
}
