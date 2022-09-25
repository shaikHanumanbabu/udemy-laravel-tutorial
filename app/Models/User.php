<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Storage;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    public function blogPosts()
    {
        return $this->hasMany(BlogPost::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function commentsOn()
    {
        return $this->morphMany(Comment::class, 'commentable')->latest();
    }

    public function image()
    {
        return $this->morphOne(Image::class,  'imageble');
    }

    public function scopeWithMostBlogPosts(Builder $query)
    {
        // return $query->withCount('blogPosts')->orderBy('blog_posts_count', 'desc');
        return $query->withCount('blogPosts')->orderBy('blog_posts_count', 'desc');
    }

    public function scopeWithMostBlogPostsLastMonth(Builder $query)
    {
        // return $query->withCount('blogPosts')->orderBy('blog_posts_count', 'desc');
        return $query->withCount(['blogPosts' => function (Builder $query) {
            return $query->whereBetween(static::CREATED_AT, [now()->modify('-1 month')->format('Y-m-d'), now()]);
        }])
        ->has('blogPosts' , '>=', 2)
        ->orderBy('blog_posts_count', 'desc');
    } 

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'id',
        'email_verified_at',
        'created_at',
        'updated_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function scopeThatHasCommentedOnPost(Builder $query, BlogPost $post)
    {
        return $query->whereHas('comments', function($query) use($post) {
            return $query->where('commentable_id', '=', $post->id)
                        ->where('commentable_type', '=', BlogPost::class);
        });

        // Storage::disk('public')->append('email.txt', "hello world". now());
        // Storage::disk('public')->append('email.txt', $sql->toSql());


    }
}
